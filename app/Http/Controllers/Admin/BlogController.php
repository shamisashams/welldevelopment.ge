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
use App\Models\Blog;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\Eloquent\BlogRepository;
use App\Repositories\Eloquent\ProductAttributeValueRepository;
use App\Repositories\ProductRepositoryInterface;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Arr;
use Illuminate\Validation\Rule;
use ReflectionException;
use App\Repositories\Eloquent\AttributeRepository;
use function Symfony\Component\Translation\t;
use Illuminate\Http\Request;

class BlogController extends Controller
{


    private $attributeRepository;

    private $blogRepository;

    private $categories;
    public function __construct(
        BlogRepository $blogRepository
    )
    {
        $this->blogRepository = $blogRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index(ProductRequest $request)
    {
        /*return view('admin.pages.product.index', [
            'products' => $this->productRepository->getData($request, ['translations', 'categories'])
        ]);*/

        return view('admin.nowa.views.blog.index', [
            'data' => $this->blogRepository->getData($request, ['translations'])
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $blog = $this->blogRepository->model;





        $url = locale_route('blog.store', [], false);
        $method = 'POST';

        /*return view('admin.pages.product.form', [
            'product' => $product,
            'url' => $url,
            'method' => $method,
            'categories' => $this->categories
        ]);*/

        return view('admin.nowa.views.blog.form', [
            'blog' => $blog,
            'url' => $url,
            'method' => $method,
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
        $request->validate([
            'slug' => ['required', 'alpha_dash', Rule::unique('blogs', 'slug')],
        ]);
        //dd($request->all());
        $saveData = Arr::except($request->except('_token'), []);




        $product = $this->blogRepository->create($saveData);

        // Save Files
        if ($request->hasFile('images')) {
            $product = $this->blogRepository->saveFiles($product->id, $request);
        }






        return redirect(locale_route('blog.index', $product->id))->with('success', __('admin.create_successfully'));

    }

    /**
     * Display the specified resource.
     *
     * @param string $locale
     * @param Product $product
     *
     * @return Application|Factory|View
     */
    public function show(string $locale, Product $product)
    {
        return view('admin.pages.product.show', [
            'product' => $product,
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
    public function edit(string $locale, Blog $blog)
    {
        $url = locale_route('blog.update', $blog->id, false);
        $method = 'PUT';

        /*return view('admin.pages.product.form', [
            'product' => $product,
            'url' => $url,
            'method' => $method,
            'categories' => $this->categories
        ]);*/

        return view('admin.nowa.views.blog.form', [
            'blog' => $blog,
            'url' => $url,
            'method' => $method,
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
    public function update(Request $request, string $locale, Blog $blog)
    {
        $request->validate([
            'slug' => ['required', 'alpha_dash', Rule::unique('blogs', 'slug')->ignore($blog->id)],
        ]);
        //dd($request->all());
        $saveData = Arr::except($request->except('_token'), []);


        //dd($saveData);

        //dd($attributes);

        $this->blogRepository->update($blog->id, $saveData);

        $this->blogRepository->saveFiles($blog->id, $request);








        return redirect(locale_route('blog.index', $blog->id))->with('success', __('admin.update_successfully'));
    }


    public function getProducts(Request $request){
        $params = $request->all();
        if(isset($params['term'])){
            $query = Product::where(function ($tQ) use ($params){
                $tQ->whereTranslationLike('title', '%'.$params['term'].'%')
                    ->orWhereTranslationLike('description', '%'.$params['term'].'%');
            });

        }
        $query->where('parent_id',null);

        $data = $query->limit(10)->get();

        $li = '';
        foreach ($data as $item){
            $li .= '<li>';
            $li .= '<a href="javascript:void(0)" data-sel_product="'. $item->id .'">';
            $li .= $item->title;
            $li .= '</a>';
            $li .= '</li>';
        }

        return $li;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param string $locale
     * @param Product $product
     * @return Application|RedirectResponse|Redirector
     */
    public function destroy(string $locale, Blog $blog)
    {
        if (!$this->blogRepository->delete($blog->id)) {
            return redirect(locale_route('blog.index', $blog->id))->with('danger', __('admin.not_delete_message'));
        }
        return redirect(locale_route('blog.index'))->with('success', __('admin.delete_message'));
    }
}
