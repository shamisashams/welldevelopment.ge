<?php
/**
 *  app/Repositories/Eloquent/ProductRepository.php
 *
 * Date-Time: 30.07.21
 * Time: 10:36
 * @author Insite LLC <hello@insite.international>
 */

namespace App\Repositories\Eloquent;


use App\Models\City;
use App\Models\Detail;
use App\Models\Product;
use App\Models\Slider;
use App\Models\Stock;
use App\Repositories\Eloquent\Base\BaseRepository;
use App\Repositories\SliderRepositoryInterface;

/**
 * Class LanguageRepository
 * @package App\Repositories\Eloquent
 */
class DetailRepository extends BaseRepository
{

    public function __construct(Detail $model)
    {
        parent::__construct($model);
    }

}