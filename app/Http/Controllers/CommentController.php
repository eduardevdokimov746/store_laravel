<?php

namespace App\Http\Controllers;

use App\Extensions\CommentData;
use App\Extensions\CommentExtension;
use App\Http\Requests\AddCommentRequest;
use App\Mail\ConfirmMail;
use App\Models\Product;
use App\Models\ProductInfo;
use App\Repositories\CommentRepository;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Services\Comment;
use App\Models\Comment as ModelComment;
use App\Extensions\UserExtension;

class CommentController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth')->except(['store']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CommentRepository $commentRepository, $slug)
    {
        $product = Product::where('slug', $slug)->first();

        if (is_null($product)) {
            return abort(404);
        }

        $comments = $commentRepository->getForShow($product->id, \request()->get('id'));

        $comments->transform(function ($item, $key) {
            return CommentData::changeForShow($item);
        });

        return view('comments.index', compact('comments', 'product'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddCommentRequest $request)
    {
        if (\Auth::guest()) {

            //Если не пользователь авторизован

            if(UserExtension::checkExistsWithEmail($request->get('email'))){
                //Если аккаунт существует
                return JsonResponse::create('mail_exists', 200);
            }

            $user = UserExtension::createForComment($request->only(['name', 'email']));

            if ($user instanceof Authenticatable) {
                \Mail::to($user->email->email)->send(new ConfirmMail($user));
                \Auth::login($user);
            } else {
                return abort(422);
            }
        }

        $comment = Comment::add($request);

        $comment['type'] = 'success';
        $comment['name'] = \Auth::user()->name;

        return response($comment, 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function like(Request $request, $comment_id)
    {
        $comment = new Comment(\Auth::id(), $comment_id);
        $comment->like();

        if ($request->wantsJson()) {
            return response(json_encode(''), 200);
        }

        return response('', 200);
    }

    public function dislike(Request $request, $comment_id)
    {
        $comment = new Comment(\Auth::id(), $comment_id);
        $comment->dislike();

        if ($request->wantsJson()) {
            return response(json_encode(''), 200);
        }

        return response('', 200);
    }
}
