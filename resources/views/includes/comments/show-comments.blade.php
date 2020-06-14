<div class='list_comments {{ $comments->isEmpty() ? 'disactive' : '' }}' class='active'>

    <ul>
        @foreach ($comments as $comment)
            @if($comment->type == 'otzuv')
                <li data-id='{{ $comment->id }}'>
                    <div>
                        <b class="name_user">{{ $comment->user->name }}</b>
                        <div class='widget_stars'>
                            <ul>
                                @for($x = 1; $x < 6; $x++)
                                    @if($x <= $comment->rating)
                                        <li><i class="fa fa-star" style='color: #0280e1;'
                                               aria-hidden="true"></i></li>
                                    @else
                                        <li><i class="fa fa-star-o" style='color: #0280e1;'
                                               aria-hidden="true"></i></li>
                                    @endif
                                @endfor
                            </ul>
                        </div>
                        <span class='date_comment'>{{ $comment->datePublication }}</span>
                    </div>

                    <p style="clear: left;">{{ $comment->comment }}</p>
                    <p>
                        <b style="color: black;">Достоинства: </b>{{ $comment->good_comment }}
                    </p>
                    <p>
                        <b style="color: black;">Недостатки: </b>{{ $comment->bad_comment }}
                    </p>
                    <div style="margin-top: 10px;" class='footer_comment'>
                        <div style="margin-top: 10px;" class='footer_response'>
                            <button class='btn_response_comment'>&#8617;&nbsp;Ответить</button>
                            @if($comment->response_comment_count > 0)
                                <p class='btn_view_responses'>
                                    <i class="far fa-comment"></i>
                                    <span>{{ $comment->response_comment_count }}</span>&nbsp;ответ
                                </p>
                            @endif
                            <div class='block_like_dislike'>
                                <small
                                    class='c_like {{ $comment->likes->isPress ? 'press' : 'counter-like' }} counter-like-dislike'>{{($comment->likes_count > 0) ? $comment->likes_count : '' }}
                                </small>&nbsp;<i
                                    class="fas fa-thumbs-up {{ $comment->likes->isPress ? 'press' : 'like' }}"
                                    data-type='{{ $comment->likes->isPress ? 'disable' : 'enable' }}'></i>&nbsp;|&nbsp;
                                <i class="fas fa-thumbs-down {{ $comment->dislikes->isPress ? 'press' : 'dislike' }}"
                                   data-type='{{ $comment->dislikes->isPress ? 'disable' : 'enable' }}'></i>&nbsp;<small
                                    class='c_dis counter-like-dislike {{ $comment->dislikes->isPress ? 'press' : 'counter-dislike' }}'>{{($comment->dislikes_count > 0) ? $comment->dislikes_count : '' }}</small>
                            </div>
                        </div>
                    </div>
                </li>
            @else
                <li data-id='{{ $comment->id }}'>
                    <div>
                        <b class="name_user">{{ $comment->user->name }}</b>
                        <span class='date_comment'>{{ $comment->datePublication }}</span>
                    </div>
                    <p style="clear: left;">{{ $comment->comment }}</p>
                    <div style="margin-top: 10px;" class='footer_comment'>
                        <div style="margin-top: 10px;" class='footer_response'>
                            <button class='btn_response_comment'>&#8617;&nbsp;Ответить</button>

                            @if($comment->response_comment_count > 0)
                                <p class='btn_view_responses'>
                                    <i class="far fa-comment"></i>
                                    <span>{{ $comment->response_comment_count }}</span>&nbsp;ответ
                                </p>
                            @endif

                            <div class='block_like_dislike'>

                                <small
                                    class='c_like {{ $comment->likes->isPress ? 'press' : 'counter-like' }} counter-like-dislike'>{{($comment->likes_count > 0) ? $comment->likes_count : '' }}
                                </small>&nbsp;<i
                                    class="fas fa-thumbs-up {{ $comment->likes->isPress ? 'press' : 'like' }}"
                                    data-type='{{ $comment->likes->isPress ? 'disable' : 'enable' }}'></i>&nbsp;|&nbsp;
                                <i class="fas fa-thumbs-down {{ $comment->dislikes->isPress ? 'press' : 'dislike' }}"
                                   data-type='{{ $comment->dislikes->isPress ? 'disable' : 'enable' }}'></i>&nbsp;<small
                                    class='counter-like-dislike c_dis {{ $comment->dislikes->isPress ? 'press' : 'counter-dislike' }}'>{{($comment->dislikes_count > 0) ? $comment->dislikes_count : '' }}</small>
                            </div>
                        </div>
                    </div>
                </li>
            @endif
        @endforeach
    </ul>
</div>
<!-- Блок просмотра комментариев -->
