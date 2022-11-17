<?php
/**
 *  app/Repositories/Eloquent/CategoryRepository.php
 *
 * Date-Time: 07.06.21
 * Time: 17:02
 * @author Insite LLC <hello@insite.international>
 */

namespace App\Repositories\Eloquent;


use App\Models\Category;
use App\Repositories\CategoryRepositoryInterface;
use App\Repositories\Eloquent\Base\BaseRepository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Class LanguageRepository
 * @package App\Repositories\Eloquent
 */
class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    /**
     * CategoryRepository constructor.
     *
     * @param \App\Models\Category $model
     */
    public function __construct(Category $model)
    {
        parent::__construct($model);
    }



    public function getCategoryTree($id = null)
    {
        return $id
            ? $this->model::orderBy('position', 'ASC')->where('id', '!=', $id)->get()->toTree()
            : $this->model::orderBy('position', 'ASC')->get()->toTree();
    }

    /**
     * Specify category tree.
     *
     * @param  int  $id
     * @return \Illuminate\Support\Collection
     */
    public function getCategoryTreeWithoutDescendant($id = null)
    {
        return $id
            ? $this->model::orderBy('position', 'ASC')->where('id', '!=', $id)->whereNotDescendantOf($id)->get()->toTree()
            : $this->model::orderBy('position', 'ASC')->get()->toTree();
    }

    /**
     * get visible category tree.
     *
     * @param  int  $id
     * @return \Illuminate\Support\Collection
     */
    public function getVisibleCategoryTree($id = null)
    {
        static $categories = [];

        if (array_key_exists($id, $categories)) {
            return $categories[$id];
        }

        return $categories[$id] = $id
            ? $this->model::orderBy('position', 'ASC')->where('status', 1)->descendantsAndSelf($id)->toTree($id)
            : $this->model::orderBy('position', 'ASC')->where('status', 1)->get()->toTree();
    }

}
