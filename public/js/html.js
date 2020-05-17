// Форма добавления ответа на комментарий
var form_response = "<div class='form_add_response'>";
form_response += "<form data-toggle='validator' role='form'>";
form_response += "<div class='form-group'><label for='comm' class='control-label'>Комментарий</label>";
form_response += "<textarea id='comm' name='comment' class='form-control' rows='3' required></textarea></div><div class='form-group'>";
form_response += "<label for='name' class='control-label'>Ваше имя и фамилия</label>";
if(!userAuth){
    
    form_response += "<input type='text' name='name' class='form-control' id='name' pattern='^\\S+\\s\\S+$' required></div>";
    form_response += "<div class='form-group'><label for='email' class='control-label'>Электронная почта</label>";
    form_response += "<input type='email' name='email' class='form-control' id='email' required></div>";
}else{
    form_response += "<input type='text' name='name' class='form-control' id='name' pattern='^\\S+\\s\\S+$' value='"+userName+"' required></div>";
    form_response += "<div class='form-group'><label for='email' class='control-label'>Электронная почта</label>";
    form_response += "<input type='email' name='email' class='form-control' id='email' value='"+userEmail+"' readonly></div>";
}

form_response += "<div class='form-group' style='float: right;'><button type='submit' class='btn btn-primary'>Добавить</button>";
form_response += "</div><button type='button' id='close_form_add_response' class='btn btn-danger' style='float: right; margin-right: 10px;'>Отмена</button>";
form_response += "</form></div>";
// Форма добавления ответа на комментарий


// Форма изменения названия списка желаний
var form_change_name_wishlist = "<form method='post' action='wishlist/changeName'><div class='form-group'>";
form_change_name_wishlist += "<input type='text' id='newName' class='form-control'></div>";
form_change_name_wishlist += "<input type='submit' id='save' value='Сохранить'>";
form_change_name_wishlist += "<input type='button' id='exit' value='Отмена'></form>";
// Форма изменения названия списка желаний

