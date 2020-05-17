var sock;
var tim;

$('.widget-chat-modal button[type=submit]').click(function(e){
    e.preventDefault();
    var msg = $('.widget-chat-modal .body form[data-toggle=validator] #msg').val();
    var name = $('.widget-chat-modal .body form[data-toggle=validator] #name').val();
    var socket = new WebSocket("ws://" + host + ':7000');
    sock = socket;
    socket.onopen = function() {
        $('.widget-chat-modal .body form[data-toggle=validator]').addClass('hidden');
        $('.widget-chat-modal .body .block-content-msgs').removeClass('hidden');
        $('.widget-chat-modal .field-msg').removeClass('hidden');
        var date = getTime();
        addMsg(msg, date, 'myMsg');
        addMsg('Ожидание подключения консультанта...', '', 'info');
        var data = JSON.stringify({'name': name, 'from': 'user', 'type': 'connect'});
        socket.send(data);
        setTimeout(function(){
            var data1 = JSON.stringify({'name': name, 'msg': msg, 'from': 'user', 'type': 'msg'});
            socket.send(data1);
        }, 500);

    };

    socket.onclose = function(event) {
        if (event.wasClean) {
            console.log('Соединение закрыто чисто');
        } else {
            alert('Обрыв соединения'); // например, "убит" процесс сервера
        }
    };

    socket.onmessage = function(event) {
        var data = JSON.parse(event.data);
        if(data.type == 'info'){
            $('.notice-write').remove();
            addMsg(data.msg, data.time, 'info');
        }else if(data.type == 'msg'){
            $('.notice-write').remove();
            addMsg(data.msg, data.time, 'yourMsg');
        }else if(data.type == 'write'){
            clearTimeout(tim);
            if(!$('.block-content-msgs .notice-write').length){
                addMsg('', '', 'write');
            }
            tim = setTimeout(function(){
                $('.notice-write').remove();
            }, 2000);

        }
    };

    socket.onerror = function(error) {
        alert("Ошибка " + error.message);
    };
});

function addWriteNotice()
{
    clearTimeout();
}

$('.widget-chat-modal .head i').click(function(){
    if(sock) sock.close();
});

$('.widget-chat-modal .field-msg input[type=text]').keyup(function(e){

    if(e.keyCode == 13){
        var msg = $('.widget-chat-modal .field-msg input[type=text]').val();
        if(msg.match(/^\s*$/))
            return;

        $('.widget-chat-modal .field-msg input[type=text]').val('');
        var data = JSON.stringify({'msg': msg, 'from': 'user', 'type': 'msg', 'name': userName});

        addMsg(msg, getTime(), 'myMsg');
        sock.send(data);
    }else{
        var data = JSON.stringify({'from': 'user', 'type': 'write'});
        sock.send(data);
    }


});


$('.widget-chat-modal .field-msg button').click(function(e){
    e.preventDefault();

    var msg = $('.widget-chat-modal .field-msg input[type=text]').val();
    if(msg.match(/^\s*$/))
        return;
    $('.widget-chat-modal .field-msg input[type=text]').val('');
    var data = JSON.stringify({'msg': msg, 'from': 'user', 'type': 'msg', 'name': userName});

    addMsg(msg, getTime(), 'myMsg');
    sock.send(data);
});

function addMsg(msg, date, type)
{
    if(type == 'info'){
        $('.block-content-msgs').append("<p>" + msg + "</p>");
    }else if(type == 'myMsg'){
        if($('.block-content-msgs ul').length == 0){
            var html = '';
            html += "<ul><li><div class='my-msg'>" + msg + "</div><span class='my-msg-time'>"+date+"</span></li></ul>";
            $('.block-content-msgs').append(html);
        }else if($('.block-content-msgs').last().prop('tagName') == 'ul'){
            var html = '';
            html += "<li><div class='my-msg'>" + msg + "</div><span class='my-msg-time'>"+date+"</span></li>";
            $('.block-content-msgs').last().append(html);
        }else{
            var html = '';
            html += "<ul><li><div class='my-msg'>" + msg + "</div><span class='my-msg-time'>"+date+"</span></li></ul>";
            $('.block-content-msgs').append(html);
        }
    }else if(type == 'yourMsg'){
        if($('.block-content-msgs ul').length == 0){
            var html = '';
            html += "<ul><li><span class='your-msg-time'>"+date+"</span><div class='your-msg'>" + msg + "</div></li></ul>";
            $('.block-content-msgs').append(html);
        }else if($('.block-content-msgs').last().prop('tagName') == 'ul'){
            var html = '';
            html += "<li><span class='your-msg-time'>"+date+"</span><div class='your-msg'>" + msg + "</div></li>";
            $('.block-content-msgs').last().append(html);
        }else{
            var html = '';
            html += "<ul><li><span class='your-msg-time'>"+date+"</span><div class='your-msg'>" + msg + "</div></li></ul>";
            $('.block-content-msgs').append(html);
        }
    }else if(type == 'write'){
        var html = "<p class='notice-write'>Косультант набирает сообщение <img src='http://"+host+"/images/827.svg' alt=''></p>";
        $('.block-content-msgs').append(html);
    }

    var block = $('.widget-chat-modal .body')[0];

    block.scrollTop = block.scrollHeight;
}

function getTime()
{
    var objDate = new Date();
    var hour = objDate.getHours().toString();
    var minut = objDate.getMinutes().toString();
    hour = (hour.length == 1) ? '0' + hour : hour;
    minut = (minut.length == 1) ? '0' + minut : minut;
    hour = (hour == '0') ? '00' : hour;
    minut = (minut == '0') ? '00' : minut;
    return hour + ':' + minut;
}
