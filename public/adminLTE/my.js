$('.delete').click(function () {
    var res = confirm('Подтвердите действие');
    if (!res) return false;
});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

$('.del-item').on('click', function () {
    var res = confirm('Подтвердите действие');
    if (!res) return false;
    var $this = $(this),
        id = $this.data('id'),
        src = $this.data('src');
    $.ajax({
        url: adminpath + '/product/delete-gallery',
        data: {id: id, src: src},
        type: 'POST',
        beforeSend: function () {
            $this.closest('.file-upload').find('.overlay').css({'display': 'block'});
        },
        success: function (res) {
            setTimeout(function () {
                $this.closest('.file-upload').find('.overlay').css({'display': 'none'});
                if (res == 1) {
                    $this.fadeOut();
                }
            }, 1000);
        },
        error: function () {
            setTimeout(function () {
                $this.closest('.file-upload').find('.overlay').css({'display': 'none'});
                alert('Ошибка');
            }, 1000);
        }
    });
});

$('.sidebar-menu a').each(function () {
    var location = window.location.protocol + '//' + window.location.host + window.location.pathname;
    var link = this.href;
    if (link == location) {
        $(this).parent().addClass('active');
        $(this).closest('.treeview').addClass('active');
    }
});

// CKEDITOR.replace('editor1');
$('.editor').ckeditor();

