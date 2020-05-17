<?php

namespace App\Repositories;

use App\Models\Category as Model;

class CategoryRepository extends CoreRepository
{
    public function __construct(Model $model)
    {
        $this->setModel($model);
    }

    public function getFourCategory()
    {
        $visibleCategoryTitles = config('custom.category_index_page_slider');

        $visibleCategory = $this->startConditions()->select('id', 'title')->whereIn('slug', $visibleCategoryTitles)->orderBy('id')->get();

        return $visibleCategory;
    }

    public function getChild($id)
    {
        $result = $this->startConditions()->where('parent_id', $id)->get();

        return $result;
    }

    public function getIdChild($id)
    {
        $result = $this->startConditions()->select('id')->where('parent_id', $id)->get();

        return $result;
    }


}
