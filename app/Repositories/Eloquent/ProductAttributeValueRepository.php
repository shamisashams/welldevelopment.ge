<?php
/**
 *  app/Repositories/Eloquent/ProductRepository.php
 *
 * Date-Time: 30.07.21
 * Time: 10:36
 * @author Insite LLC <hello@insite.international>
 */

namespace App\Repositories\Eloquent;



use App\Models\Attribute;
use App\Models\AttributeOption;
use App\Models\ProductAttributeValue;
use App\Repositories\Eloquent\Base\BaseRepository;
use App\Repositories\AttributeOptionRepositoryInterface;
use App\Repositories\ProductAttributeValueRepositoryInterface;
use http\Header;
use Illuminate\Database\Eloquent\Model;


/**
 * Class LanguageRepository
 * @package App\Repositories\Eloquent
 */
class ProductAttributeValueRepository extends BaseRepository implements ProductAttributeValueRepositoryInterface
{

    /**
     * @param \App\Models\Product $model
     */
    public function __construct(ProductAttributeValue $model)
    {
        parent::__construct($model);

    }


    public function create(array $attributes = []): Model
    {

        $data[ProductAttributeValue::$attributeTypeFields[$attributes['type']]] = $attributes['value'];

        $data = array_merge($data,$attributes);

        return $this->model->create($data);
    }


}
