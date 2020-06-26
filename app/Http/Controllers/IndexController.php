<?php

namespace App\Http\Controllers;

use App\Events\UserConnected;
use App\Models\Comment;
use App\Models\Email;
use App\Models\User;
use App\Models\WishlistProduct;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Services\SliderTopProduct;

class IndexController extends BaseController
{
    public function __invoke(CategoryRepository $categoryRepository)
    {
       // return event(new UserConnected('sad', 'sdasd'));

        // return \Session::forget(['multi_image', 'single_image']);
       //return \Auth::logout();

        //dd(Comment::selectRaw('SUM(`rating`) as sum, COUNT(`rating`) as count')->where('product_id', 2)->first());

       // dd(session('authenticate-user'));
       // \Category::flush();
        //dd(\Category::getTree());
      //  session()->forget('authenticate-user');
       // dd(\Mail::to('evdokimov99@mail.ua')->send(new \App\Mail\ConfirmMail('asd', 'a')));
        $htmlButtonSlider = $categoryRepository->getFourCategory();
        $productSlider = app(SliderTopProduct::class)->get($htmlButtonSlider->pluck('id'));
        $dataCarusel = config('custom.data_id_carusel_index_page');
        return view('index.index', compact('htmlButtonSlider', 'productSlider', 'dataCarusel'));
    }
}
