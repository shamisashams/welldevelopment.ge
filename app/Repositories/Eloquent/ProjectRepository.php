<?php
/**
 *  app/Repositories/Eloquent/ProductRepository.php
 *
 * Date-Time: 30.07.21
 * Time: 10:36
 * @author Insite LLC <hello@insite.international>
 */

namespace App\Repositories\Eloquent;


use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\Project;
use App\Repositories\Eloquent\Base\BaseRepository;
use App\Repositories\ProductRepositoryInterface;

/**
 * Class LanguageRepository
 * @package App\Repositories\Eloquent
 */
class ProjectRepository extends BaseRepository
{


    private $attributeRepository;

    public function __construct(Project $model,AttributeRepository $attributeRepository)
    {
        parent::__construct($model);
        $this->attributeRepository = $attributeRepository;
    }






    public function getAll($categoryId = null, $popular = null, $special = null, $new = null){


        //dd(request()->post());
        $params = request()->input();

        $query =  $this->model->select('products.*')
            ->leftJoin('product_categories', 'product_categories.product_id', '=', 'products.id')
            ->leftJoin('product_attribute_values','product_attribute_values.product_id','products.id');

        if ($categoryId) {
            $query->whereIn('product_categories.category_id', explode(',', $categoryId));
        }

        if ($popular){
            $query->where('products.popular', 1);
        }

        if ($special){
            $query->where('products.special_price_tag', 1);
        }

        if ($new){
            $query->where('products.new', 1);
        }

        if(isset($params['term'])){
            $query->where(function ($tQ) use ($params){
                $tQ->whereTranslationLike('title', '%'.$params['term'].'%')
                    ->orWhereTranslationLike('description', '%'.$params['term'].'%');
            });

        }


        # sort direction
        $orderDirection = 'asc';
        $sortOptions = ['created_at','desc'];
        if (isset($params['order']) && in_array($params['order'], ['desc', 'asc'])) {
            $orderDirection = $params['order'];
        } else {


            $orderDirection = ! empty($sortOptions) ? $sortOptions[1] : 'asc';
        }

        if (isset($params['sort'])) {
            if($params['sort'] == 'title')
                $query->orderByTranslation('title',$orderDirection);
            else
            $query->orderBy($params['sort'], $orderDirection);
        } else {

            if (! empty($sortOptions)) {
                $query->orderBy($sortOptions[0], $orderDirection);
            }
        }


        if($priceFilter = request('price')){
            $priceRange = explode(',', $priceFilter);

            $query->where(function ($pQ) use ($priceRange){
                $pQ->where('products.price', '>=', $priceRange[0])
                    ->where('products.price', '<=', end($priceRange));
            });

        }


        $attributes = $this->attributeRepository->getFilterAttributes(array_keys(request()->except('price') ? request()->except('price') : []));
        //dd($attributes);
        if (count($attributes) > 0) {
            $query->where(function ($fQ) use ($attributes) {
                foreach ($attributes as $attribute) {
                    $fQ->orWhere(function ($aQ) use ($attribute) {
                        $column = 'product_attribute_values.' . ProductAttributeValue::$attributeTypeFields[$attribute->type];

                        $filterInputValues = explode(',', request()->get($attribute->code));

                        //dump($column,$attribute->type,$filterInputValues);

                        //dd($filterInputValues);
                        $aQ->where('product_attribute_values.attribute_id', $attribute->id);

                        $aQ->where(function ($attributeValueQuery) use ($column, $filterInputValues,$attribute) {

                            if($attribute->type !== 'boolean'){
                                foreach ($filterInputValues as $filterValue) {
                                    if (!is_numeric($filterValue)) {
                                        continue;
                                    }
                                    $attributeValueQuery->orWhereRaw("find_in_set(?, {$column})", [$filterValue]);
                                }
                                //dd('ff');
                            } else {
                                //dd('dd');
                                if (is_numeric($filterInputValues[0])) {
                                    $attributeValueQuery->whereRaw("find_in_set(?, {$column})", [1]);
                                }

                            }

                        });
                    });


                }
            });
        }

        $query->groupBy('products.id');
        return $query->with('latestImage')->paginate('16')->withQueryString();
    }


    public function getMaxPrice(){
        return $this->model->max('price');
    }
    public function getMinPrice(){
        return $this->model->min('price');
    }


    public function search($term){
        return $this->model->whereTranslationLike('title', '%'.$term.'%')
            ->orWhereTranslationLike('description', '%'.$term.'%')
            ->with('latestImage')->paginate(16);
    }


}
