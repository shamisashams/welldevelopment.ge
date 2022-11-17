<?php
/**
 *  app/Repositories/Eloquent/ProductRepository.php
 *
 * Date-Time: 30.07.21
 * Time: 10:36
 * @author Insite LLC <hello@insite.international>
 */

namespace App\Repositories\Eloquent;



use App\Models\AttributeOption;
use App\Repositories\Eloquent\Base\BaseRepository;
use App\Repositories\AttributeOptionRepositoryInterface;



/**
 * Class LanguageRepository
 * @package App\Repositories\Eloquent
 */
class AttributeOptionRepository extends BaseRepository implements AttributeOptionRepositoryInterface
{

    /**
     * @param \App\Models\Product $model
     */
    public function __construct(AttributeOption $model)
    {
        parent::__construct($model);

    }



}
