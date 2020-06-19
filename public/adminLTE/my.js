
$('.delete').click(function(){
    var res = confirm('Подтвердите действие');
    if(!res) return false;
});

$('.del-item').on('click', function(){
    var res = confirm('Подтвердите действие');
    if(!res) return false;
    var $this = $(this),
        id = $this.data('id'),
        src = $this.data('src');
    $.ajax({
        url: adminpath + '/product/delete-gallery',
        data: {id: id, src: src},
        type: 'POST',
        beforeSend: function(){
            $this.closest('.file-upload').find('.overlay').css({'display':'block'});
        },
        success: function(res){
            setTimeout(function(){
                $this.closest('.file-upload').find('.overlay').css({'display':'none'});
                if(res == 1){
                    $this.fadeOut();
                }
            }, 1000);
        },
        error: function(){
            setTimeout(function(){
                $this.closest('.file-upload').find('.overlay').css({'display':'none'});
                alert('Ошибка');
            }, 1000);
        }
    });
});

$('.sidebar-menu a').each(function(){
    var location = window.location.protocol + '//' + window.location.host + window.location.pathname;
    var link = this.href;
    if(link == location){
        $(this).parent().addClass('active');
        $(this).closest('.treeview').addClass('active');
    }
});

// CKEDITOR.replace('editor1');
$( '.editor' ).ckeditor();

$('#reset-filter').click(function(){
    $('#filter input[type=radio]').prop('checked', false);
    return false;
});

$(".select2").select2({
    placeholder: "Начните вводить наименование товара",
    //minimumInputLength: 2,
    cache: true,
    ajax: {
        url: adminpath + "/product/related-product",
        delay: 250,
        dataType: 'json',
        data: function (params) {
            return {
                q: params.term,
                page: params.page
            };
        },
        processResults: function (data, params) {
            return {
                results: data.items
            };
        }
    }
});



if($('div').is('#single')){
    var buttonSingle = $("#single"),
        buttonMulti = $("#multi"),
        file;
}

if(buttonSingle){

    new AjaxUpload(buttonSingle, {
        action: adminpath + '/' + buttonSingle.data('url'),
        data: {name: buttonSingle.data('name')},
        name: buttonSingle.data('name'),
        onSubmit: function(file, ext){
            if (! (ext && /^(jpg|png|jpeg|gif)$/i.test(ext))){
                alert('Ошибка! Разрешены только картинки');
                return false;
            }
            buttonSingle.closest('.file-upload').find('.overlay').css({'display':'block'});
        },
        onComplete: function(file, response){
            setTimeout(function(){
                buttonSingle.closest('.file-upload').find('.overlay').css({'display':'none'});
                var data = response.match(/{\S+}/);
                response = JSON.parse(data);
                console.log(response);
                $('.' + buttonSingle.data('name')).html("<img src='" + host + "/storage/" + response.file + "' style='max-height: 150px;'>");
            }, 1000);
        }
    });
}

if(buttonMulti){
    new AjaxUpload(buttonMulti, {
        action: adminpath + '/' + buttonMulti.data('url'),
        data: {name: buttonMulti.data('name')},
        name: buttonMulti.data('name'),
        onSubmit: function(file, ext){
            if (! (ext && /^(jpg|png|jpeg|gif)$/i.test(ext))){
                alert('Ошибка! Разрешены только картинки');
                return false;
            }
            buttonMulti.closest('.file-upload').find('.overlay').css({'display':'block'});

        },
        onComplete: function(file, response){
            setTimeout(function(){
                buttonMulti.closest('.file-upload').find('.overlay').css({'display':'none'});
                console.log(response);
                var data = response.match(/{\S+}/);
                response = JSON.parse(data);
                console.log(response);
                $('.' + buttonMulti.data('name')).append("<img src='" + host + "/storage/" + response.file +  "' style='max-height: 150px;'>");
            }, 1000);
        }
    });
}

$('#add').on('submit', function(){
     // if(!isNumeric( $('#category_id').val() )){
     //     alert('Выберите категорию');
     //     return false;
     // }
});

