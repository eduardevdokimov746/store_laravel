<?php

namespace App\Services;

use App\Models\Currency as Model;
use Illuminate\Http\Request;

class Currency
{
    private $current;
    private $all;
    private $code;
    private $view = 'views\includes\currency.blade.php';

    public function __construct()
    {
        $this->all = $this->getAll();
        $this->current = $this->getCurrent();
        $this->code = $this->current->title;
    }

    public function getAll()
    {
        $currencies = \Cache::remember('currencies', 60 * 24 * 2, function () {
            return Model::get()->except(['created_at', 'updated_at', 'deleted_at']);
        });

        return $currencies;
    }

    public function getCurrent()
    {
        if ($this->hasCookie()) {
            $title = $this->getCookie();
            $currency = $this->search($title);
        } else {
            $currency = $this->getBase();
        }

        return $currency;
    }

    protected function hasCookie()
    {
        return request()->hasCookie('currency');
    }

    protected function getCookie()
    {
        return request()->cookie('currency');
    }

    protected function search($title)
    {
        $result = $this->all->filter(function ($item, $key) use ($title){
            return $item->title == $title;
        })->first();

        return $result;
    }

    public function getBase()
    {
        $result = $this->all->filter(function ($item, $key) {
            return $item->base == 1;
        })->first();

        return $result;
    }

    public function getObject($title)
    {
        return $this->search($title);
    }

    public function run()
    {
        include(resource_path($this->view));
    }

    public function getList()
    {
        $currencyTags = config('custom.symbols_currency');

        foreach ($currencyTags as $code => $tag) {
            if ($this->code == $code) {
                $list[] = "<li class='currency'><a class='active' data-curr='{$code}'>{$code}&nbsp;{$tag}</a></li>";
            } else {
                $list[] = "<li class='currency'><a data-curr='{$code}'>{$code}&nbsp;{$tag}</a></li>";
            }
        }

        return implode("\r\n", $list);
    }

    public function isBase()
    {
        return (bool) $this->current->base;
    }

    public function getSymbol()
    {
        $symbol = config('custom.symbols_currency.' . $this->code);

        return $symbol;
    }
}
