var user_name;

function setVar(varName, varValue)
{
    window[varName] = varValue;
}

$('.widget-chat button').click(function () {

    if (!userAuth) {
        alertNotice('Необходимо авторизоваться!');
        return;
    }

    if (window.isConnected) {
        Echo.private('chat.' + window.chat_hash).listen('MessageChat', function (data) {

            if (data.user == 'admin') {
                $('.notice-write').remove();
                addMsg(data.message, data.time, 'yourMsg');
                var audio = new Audio(host + '/storage/audio/Sound_msg.mp3');
                audio.play();
            }

        }).listenForWhisper('writing', function () {

            clearTimeout(window.tim);
            if (!$('.block-content-msgs .notice-write').length) {
                addMsg('', '', 'write');
            }
            window.tim = setTimeout(function () {
                $('.notice-write').remove();
            }, 2000);

        }).listenForWhisper('connected', function () {
            addMsg('Консультант подключен к чату!', getTime(), 'info');
        }).listenForWhisper('disconnect', function () {
            addMsg('Консультант отлючился от чата!', getTime(), 'info');
        });

        setTimeout(function () {
            Echo.private('chat.' + window.chat_hash).whisper('connected', {});
        }, 500);
    }

    $('.widget-chat-modal').removeClass('hidden');
    $('.widget-chat').addClass('hidden');
});

$('.widget-chat-modal .head i').click(function () {
    $('.widget-chat-modal').addClass('hidden');
    $('.widget-chat').removeClass('hidden');
});

function startSocket(hash)
{
    setVar('tim', '');
    setVar('chat_hash', hash);
    setVar('isConnected', true);

    window.Echo.private('chat.' + hash).listen('MessageChat', function (data) {

        if (data.user == 'admin') {
            $('.notice-write').remove();
            addMsg(data.message, data.time, 'yourMsg');
            var audio = new Audio(host + '/storage/audio/Sound_msg.mp3');
            audio.play();
        }

    }).listenForWhisper('writing', function () {

        clearTimeout(window.tim);
        if (!$('.block-content-msgs .notice-write').length) {
            addMsg('', '', 'write');
        }
        window.tim = setTimeout(function () {
            $('.notice-write').remove();
        }, 2000);

    }).listenForWhisper('connected', function () {
        addMsg('Консультант подключен к чату!', getTime(), 'info');
    }).listenForWhisper('disconnect', function () {
        addMsg('Консультант отлючился от чата!', getTime(), 'info');
    });

    setTimeout(function () {
        Echo.private('chat.' + hash).whisper('connected', {});
    }, 500);
}

$('.widget-chat-modal button[type=submit]').click(function (e) {

    e.preventDefault();
    var msg = $('.widget-chat-modal .body form[data-toggle=validator] #msg').val();
    var name = $('.widget-chat-modal .body form[data-toggle=validator] #name').val();

    $.ajax({
        url: host + '/chats/connected-user',
        data: {'message': msg, 'name': name},
        success: function (hash) {
            console.log(hash);
            $('.widget-chat-modal .body form[data-toggle=validator]').addClass('hidden');
            $('.widget-chat-modal .body .block-content-msgs').removeClass('hidden');
            $('.widget-chat-modal .field-msg').removeClass('hidden');
            var date = getTime();
            addMsg(msg, date, 'myMsg');
            addMsg('Ожидание подключения консультанта...', '', 'info');

            setVar('user_name_chat', name);

            startSocket(hash);
        },
        error: function (s) {
            console.log(s);
        }
    });
});

function addWriteNotice() {
    clearTimeout();
}

$('.widget-chat-modal .head i').click(function () {
    Echo.private('chat.' + window.chat_hash).whisper('disconnect', {});
    Echo.leave('chat.' + window.chat_hash);
});

$('.widget-chat-modal .field-msg input[type=text]').keyup(function (e) {

    if (e.keyCode == 13) {
        var msg = $('.widget-chat-modal .field-msg input[type=text]').val();
        if (msg.match(/^\s*$/))
            return;

        $('.widget-chat-modal .field-msg input[type=text]').val('');
        addMsg(msg, getTime(), 'myMsg');

        $.post({
            url: host + '/chats/message',
            data: {hash: window.chat_hash, user_name: window.user_name_chat, message: msg, user: 'client'},
            success: function (data) {
                console.log(data);
            },
            error: function (e) {
                console.log(e);
            }
        });
    } else {
        Echo.private('chat.' + window.chat_hash).whisper('writing', {});
    }
});


$('.widget-chat-modal .field-msg button').click(function (e) {
    e.preventDefault();

    var msg = $('.widget-chat-modal .field-msg input[type=text]').val();
    if (msg.match(/^\s*$/))
        return;
    $('.widget-chat-modal .field-msg input[type=text]').val('');

    addMsg(msg, getTime(), 'myMsg');

    $.post({
        url: host + '/chats/message',
        data: {hash: window.chat_hash, user_name: window.user_name_chat, message: msg},
        success: function () {

        },
        error: function (e) {
            console.log(e);
        }
    });
});

function addMsg(msg, date, type) {
    if (type == 'info') {
        $('.block-content-msgs').append("<p>" + msg + "</p>");
    } else if (type == 'myMsg') {
        if ($('.block-content-msgs ul').length == 0) {
            var html = '';
            html += "<ul><li><div class='my-msg'>" + msg + "</div><span class='my-msg-time'>" + date + "</span></li></ul>";
            $('.block-content-msgs').append(html);
        } else if ($('.block-content-msgs').last().prop('tagName') == 'ul') {
            var html = '';
            html += "<li><div class='my-msg'>" + msg + "</div><span class='my-msg-time'>" + date + "</span></li>";
            $('.block-content-msgs').last().append(html);
        } else {
            var html = '';
            html += "<ul><li><div class='my-msg'>" + msg + "</div><span class='my-msg-time'>" + date + "</span></li></ul>";
            $('.block-content-msgs').append(html);
        }
    } else if (type == 'yourMsg') {
        if ($('.block-content-msgs ul').length == 0) {
            var html = '';
            html += "<ul><li><span class='your-msg-time'>" + date + "</span><div class='your-msg'>" + msg + "</div></li></ul>";
            $('.block-content-msgs').append(html);
        } else if ($('.block-content-msgs').last().prop('tagName') == 'ul') {
            var html = '';
            html += "<li><span class='your-msg-time'>" + date + "</span><div class='your-msg'>" + msg + "</div></li>";
            $('.block-content-msgs').last().append(html);
        } else {
            var html = '';
            html += "<ul><li><span class='your-msg-time'>" + date + "</span><div class='your-msg'>" + msg + "</div></li></ul>";
            $('.block-content-msgs').append(html);
        }
    } else if (type == 'write') {
        var html = "<p class='notice-write'>Косультант набирает сообщение <img src='" + host + "/storage/images/827.svg' alt=''></p>";
        $('.block-content-msgs').append(html);
    }

    var block = $('.widget-chat-modal .body')[0];

    block.scrollTop = block.scrollHeight;
}

function getTime() {
    var objDate = new Date();
    var hour = objDate.getHours().toString();
    var minut = objDate.getMinutes().toString();
    hour = (hour.length == 1) ? '0' + hour : hour;
    minut = (minut.length == 1) ? '0' + minut : minut;
    hour = (hour == '0') ? '00' : hour;
    minut = (minut == '0') ? '00' : minut;
    return hour + ':' + minut;
}
