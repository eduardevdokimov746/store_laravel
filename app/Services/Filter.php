<?php

namespace App\Services;

class Filter
{
    protected $category_id;
    protected $request;
    protected $cache_name_prefix = 'filter_cache';
    protected $cache_name;
    protected $cache_expired = 10080;
    protected $groups;
    protected $groups_values;

    public function __construct($request, $category_id)
    {

        $this->request = $request;
        $this->category_id = $category_id;
        $this->init();
    }

    protected function init()
    {
        $this->cache_name = $this->getCacheName();
        $this->setData();
    }

    protected function setData()
    {
        $this->clearCache();

        $filter_data = \Cache::remember($this->cache_name, $this->cache_expired, function () {
            $cache['groups'] = $this->getGroupsDb();
            $cache['groups_values'] = $this->getGroupsValuesDb();
            return $cache;
        });

        $this->groups = $filter_data['groups'];
        $this->groups_values = $filter_data['groups_values'];
    }

    public function isNotEmpty()
    {
        return $this->groups && $this->groups_values;
    }

    public function getValuesGroup($group_id)
    {
        if ($this->hasGroup($group_id)) {
            return $this->groups_values[$group_id];
        }

        return null;
    }

    public function hasGroup($id)
    {
        return (collect($this->groups)->pluck('id')->search($id) !== false);
    }

    public function hasValue($group_id, $value_id)
    {
        if ($this->hasGroup($group_id)) {
            return (collect($this->groups_values[$group_id])->keys()->search($value_id) !== false);
        }

        return false;
    }

    public function isGetFilters($id)
    {
        if ($this->issetGet()) {
            $filters_id = $this->getParam();

            return in_array($id, $filters_id);
        }
        return false;
    }

    protected function getGroupsDb()
    {
        $result = \DB::select('SELECT * FROM `filter_group` WHERE `category_id`=?', [$this->getCategoryId($this->category_id)]);

        return !empty($result) ? $result : null;
    }

    protected function getGroupsValuesDb()
    {
        $data = \DB::select("SELECT * FROM filter_value WHERE group_id IN (SELECT id FROM filter_group WHERE category_id=?)", [$this->getCategoryId($this->category_id)]);

        foreach ($data as $key => $value) {
            $result[$value->group_id][$value->id] = $value->value;
        }

        return isset($result) ? $result : null;
    }

    protected function getCacheName()
    {
        return $this->cache_name_prefix . $this->category_id;
    }

    public function getProducts($productRepository, $sort)
    {
        if ($this->issetGet()) {
            $filters_id = $this->getParam();

            $countGroup = $this->getCountGroups($filters_id);

            $product_ids_filtered = $this->getProductIdFromFilter($filters_id, $countGroup);

            $result = $productRepository->getWhereCategoriesWithFilter(
                $this->category_id, 
                $sort, 
                $product_ids_filtered);
            
        } else {
            $result = $productRepository->getWhereCategories($this->category_id, $sort);
        }

        return $result;
    }

    protected function getProductIdFromFilter($filters_id, $countGroup)
    {
        return \DB::table('filter_product')
            ->select('product_id')
            ->whereIn('filter_value_id', $filters_id)
            ->groupBy('product_id')
            ->havingRaw('COUNT(product_id)=?', [$countGroup])->pluck('product_id');
    }

    protected function getCategoryId($category_id)
    {
        if ($this->isNotebook()) {
            return 6;
        }

        return $category_id;
    }

    protected function getParam()
    {
         $result = preg_replace("#[^\d,]+#", '', $this->request->input('filter'));
         return explode(',', trim($result, ','));
    }

    public function getCountGroups($filters_id)
    {
        $attrs = $this->getValues();

        if (is_null($attrs)) return null;

        $count = 0;

        foreach ($attrs as $key => $item) {
            foreach ($item as $k => $v) {
                if (in_array($k, $filters_id)) {
                    $count++;
                    break;
                }
            }
        }
        return $count;
    }

    public function getValues()
    {
        return $this->groups_values;
    }

    public function getGroups()
    {
        if (empty($this->groups)) {
            return null;
        }

        return $this->groups;
    }

    protected function issetGet()
    {
        return $this->request->filled('filter');
    }

    protected function isNotebook()
    {
        return \Category::isNotebook($this->category_id);
    }

    public function clearCache()
    {
        \Cache::forget($this->cache_name);
    }
}
