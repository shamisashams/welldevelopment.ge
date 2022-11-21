<?php
/**
 *  app/Repositories/Eloquent/ProductRepository.php
 *
 * Date-Time: 30.07.21
 * Time: 10:36
 * @author Insite LLC <hello@insite.international>
 */

namespace App\Repositories\Eloquent;


use App\Models\Apartment;
use App\Models\ApartmentAttributeValue;
use App\Models\Product;
use App\Models\ProductAttributeValue;
use App\Models\Project;
use App\Repositories\Eloquent\Base\BaseRepository;
use App\Repositories\ProductRepositoryInterface;

/**
 * Class LanguageRepository
 * @package App\Repositories\Eloquent
 */
class ApartmentRepository extends BaseRepository
{


    private $attributeRepository;

    public function __construct(Apartment $model,AttributeRepository $attributeRepository)
    {
        parent::__construct($model);
        $this->attributeRepository = $attributeRepository;
    }






    public function getAll($offer = null){


        //dd(request()->post());
        $params = request()->input();

        $query =  $this->model->select('apartments.*')
            ->leftJoin('projects', 'projects.id', '=', 'apartments.project_id')
        ->leftJoin('cities', 'cities.id', '=', 'projects.city_id')
            ->leftJoin('apartment_attribute_values','apartment_attribute_values.apartment_id','apartments.id');


        if ($offer !== null){
            $query->where('offer',$offer);
        }

        if(isset($params['term'])){
            $query->where(function ($tQ) use ($params){
                $tQ->whereTranslationLike('title', '%'.$params['term'].'%')
                    ->orWhereTranslationLike('description', '%'.$params['term'].'%');
            });

        }

        if (isset($params['city'])){

            $query->whereIn('projects.city_id', explode(',', $params['city']));

        }

        if (isset($params['district'])){

            $query->whereIn('projects.district_id', explode(',', $params['district']));

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


        if($priceFilter = request('area')){
            $priceRange = explode(',', $priceFilter);

            $query->where(function ($pQ) use ($priceRange){
                $pQ->where('apartments.area', '>=', $priceRange[0])
                    ->where('apartments.area', '<=', end($priceRange));
            });

        }


        $attributes = $this->attributeRepository->getFilterAttributes(array_keys(request()->except('area') ? request()->except('area') : []));
        //dd($attributes);
        if (count($attributes) > 0) {
            $query->where(function ($fQ) use ($attributes) {
                foreach ($attributes as $attribute) {
                    $fQ->orWhere(function ($aQ) use ($attribute) {
                        $column = 'apartment_attribute_values.' . ApartmentAttributeValue::$attributeTypeFields[$attribute->type];

                        $filterInputValues = explode(',', request()->get($attribute->code));

                        //dump($column,$attribute->type,$filterInputValues);

                        //dd($filterInputValues);
                        $aQ->where('apartment_attribute_values.attribute_id', $attribute->id);

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


        $query->groupBy('apartments.id');


        return $query->with('latestImage')->paginate('8')->withQueryString();
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
