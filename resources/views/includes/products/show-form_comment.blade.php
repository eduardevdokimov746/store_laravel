<!-- Отзыв о товаре -->
<div class='form_add_comment {{ $comments->isEmpty() ? '' : 'disactive' }}' data-id='{{ $product->id }}'>
    <ul class="nav nav-tabs nav-justified" id='tabs'>
        <li role="presentation" style="cursor: pointer;" data-type='kommentariy' class="active"><a
                data-active='active'>Отзыв о товаре</a></li>
        <li role="presentation" style="cursor: pointer;" data-type='otzuv_o_tovare' class=""><a
                data-active=''>Краткий комментарий</a></li>
    </ul>
    <!-- Отзыв о товаре -->
    <div id='otzuv_o_tovare' data-type='otzuv' class="base_form_comment">
        <div style="text-align: center; margin: 20px 0;">
            <div class='stars_block' style="float: none; font-size: 3em;">
                <ul>
                    <li><i class="fas fa-star stars_unchecked" data-count='1'
                           aria-hidden="true"></i><span class='title_star'>Плохой</span></li>
                    <li><i class="fas fa-star stars_unchecked" data-count='2'
                           aria-hidden="true"></i><span class='title_star'>Так себе</span></li>
                    <li><i class="fas fa-star stars_unchecked" data-count='3'
                           aria-hidden="true"></i><span class='title_star'>Нормальный</span></li>
                    <li><i class="fas fa-star stars_unchecked" data-count='4'
                           aria-hidden="true"></i><span class='title_star'>Хороший</span></li>
                    <li><i class="fas fa-star stars_unchecked" data-count='5'
                           aria-hidden="true"></i><span class='title_star'>Отличный</span></li>
                </ul>
            </div>
        </div>
        <form data-toggle="validator" role="form" style="margin-top: 10px;">

            <div class="form-group">
                <label for="inputName" class="control-label">Достоинства</label>
                <input type="text" name='good_comment' class="form-control" id="inputName" required>
            </div>

            <div class="form-group">
                <label for="inputName" class="control-label">Недостатки</label>
                <input type="text" name='bad_comment' class="form-control" id="inputName" required>
            </div>

            <div class="form-group">
                <label for="inputName" class="control-label">Комментарий</label>
                <textarea class="form-control" name='comment' rows="3" required></textarea>
            </div>

            <div class="form-group">
                <label for="inputName" class="control-label">Ваше имя и фамилия</label>
                @auth
                    <input type="text" name='name' value="{{ Auth::user()->name }}"
                           class="form-control" id="inputName" pattern="^\S+\s\S+$" required>
                @else
                    <input type="text" name='name' class="form-control" id="inputName"
                           pattern="^\S+\s\S+$" required>
                @endif
            </div>

            <div class="form-group">
                <label for="inputName" class="control-label">Электронная почта</label>
                @auth
                    <input type="email" name='email' value="{{ Auth::user()->email->email }}"
                           class="form-control" readonly id="inputName" required>
                @else
                    <input type="email" name='email' class="form-control" id="inputName" required>
                @endif
            </div>

            <div class="form-group">
                <label id="container">Уведомлять об ответах по эл. почте
                    <input type="checkbox" checked="checked">
                    <span class="checkmark"></span>
                </label>
            </div>

            <div class="form-group" style="float: right;">
                <button type="submit" class="btn btn-primary">Оставить отзыв</button>
            </div>
        </form>
        <button type="button" class="btn btn-danger close_form_add_comment"
                style="float: right; margin-right: 10px;">Отмена
        </button>
    </div>
    <!-- Отзыв о товаре -->

    <!-- Комментарий -->
    <div id='kommentariy' data-type='comment' class='base_form_comment disactive'
         style="margin-top: 20px">
        <form data-toggle="validator" role="form" style="margin-top: 10px;">
            <div class="form-group">
                <label for="inputName" class="control-label">Комментарий</label>
                <textarea class="form-control" name='comment' rows="3" required></textarea>
            </div>

            <div class="form-group">
                <label for="inputName" class="control-label">Ваше имя и фамилия</label>
                @auth
                    <input type="text" name='name' value="{{ Auth::user()->name }}"
                           class="form-control" id="inputName" pattern="^\S+\s\S+$" required>
                @else
                    <input type="text" name='name' class="form-control" id="inputName"
                           pattern="^\S+\s\S+$" required>
                @endif
            </div>

            <div class="form-group">
                <label for="inputName" class="control-label">Электронная почта</label>
                @auth
                    <input type="email" name='email' value="{{ Auth::user()->email->email }}"
                           class="form-control" readonly id="inputName" required>
                @else
                    <input type="email" name='email' class="form-control" id="inputName" required>
                @endif
            </div>

            <div class="form-group">
                <label id="container">Уведомлять об ответах по эл. почте
                    <input type="checkbox" checked="checked">
                    <span class="checkmark"></span>
                </label>
            </div>

            <div class="form-group" style="float: right;">
                <button type="submit" class="btn btn-primary">Оставить комментарий</button>
            </div>
        </form>
        <button type="button" class="btn btn-danger close_form_add_comment"
                style="float: right; margin-right: 10px;">Отмена
        </button>
    </div>
    <!-- Комментарий -->
</div>
