<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ImageProductController extends BaseController
{
    public function __construct()
    {
    }

    public function single(Request $request)
    {
        $rules = [
            'upload' => 'mimes:gif,png,jpeg,pjpeg,x-png|max:1048576|'
        ];

        $validator = \Validator::make($request->only('upload'), $rules);

        if ($validator->fails()) {
            return $validator->getMessageBag();
        }

        $file_path = $request->file('single')->store('tmp', 'public');

        \Session::put('single_image', $file_path);

        return JsonResponse::create(['file' => $file_path], 200);
    }

    public function multi(Request $request)
    {
        $rules = [
            'upload' => 'mimes:gif,png,jpeg,pjpeg,x-png|max:1048576|'
        ];

        $validator = \Validator::make($request->only('upload'), $rules);

        if ($validator->fails()) {
            return $validator->getMessageBag();
        }

        $file_path = $request->file('multi')->store('tmp', 'public');

        \Session::push('multi_image', $file_path);

        return JsonResponse::create(['file' => $file_path], 200);
    }
}
