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
use App\Repositories\AttributeRepositoryInterface;
use App\Repositories\Eloquent\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;


/**
 * Class LanguageRepository
 * @package App\Repositories\Eloquent
 */
class AttributeRepository extends BaseRepository implements AttributeRepositoryInterface
{

    protected $attributeOptionRepository;
    /**
     * @param \App\Models\Product $model
     */
    public function __construct(Attribute $model, AttributeOptionRepository $attributeOptionRepository)
    {
        parent::__construct($model);

        $this->attributeOptionRepository = $attributeOptionRepository;
    }


    public function create(array $data = []): Model{

        $options = isset($data['options']) ? $data['options'] : [];

        unset($data['options']);

        $attribute = $this->model->create($data);

        if (in_array($attribute->type, ['select', 'multiselect', 'checkbox']) && count($options)) {
            foreach ($options as $optionInputs) {
                $this->attributeOptionRepository->create(array_merge([
                    'attribute_id' => $attribute->id,
                ], $optionInputs));
            }
        }

        return $attribute;
    }


    public function update(int $id, array $data = [])
    {

        //dd($data);

        $attribute = $this->model->find($id);


        $attribute->update($data);

        if (in_array($attribute->type, ['select', 'multiselect', 'checkbox'])) {
            if (isset($data['options'])) {
                foreach ($data['options'] as $optionId => $optionInputs) {
                    $isNew = $optionInputs['isNew'] == 'true' ? true : false;

                    if ($isNew) {
                        $this->attributeOptionRepository->create(array_merge([
                            'attribute_id' => $attribute->id,
                        ], $optionInputs));
                    } else {
                        $isDelete = $optionInputs['isDelete'] == 'true' ? true : false;

                        if ($isDelete) {
                            $this->attributeOptionRepository->delete($optionId);
                        } else {
                            $this->attributeOptionRepository->update($optionId,$optionInputs);
                        }
                    }
                }
            }
        }


        return $attribute;
    }


    public function getFilterAttributes($codes = null){
        return $this->model->whereIn('code',$codes)->get();
    }

}
