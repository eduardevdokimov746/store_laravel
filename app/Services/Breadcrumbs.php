<?php

namespace App\Services;

class Breadcrumbs
{
    private $path;
    private $product_category;
    private $lastItem;

    public function __construct($currentCategory, $lastItem)
    {
        $this->lastItem = $lastItem;
        $this->product_category = $currentCategory;
        $this->path = $this->getCategories($this->product_category);

    }

    private function getCategories($id)
    {
        $categories = \Category::getAll();
        foreach ($categories as $key => $value) {
            if(isset($categories[$id])){
                $result[] = ['title' => $categories[$id]['title'], 'slug' => $categories[$id]['slug']];
                $id = $categories[$id]['parent_id'];
            }else break;
        }

        return array_reverse($result);
    }

    public function getHtml()
    {
        $html = '';
        $last = '';
        $first = "<li><a href='" . route('index') . "'>Главная</a></li>";

        if(!empty($this->lastItem))
            $last = '<li class=\'active\'>'.$this->lastItem.'</li>';

        $html .= $first;
        foreach ($this->path as $item) {
            if($this->lastItem == $item['title']) continue;

            $html .= "<li><a href='" . route('categories.show', $item['slug']) . "'>" . $item['title'] . "</a></li>";
        }
        $html .= $last;

        return $html;
    }
}
