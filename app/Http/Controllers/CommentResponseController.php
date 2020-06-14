<?php

namespace App\Http\Controllers;

use App\Extensions\UserExtension;
use App\Http\Requests\AddCommentRequest;
use App\Mail\ConfirmMail;
use App\Services\CommentResponse;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommentResponseController extends BaseController
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
    public function index(Request $request, $comment_id)
    {
        $comments = CommentResponse::get($comment_id);

        if ($comments->isNotEmpty()) {
            if($request->get('getAll') == 'false'){
                $response['checkAll'] = ($comments->count() > 3) ? true : false;
                $comments = $comments->slice(0, 3);
                $response['hrefGetAll'] = url('comments/' . $request->get('slug') . '?id=' . $comment_id);
            }else{
                $response['checkAll'] = false;
            }

            $response['comments'] = $comments;

            return JsonResponse::create($response, 200);

        }

        return abort(422);
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
    public function store(Request $request)
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

        CommentResponse::add($request);

        $result['type'] = 'success';

        return JsonResponse::create($result, 200);
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
}
