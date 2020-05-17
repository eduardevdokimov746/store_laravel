<?php

namespace App\Services;

use App\Interfaces\IComparisonProvider;
use App\Repositories\ProductRepository;

class Comparison
{
    protected $provider;

    public function __construct(IComparisonProvider $provider)
    {
        $this->provider = $provider;
    }

    public function has($id)
    {
        if ($this->provider->has()) {
            $product_ids = $this->provider->get();

            if (strpos($product_ids, ',')) {
                $ids = collect(explode(',', $product_ids));
            } else {
                $ids = collect($product_ids);
            }

            if ($ids->search($id) !== false) {
                return true;
            }
        }

        return false;
    }
}
