<?php

namespace App\Http\Controllers;

use App\Repositories\Eloquent\AttributeRepository;
use App\Repositories\Eloquent\CategoryRepository;
use Illuminate\Http\Request;

use App\Repositories\Eloquent\ProductAttributeValueRepository;

use App\Repositories\Eloquent\ProductRepository;

class TestController extends Controller
{
    //
    protected $productAttributeValueRepository;

    protected $attributeRepository;

    protected $productRepository;

    public function __construct(
        ProductAttributeValueRepository $productAttributeValueRepository,
        AttributeRepository $attributeRepository,
        ProductRepository $productRepository
    )
    {
        $this->productAttributeValueRepository = $productAttributeValueRepository;
        $this->attributeRepository = $attributeRepository;
        $this->productRepository = $productRepository;
    }

    public function at(){
        $result = [];
        $attr_values = $this->productAttributeValueRepository->model->all();
        foreach ($attr_values as $item){

            $result[$item->attribute_id][] = $item;


        }
        //$result = array_unique($result);
        dd($result);
    }

    public function attr(){
        $attrs = $this->attributeRepository->model->with('options')->orderBy('position')->get();
        $categories = app(CategoryRepository::class)->getVisibleCategoryTree();
        $maxPrice = $this->productRepository->getMaxprice();

        return view('test',compact('attrs','categories','maxPrice'));
    }

    public function filter(Request $request){
        $products = $this->productRepository->getAll($request->post('category'));
        dd($products);
    }
}
