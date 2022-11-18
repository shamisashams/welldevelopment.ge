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
use App\Models\Apartment;
use App\Models\ApartmentAttributeValue;
use App\Models\Attribute;
use App\Models\Category;
use App\Models\Detail;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\Project;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\Eloquent\ApartmentAttributeValueRepository;
use App\Repositories\Eloquent\ApartmentRepository;
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

class ApartmentController extends Controller
{

    private $apartmentRepository;




    private $attributeRepository;



    private $apartmentAttributeValueRepository;


    public function __construct(
        ApartmentRepository $apartmentRepository,
        AttributeRepository $attributeRepository,
        ApartmentAttributeValueRepository $apartmentAttributeValueRepository
    )
    {
        $this->apartmentRepository = $apartmentRepository;
        $this->attributeRepository = $attributeRepository;
        $this->apartmentAttributeValueRepository = $apartmentAttributeValueRepository;
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

        return view('admin.nowa.views.apartment.index', [
            'data' => $this->apartmentRepository->getData($request, ['translations','project.translation']),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $model = $this->apartmentRepository->model;





        $url = locale_route('apartment.store', [], false);
        $method = 'POST';

        /*return view('admin.pages.product.form', [
            'product' => $product,
            'url' => $url,
            'method' => $method,
            'categories' => $this->categories
        ]);*/

        return view('admin.nowa.views.apartment.form', [
            'model' => $model,
            'url' => $url,
            'method' => $method,
            'projects' => Project::all(),
            'details' =>  Detail::with('translation')->get(),
            'attributes' => $this->attributeRepository->all()
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
            'slug' => ['required', 'alpha_dash', Rule::unique('apartments', 'slug')],
            config('translatable.fallback_locale') . '.title' => 'required',
            'project_id' => 'required'

        ]);

        $saveData = Arr::except($request->except('_token'), []);
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];
        $saveData['action'] = isset($saveData['action']) && (bool)$saveData['action'];
        $saveData['offer'] = isset($saveData['offer']) && (bool)$saveData['offer'];
        //$saveData['not_free'] = isset($saveData['not_free']) && (bool)$saveData['not_free'];

        $attributes = $saveData['attribute'];
        unset($saveData['attribute']);

        $product = $this->apartmentRepository->create($saveData);

        // Save Files
        if ($request->hasFile('images')) {
            $product = $this->apartmentRepository->saveFiles($product->id, $request);
        }


        $product->details()->sync(isset($saveData['detail'])?$saveData['detail']:[]);

        //save product attributes
        $attr = [];
        foreach ($attributes as $key => $item){
            if ($item){
                $attr[$key] = $item;
            }
        }

        $attr_ids = array_keys($attr);

        $_attributes = Attribute::whereIn('id',$attr_ids)->get();

        $arr = [];
        foreach ($_attributes as $item){
            $arr[$item->id] = $item;
        }

        $data = [];
        foreach ($attr as $key => $item){
            $data['apartment_id'] = $product->id;
            $data['attribute_id'] = $arr[$key]->id;
            $data['type'] = $arr[$key]->type;
            if($data['type'] == 'boolean') $data['value'] = (bool)$item;
            else $data['value'] = $item;

            //dd($data);
            $this->apartmentAttributeValueRepository->create($data);
        }




        return redirect(locale_route('apartment.index', $product->id))->with('success', __('admin.create_successfully'));

    }

    /**
     * Display the specified resource.
     *
     * @param string $locale
     * @param Product $product
     *
     * @return Application|Factory|View
     */
    public function show(string $locale, Apartment $apartment)
    {
        return view('admin.pages.apartment.show', [
            'product' => $apartment,
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
    public function edit(string $locale, Apartment $apartment)
    {
        $url = locale_route('apartment.update', $apartment->id, false);
        $method = 'PUT';

        /*return view('admin.pages.product.form', [
            'product' => $product,
            'url' => $url,
            'method' => $method,
            'categories' => $this->categories
        ]);*/

        return view('admin.nowa.views.apartment.form', [
            'model' => $apartment,
            'url' => $url,
            'method' => $method,
            'projects' => Project::all(),
            'details' =>  Detail::with('translation')->get(),
            'attributes' => $this->attributeRepository->all()
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
    public function update(Request $request, string $locale, Apartment $apartment)
    {
        //dd($request->all());

        $request->validate([
            'slug' => ['required', 'alpha_dash', Rule::unique('apartments', 'slug')->ignore($apartment->id)],
            config('translatable.fallback_locale') . '.title' => 'required',
            'project_id' => 'required'
        ]);

        $saveData = Arr::except($request->except('_token'), []);
        $saveData['status'] = isset($saveData['status']) && (bool)$saveData['status'];
        $saveData['action'] = isset($saveData['action']) && (bool)$saveData['action'];
        //$saveData['not_free'] = isset($saveData['not_free']) && (bool)$saveData['not_free'];
        $saveData['offer'] = isset($saveData['offer']) && (bool)$saveData['offer'];


        $attributes = $saveData['attribute'];
        unset($saveData['attribute']);        //dd($attributes);

        $this->apartmentRepository->update($apartment->id, $saveData);

        $this->apartmentRepository->saveFiles($apartment->id, $request);




        $apartment->details()->sync(isset($saveData['detail'])?$saveData['detail']:[]);


        //update product attributes
        $attr = [];
        $attr_del = [];
        foreach ($attributes as $key => $item){
            if ($item){

                $product_atribute = ApartmentAttributeValue::where('apartment_id',$apartment->id)
                    ->where('attribute_id',$key)->first();
                if ($product_atribute){
                    $data['integer_value'] = $item;
                    ApartmentAttributeValue::where('apartment_id',$product_atribute->apartment_id)
                        ->where('attribute_id',$product_atribute->attribute_id)
                        ->update($data);
                } else {
                    $attr[$key] = $item;
                }
            } else $attr_del[] = $key;
        }

        $attr_ids = array_keys($attr);

        $_attributes = Attribute::whereIn('id',$attr_ids)->get();

        $arr = [];
        foreach ($_attributes as $item){
            $arr[$item->id] = $item;
        }

        $data = [];
        foreach ($attr as $key => $item){
            $data['apartment_id'] = $apartment->id;
            $data['attribute_id'] = $arr[$key]->id;
            $data['type'] = $arr[$key]->type;

            if($data['type'] == 'boolean') $data['value'] = (bool)$item;
            else $data['value'] = $item;

            //dd($data);
            $this->apartmentAttributeValueRepository->create($data);
        }


        ApartmentAttributeValue::where('apartment_id',$apartment->id)
            ->whereIn('attribute_id',$attr_del)->delete();




        return redirect(locale_route('apartment.index', $apartment->id))->with('success', __('admin.update_successfully'));
    }


    public function destroy(string $locale, Apartment $apartment)
    {
        if (!$this->apartmentRepository->delete($apartment->id)) {
            return redirect(locale_route('apartment.index', $apartment->id))->with('danger', __('admin.not_delete_message'));
        }
        return redirect(locale_route('apartment.index'))->with('success', __('admin.delete_message'));
    }
}
