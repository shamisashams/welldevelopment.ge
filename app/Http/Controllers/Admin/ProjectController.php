<?php
/**
 *  app/Http/Controllers/Admin/ProductController.php
 *
 * Date-Time: 30.07.21
 * Time: 10:37
 * @author Insite LLC <hello@insite.international>
 */

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\ProductRequest;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\City;
use App\Models\Detail;
use App\Models\District;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\Project;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\Eloquent\ProductAttributeValueRepository;
use App\Repositories\Eloquent\ProjectRepository;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use ReflectionException;
use App\Repositories\Eloquent\AttributeRepository;
use function Symfony\Component\Translation\t;

class ProjectController extends Controller
{
    /**
     * @var ProductRepositoryInterface
     */
    private $projectRepository;

    /**
     * @var CategoryRepositoryInterface
     */
    private $categoryRepository;

    /**
     * @param ProductRepositoryInterface $productRepository
     * @param CategoryRepositoryInterface $categoryRepository
     */

    private $attributeRepository;

    private $productAttributeValueRepository;

    private $categories;
    public function __construct(
        ProjectRepository $projectRepository,
        CategoryRepositoryInterface $categoryRepository,
        AttributeRepository $attributeRepository,
        ProductAttributeValueRepository $productAttributeValueRepository
    )
    {
        $this->projectRepository = $projectRepository;
        $this->categoryRepository = $categoryRepository;
        $this->categories = $this->categoryRepository->getCategoryTree();
        $this->attributeRepository = $attributeRepository;
        $this->productAttributeValueRepository = $productAttributeValueRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(Request $request)
    {
        /*return view('admin.pages.product.index', [
            'products' => $this->productRepository->getData($request, ['translations', 'categories'])
        ]);*/

        return view('admin.nowa.views.project.index', [
            'data' => $this->projectRepository->getData($request, ['translations']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $model = $this->projectRepository->model;





        $url = locale_route('project.store', [], false);
        $method = 'POST';

        /*return view('admin.pages.product.form', [
            'product' => $product,
            'url' => $url,
            'method' => $method,
            'categories' => $this->categories
        ]);*/

        return view('admin.nowa.views.project.form', [
            'model' => $model,
            'url' => $url,
            'method' => $method,
            'details' =>  Detail::with('translation')->get(),
            'cities' => City::with('translation')->get(),
            'districts' => District::with('translation')->get(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductRequest $request
     *
     * @return Application|RedirectResponse|Redirector
     * @throws ReflectionException
     */
    public function store(Request $request)
    {

        //dd($request->all());

        $request->validate([
            'slug' => ['required', 'alpha_dash', Rule::unique('projects', 'slug')],
            config('translatable.fallback_locale') . '.title' => 'required',
            'city_id' => 'required',
            'district_id' => 'required',
        ]);

        $saveData = Arr::except($request->except('_token'), []);
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];




        $product = $this->projectRepository->create($saveData);

        // Save Files
        if ($request->hasFile('images')) {
            $product = $this->projectRepository->saveFiles($product->id, $request);
        }


        $product->details()->sync(isset($saveData['detail'])?$saveData['detail']:[]);



        return redirect(locale_route('project.index', $product->id))->with('success', __('admin.create_successfully'));

    }

    /**
     * Display the specified resource.
     *
     * @param string $locale
     * @param Product $product
     *
     * @return Application|Factory|View
     */
    public function show(string $locale, Project $project)
    {
        return view('admin.pages.product.show', [
            'product' => $project,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param string $locale
     * @param Category $category
     *
     * @return Application|Factory|View
     */
    public function edit(string $locale, Project $project)
    {
        $url = locale_route('project.update', $project->id, false);
        $method = 'PUT';

        /*return view('admin.pages.product.form', [
            'product' => $product,
            'url' => $url,
            'method' => $method,
            'categories' => $this->categories
        ]);*/

        return view('admin.nowa.views.project.form', [
            'model' => $project,
            'url' => $url,
            'method' => $method,
            'details' =>  Detail::with('translation')->get(),
            'cities' => City::with('translation')->get(),
            'districts' => District::with('translation')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductRequest $request
     * @param string $locale
     * @param Product $product
     * @return Application|RedirectResponse|Redirector
     * @throws ReflectionException
     */
    public function update(Request $request, string $locale, Project $project)
    {
        //dd($request->all());

        $request->validate([
            'slug' => ['required', 'alpha_dash', Rule::unique('projects', 'slug')->ignore($project->id)],
            config('translatable.fallback_locale') . '.title' => 'required',
            'city_id' => 'required',
            'district_id' => 'required',
        ]);

        $saveData = Arr::except($request->except('_token'), []);
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];




        //dd($attributes);

        $this->projectRepository->update($project->id, $saveData);

        $this->projectRepository->saveFiles($project->id, $request);

        $project->details()->sync(isset($saveData['detail'])?$saveData['detail']:[]);









        return redirect(locale_route('project.index', $project->id))->with('success', __('admin.update_successfully'));
    }


    public function destroy(string $locale, Project $project)
    {
        if (!$this->projectRepository->delete($project->id)) {
            return redirect(locale_route('project.index', $project->id))->with('danger', __('admin.not_delete_message'));
        }
        return redirect(locale_route('project.index'))->with('success', __('admin.delete_message'));
    }
}
