<div class='widget-chat-modal hidden'>
    <div class='head'>
        <h4>Онлайн консультация</h4>
        <i class="fas fa-minus"></i>
    </div>
    <div class='body'>
        <div class="block-content-msgs hidden">

        </div>

        <form data-toggle="validator" role="form">
            <div class="form-group">
                <label for="name">Как к Вам обращаться</label>
                <input type="text" class="form-control" id="name" placeholder="Имя" required>
            </div>
            <div class="form-group">
                <label for="msg">Опишите проблему</label>
                <textarea class="form-control" rows="4" id="msg" placeholder="Сообщение" required></textarea>
            </div>
            <button type="submit" style="float: right" class="btn btn-primary">Отправить</button>
        </form>
    </div>

    <div class="field-msg hidden">
        <input type="text" placeholder="Сообщение..."><button>
            <i class="fas fa-angle-right"></i>
        </button>
    </div>
</div>

<div class="widget-chat">
    <button>
        <span class="hidden">Спроси у нас</span>
        <i class="far fa-comment"></i>
    </button>
</div>
