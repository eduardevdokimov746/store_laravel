<?php

namespace App\Extensions;

use Illuminate\Http\Request;
use App\Models\Product as Model;
use PhpParser\Node\Expr\AssignOp\Mod;

class ProductExtension
{
    protected static $category_id;
    protected const NO_IMAGE_NAME = 'no_image.jpg';

    protected static function init(Request $request)
    {
        self::$category_id = $request->get('category_id');
    }

    public static function add(Request $request) : Model
    {
        self::init($request);

        $product_data = self::validateProductData($request);

        $product_info_data = self::validateProductInfoData($request);

        if (is_null($product = Model::create($product_data))) {
            self::flushSessionImage();
            return null;
        }

        if (is_null($product->info()->create($product_info_data))) {
            self::flushSessionImage();
            $product->delete();
            return null;
        }

        self::moveImages();
        self::flushSessionImage();

        return $product;
    }

    public static function update(Request $request, Model $product) : bool
    {
        self::init($request);

        $product_data = self::validateProductData($request);
        unset($product_data['img']);

        $product_info_data = self::validateProductInfoData($request);
        unset($product_info_data['hrefs_img']);

        $product->fill($product_data);
        $product->info->fill($product_info_data);

        if (!$product->push()) {
            return false;
        }

        return true;
    }

    protected static function moveImages() : void
    {
        $all_images = self::getAllImages();

        if (!is_null($all_images['main'])) {
            $main_path = 'images/' . self::getImagePath($all_images['main']);
            \Storage::move($all_images['main'], $main_path);
        }

        if (!is_null($all_images['gallery'])) {
            foreach ($all_images['gallery'] as $image) {
                $image_path = 'images/' . self::getImagePath($image);
                \Storage::move($image, $image_path);
            }
        }
    }

    protected static function flushSessionImage() : void
    {
        \Session::forget(['single_image', 'multi_image']);
    }

    protected static function getImagePath($image_name = null) : string
    {
        if (is_null($image_name)) {
            $result = 'no_image.jpg';
        } else {
            $image_name = preg_replace('#tmp/#', '', $image_name);

            $result = \Category::get(self::$category_id)['slug'] . '/' . $image_name;
        }

        return $result;
    }

    protected static function getAllImages() : array
    {
        $images = [];

        if (\Session::has('single_image')) {
            $images['main'] = \Session::get('single_image');
        } else {
            $images['main'] = null;
        }

        if (\Session::has('multi_image')) {
            $images['gallery'] = \Session::get('multi_image');
        } else {
            $images['gallery'] = null;
        }

        return $images;
    }

    protected static function getGallery() : string
    {
        $arr_img_path = [];
        $gallery = self::getAllImages()['gallery'];

        if (is_null($gallery)) {
            $result = self::getImagePath();
        } else {
            foreach ($gallery as $img) {
                $arr_img_path[] = self::getImagePath($img);
            }
            $result = implode(',', $arr_img_path);
        }

        return $result;
    }

    protected static function validateProductData(Request $request) : array
    {
        $data['is_published'] = $request->has('is_published') ? 1 : 0;
        $data['hit'] = $request->has('hit') ? 1 : 0;
        $data['new'] = $request->has('new') ? 1 : 0;
        $data['slug'] = $request->filled('slug') ? $request->get('slug') : \Str::slug($request->get('title'));
        $data['img'] = self::getImagePath(self::getAllImages()['main']);

        return array_merge($data, $request->only(['title', 'category_id', 'price', 'old_price']));
    }

    protected static function validateProductInfoData(Request $request) : array
    {
        $gallery_img = self::getGallery();

        $data['hrefs_img'] = $gallery_img;

        return array_merge($data, $request->only(['little_specifications', 'big_specifications']));
    }

    public static function delete(Model $product) : bool
    {
        $array_images_path = self::getAllImagesProduct($product);

        if (!$product->delete()) {
            return false;
        }

        if (!empty($array_images_path)) {
            \Storage::delete($array_images_path);
        }

        return true;
    }

    protected static function getAllImagesProduct(Model $product) : array
    {
        $images = [];
        $arr_gallery = [];

        if ($product->img !== self::NO_IMAGE_NAME) {
            $images[] = 'images/' . $product->img;
        }

        if ($product->info->hrefs_img !== self::NO_IMAGE_NAME) {
            $arr_gallery = explode(',', $product->info->hrefs_img);

            array_walk($arr_gallery, function (&$item, $key) {
                $item = 'images/' . $item;
            });
        }

        return array_merge($images, $arr_gallery);
    }
}