$('#reset-filter').click(function () {
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


if ($('div').is('#single')) {
    var buttonSingle = $("#single"),
        buttonMulti = $("#multi"),
        file;
}

if (buttonSingle) {

    new AjaxUpload(buttonSingle, {
        action: adminpath + '/' + buttonSingle.data('url'),
        data: {name: buttonSingle.data('name')},
        name: buttonSingle.data('name'),
        onSubmit: function (file, ext) {
            if (!(ext && /^(jpg|png|jpeg|gif)$/i.test(ext))) {
                alert('Ошибка! Разрешены только картинки');
                return false;
            }
            buttonSingle.closest('.file-upload').find('.overlay').css({'display': 'block'});
        },
        onComplete: function (file, response) {
            setTimeout(function () {
                buttonSingle.closest('.file-upload').find('.overlay').css({'display': 'none'});
                var data = response.match(/{\S+}/);
                response = JSON.parse(data);
                console.log(response);
                $('.' + buttonSingle.data('name')).html("<img src='" + host + "/storage/" + response.file + "' style='max-height: 150px;'>");
            }, 1000);
        }
    });
}

if (buttonMulti) {
    new AjaxUpload(buttonMulti, {
        action: adminpath + '/' + buttonMulti.data('url'),
        data: {name: buttonMulti.data('name')},
        name: buttonMulti.data('name'),
        onSubmit: function (file, ext) {
            if (!(ext && /^(jpg|png|jpeg|gif)$/i.test(ext))) {
                alert('Ошибка! Разрешены только картинки');
                return false;
            }
            buttonMulti.closest('.file-upload').find('.overlay').css({'display': 'block'});

        },
        onComplete: function (file, response) {
            setTimeout(function () {
                buttonMulti.closest('.file-upload').find('.overlay').css({'display': 'none'});
                console.log(response);
                var data = response.match(/{\S+}/);
                response = JSON.parse(data);
                console.log(response);
                $('.' + buttonMulti.data('name')).append("<img src='" + host + "/storage/" + response.file + "' style='max-height: 150px;'>");
            }, 1000);
        }
    });
}

$('#add').on('submit', function () {
    // if(!isNumeric( $('#category_id').val() )){
    //     alert('Выберите категорию');
    //     return false;
    // }
});

function startSocket(hash) {
    setVar('tim', '');

    Echo.private('chat.' + hash).listen('MessageChat', function (data) {
        if (data.user == 'client') {
            $('#block-chat-user .chat .notice-write').remove();
            addMsgAdmin(data.message, data.time, 'yourMsg');

            var audio = new Audio(host + '/storage/audio/Sound_msg.mp3');
            audio.play();
        }
    })
        .listenForWhisper('writing', (e) => {
            clearTimeout(window.tim);

            if (!$('#block-chat-user .chat  .notice-write').length) {
                addMsgAdmin('', '', 'write');
            }

            window.tim = setTimeout(function () {
                $('#block-chat-user .chat .notice-write').remove();
            }, 2000);

        }).listenForWhisper('connected', function () {

        var audio = new Audio(host + '/storage/audio/Sound_connection.mp3');
        audio.play();
        addMsgAdmin('Клиент подключен к чату!', '', 'info');

    }).listenForWhisper('disconnect', function () {
        addMsgAdmin('Клиент отключился от чата!', '', 'info');
    });

    setTimeout(function () {
        Echo.private('chat.' + hash).whisper('connected', {});
        $('#field-msg').removeAttr('disabled');
        $('#send-new-msg-admin-panel').removeAttr('disabled');
        addMsgAdmin('Консультант подключен к чату!', '', 'info');
    }, 500);
}

$('#table-chats-admin-panel tbody').on('click', 'tr', function (e) {
    var hash = $(this).data('hash');
    document.location = adminpath + '/chats/' + hash;
});

function setVar(varName, varValue) {
    window[varName] = varValue;
}

$('#block-chat-user button[id=connect]').click(function () {
    if ($(this).is('.active'))
        return;

    $(this).addClass('active');

    $('#block-chat-user button[id=disconnect]').removeClass('active');

    var hash = $('#block-chat-user .chat').data('hash');

    setVar('chat_hash', hash);

    startSocket(hash);


    $.post({
        url: host + '/chats/connectedAdmin',
        data: {hash: hash},
        success: function (data) {
            console.log(data);
        },
        error: function (e) {
            console.log(e);
        }
    });
});

$('#block-chat-user button[id=disconnect]').click(function () {
    if ($(this).is('.active'))
        return;

    $(this).addClass('active');
    $('#block-chat-user button[id=connect]').removeClass('active');
    addMsgAdmin('Консультант отключен от чата!', getTime(), 'info');

    Echo.private('chat.' + window.chat_hash).whisper('disconnect', {});
    Echo.leave('chat.' + window.chat_hash);

    $('#field-msg').attr('disabled', 'disabled');
    $('#send-new-msg-admin-panel').attr('disabled', 'disabled');
});

$('#block-chat-user .box-footer #field-msg').keyup(function (e) {

    if (e.keyCode == 13) {
        //Нажали enter
        var msg = $('#block-chat-user .box-footer #field-msg').val();
        if (msg.match(/^\s*$/))
            return;

        $('#block-chat-user .box-footer #field-msg').val('');

        addMsgAdmin(msg, getTime(), 'myMsg');

        $.post({
            url: host + '/chats/message',
            data: {hash: window.chat_hash, user_name: 'admin', message: msg, user: 'admin'},
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


$('#send-new-msg-admin-panel').click(function (e) {
    var msg = $('#block-chat-user .box-footer #field-msg').val();
    if (msg.match(/^\s*$/))
        return;

    $('#block-chat-user .box-footer #field-msg').val('');

    addMsgAdmin(msg, getTime(), 'myMsg');

    $.post({
        url: host + '/chats/message',
        data: {hash: window.chat_hash, user_name: 'admin', message: msg, user: 'admin'},
        success: function (data) {
            console.log(data);
        },
        error: function (e) {
            console.log(e);
        }
    });
});


function addMsgAdmin(msg, date, type) {
    if (type == 'info') {
        var html = '';
        html += "<li class='notice-msg'><p>" + msg + "</p></li>";
        $('#block-chat-user .chat ul').append(html);

    } else if (type == 'myMsg') {
        var html = '';
        html = "<li><div class='my-msg'>" + msg + "</div><span class='my-msg-date'>" + date + "</span></li>";
        $('#block-chat-user .chat ul').append(html);
    } else if (type == 'yourMsg') {
        var html = '';
        html = "<li><div class='your-msg'>" + msg + "</div><span class='your-msg-date'>" + date + "</span></li>";
        $('#block-chat-user .chat ul').append(html);
    } else if (type == 'write') {
        var html = "<li class='notice-write'><p>Пользователь набирает сообщение <img src='" + host + "/storage/images/827.svg' alt=''></p></li>";
        $('#block-chat-user .chat ul').append(html);
    }
    var block = $('#block-chat-user .chat ul')[0];

    block.scrollTop = block.scrollHeight;

}


function isNumeric(n) {
    return !isNaN(parseFloat(n)) && isFinite(n);
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
