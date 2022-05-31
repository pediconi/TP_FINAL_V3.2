/*
 * AJAX FORM:
 * SERIALIZA EL FORMULARIO.
 */
function ajaxForm(id_form, url , callback){
    id_form = '#'+id_form;
    $.ajax({
        type: "POST",
        url: url,
        data: $(id_form).serialize(),
        success: function (data) {
            if(callback.length === 1)
                callback(data);
            else
                callback();
        },
        error: function () {
            alert("NO SE PUDO CUMPLIR LA PETICION");
        }
    });

}

/*
 * AJAX: AL HACER CLICK EN UN DETERMINADO ELEMENTO , EJECUTA AJAX.
 */
function ajaxOnClick(id,url,callback,type="POST",object){
    type = $.trim(type);
    if(type === "GET"){
        type='GET';
    }else type = "POST";
    id = '#'+id;
    $(id).on('click',()=>{
        $.ajax({
            type: type,
            url: url,
            data:object,
            success: function (data) {
                if(callback.length === 1)
                    callback(data);
                else
                    callback();
            },
            error: function () {
                alert("NO SE PUDO CUMPLIR LA PETICION");
            }
        });
    })
}

/*
 * AJAXURL: EJECUTA AJAX AL LLAMAR A LA FUNCION
 */
function ajaxURL(url,callback,method='POST',object){
    method = $.trim(method);
    if(method === "GET"){
        method='GET';
    }else method = "POST";

    $.ajax({
        type: method,
        url: url,
        data: object,
        success: function (data) {
            if(callback.length === 1)
                callback(data);
            else
                callback();
        },
        error: function () {
            alert("NO SE PUDO CUMPLIR LA PETICION");
        }
    });
}
