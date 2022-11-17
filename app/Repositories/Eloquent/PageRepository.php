<?php
/**
 *  app/Repositories/Eloquent/ProductRepository.php
 *
 * Date-Time: 30.07.21
 * Time: 10:36
 * @author Vakho Batsikadze <vakhobatsikadze@gmail.com>
 */

namespace App\Repositories\Eloquent;


use App\Models\Page;
use App\Repositories\Eloquent\Base\BaseRepository;
use App\Repositories\PageRepositoryInterface;


class PageRepository extends BaseRepository implements PageRepositoryInterface
{
    /**
     * @param Page $model
     */
    public function __construct(Page $model)
    {
        parent::__construct($model);
    }


}
