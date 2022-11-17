<?php
/**
 *  app/Repositories/CategoryRepositoryInterface.php
 *
 * Date-Time: 29.07.21
 * Time: 17:44
 * @author Insite LLC <hello@insite.international>
 */
namespace App\Repositories;


use App\Http\Requests\Admin\CategoryRequest;
use App\Models\Category;

/**
 * Interface CategoryRepositoryInterface
 * @package App\Repositories
 */
interface CategoryRepositoryInterface
{

    /**
     * @param \App\Http\Requests\Admin\CategoryRequest $request
     * @param array $with
     */
    public function getData(CategoryRequest $request, array $with = []);
}