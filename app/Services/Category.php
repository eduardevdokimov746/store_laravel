<?php

namespace App\Services;

use App\Models\Category as Model;

class Category
{
    protected $cacheName = 'categories';
    protected $treeCacheName = 'categories-tree';
    protected $categories;
    protected $categoriesTree;
    protected $expire = 10080 * 2;

    public function __construct()
    {
        $this->init();
    }

    protected function init()
    {
        $this->categories = $this->getAll();
        $this->categoriesTree = $this->getTree();
    }

    public function getAll()
    {
        $categories = \Cache::remember($this->cacheName, $this->expire, function () {
            return Model::select(['id', 'title', 'slug', 'parent_id', 'img'])->get()->keyBy('id')->toArray();
        });

        return $categories;
    }

    public function get($id)
    {
        if ($this->has($id)) {
            return $this->categories[$id];
        }
        return null;
    }

    public function has($id)
    {
        return isset($this->categories[$id]);
    }

    public function getTree()
    {
        $categoriesTree = \Cache::remember($this->treeCacheName, $this->expire, function() {
            return $this->createMainTree();
        });

        return $categoriesTree;
    }

    public function getId($slug)
    {
        return collect($this->categories)->pluck('slug', 'id')->search($slug);
    }

    public function getChildCategories($id)
    {
        return collect($this->categories)->filter(function ($item, $key) use ($id) {
            return $item['parent_id'] == $id;
        })->toArray();
    }

    public function getChildTree($id)
    {
        if ($this->hasChild($id)) {
            return null;
        }
        return $this->createTree($id);
    }

    /**
     * Get tree categories
     *
     * @param string $slug
     *
     * @return array|null
     */
    public function getChildTreeFromSlug($slug)
    {
        if (($id = $this->getId($slug)) === false) {
            return null;
        }

        if (!$this->hasChild($id)) {
            return null;
        }

        return $this->createTree($id);
    }

    public function getCurrentWithChild($slug)
    {
        if (($id = $this->getId($slug)) === false) {
            return null;
        }

        if (!$this->hasChild($id)) {
            return null;
        }

        if ($this->isMain($id)) {
            $main_category = $this->categoriesTree[$id];
        } else {
            $main_category = $this->getParent($id);
            $main_category['child'][] = $this->createTree($id);
        }

        return $main_category;
    }

    public function getParent($id)
    {
        if (!$this->has($id)) {
            return null;
        }

        return $this->categories[$this->get($id)['parent_id']];
    }

    protected function isMain($id)
    {
        return isset($this->categoriesTree[$id]);
    }

    public function hasChild($id)
    {
        $result = collect($this->categories)
            ->pluck('parent_id', 'id')
            ->search($id) !== false ? true : false;

        return $result;
    }

    protected function createMainTree()
    {
        $tree = [];
        $categories = $this->categories;
        foreach ($categories as $key => &$value) {
            if($value['parent_id'] == 0){
                $tree[$key] = &$value;
            }else{
                $categories[$value['parent_id']]['child'][$key] = &$value;
            }
        }

        return $tree;
    }

    protected function createTree($id)
    {
        $categories = $this->categories;

        foreach ($categories as $key => &$value) {
            if($key == $id) {
                $tree = &$value;
            } elseif ($key == 0) {
                continue;
            } else{
                $categories[$value['parent_id']]['child'][$key] = &$value;
            }
        }

        return $tree;
    }

    public function getParentId($id)
    {
        return collect($this->categories)->pluck('parent_id', 'id')->get($id);
    }

    public function flush()
    {
        \Cache::forget($this->cacheName);
        \Cache::forget($this->treeCacheName);
    }
}