$('#table-chats-admin-panel tr').click(function(){
    var hash = $(this).data('hash');
    document.location = adminpath + '/chat/view?chat=' + hash;
});


var sock;
var tim;


$('#block-chat-user button[id=connect]').click(function(){
    if($(this).is('.active'))
        return;

    $(this).addClass('active');
    $('#block-chat-user button[id=disconnect]').removeClass('active');

    var hash = $('#block-chat-user .chat').data('hash');

    var socket = new WebSocket("ws://" + sytename + ':7000');
    sock = socket;

    socket.onopen = function() {
        addMsgAdmin('Консультант ' + adminName + ' подключился к чату!', '', 'info');
        var data = JSON.stringify({'hash': hash, 'from': 'admin', 'type': 'connect', 'name': adminName, 'admin_id': adminId});
        socket.send(data);
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
            addMsgAdmin(data.msg, data.time, 'info');
        }else if(data.type == 'msg'){
            addMsgAdmin(data.msg, data.time, 'yourMsg');
        }else if(data.type == 'write'){
            clearTimeout(tim);
            if(!$('#block-chat-user .chat  .notice-write').length){
                addMsgAdmin('', '', 'write');
            }
            tim = setTimeout(function(){
                $('#block-chat-user .chat .notice-write').remove();
            }, 2000);
        }

    };

    socket.onerror = function(error) {
        alert("Ошибка " + error.message);
    };
});

$('#block-chat-user button[id=disconnect]').click(function(){
    if($(this).is('.active'))
        return;

    $(this).addClass('active');
    $('#block-chat-user button[id=connect]').removeClass('active');
    addMsgAdmin('Консультант ' + adminName + ' отключен от чата!', getTime(), 'info');
    sock.close();
});

$('#block-chat-user .box-footer #field-msg').keyup(function(e){
   if(e.keyCode == 13){
       var msg = $('#block-chat-user .box-footer #field-msg').val();
       if(msg.match(/^\s*$/))
           return;
       $('#block-chat-user .box-footer #field-msg').val('');
       var data = JSON.stringify({'from': 'admin', 'msg': msg, 'type': 'msg', 'name': adminName});
       addMsgAdmin(msg, getTime(), 'myMsg');
       sock.send(data);
   }else{
       var data = JSON.stringify({'from': 'admin', 'type': 'write'});
       sock.send(data);
   }
});


$('#send-new-msg-admin-panel').click(function(e){
    e.preventDefault();
    var msg = $('#block-chat-user .box-footer #field-msg').val();
    if(msg.match(/^\s*$/))
        return;
    $('#block-chat-user .box-footer #field-msg').val('');
    var data = JSON.stringify({'from': 'admin', 'msg': msg, 'type': 'msg', 'name': adminName});
    addMsgAdmin(msg, getTime(), 'myMsg');
    sock.send(data);
});



function addMsgAdmin(msg, date, type)
{
    if(type == 'info'){
        var html = '';
        html += "<li class='notice-msg'><p>"+msg+"</p></li>";
        $('#block-chat-user .chat ul').append(html);

    }else if(type == 'myMsg'){
        var html = '';
        html = "<li><div class='my-msg'>"+msg+"</div><span class='my-msg-date'>"+date+"</span></li>";
        $('#block-chat-user .chat ul').append(html);
    }else if(type == 'yourMsg'){
        var html = '';
        html = "<li><div class='your-msg'>"+msg+"</div><span class='your-msg-date'>"+date+"</span></li>";
        $('#block-chat-user .chat ul').append(html);
    }else if(type == 'write'){
        var html = "<li class='notice-write'><p>Пользователь набирает сообщение <img src='http://"+sytename+"/images/827.svg' alt=''></p></li>";
        $('#block-chat-user .chat ul').append(html);
    }
    var block = $('#block-chat-user .chat ul')[0];

    block.scrollTop = block.scrollHeight;

}


function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
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
