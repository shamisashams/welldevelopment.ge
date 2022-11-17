<?php
/**
 *  app/Repositories/Eloquent/ProductRepository.php
 *
 * Date-Time: 30.07.21
 * Time: 10:36
 * @author Vakho Batsikadze <vakhobatsikadze@gmail.com>
 */

namespace App\Repositories\Eloquent;


use App\Models\Blog;
use App\Models\Page;
use App\Repositories\BlogRepositoryInterface;
use App\Repositories\Eloquent\Base\BaseRepository;



class BlogRepository extends BaseRepository
{
    /**
     * @param Blog $model
     */
    public function __construct(Blog $model)
    {
        parent::__construct($model);
    }


}
