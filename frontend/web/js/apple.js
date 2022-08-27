

$(document).ready(function(){
    if(page == 'apples'){
        return createContent();
    }
});

$("body" ).on('click', '.create', function() {
     return query('create', null, 'post');
});

$("body" ).on('click', '.fall', function() {
    let id = $(this).prop("id");
    let data = {id: id};
    return query('fall', data, 'put');
});

$("body" ).on('click', '.eat', function() {
    let id = $(this).prop("id");
    let percent = $("#inp-" + id).prop("value");
    let data = {id: id, percent: percent};
    return query('eat', data, 'put');
});

$("body" ).on('click', '.del', function() {
    let id = $(this).prop("id");
    let data = {id: id};
    return query('delete', data, 'delete');
});

$("body" ).on('click', '.perc', function() {
    $(this).bind('input', function() {
        let percent = $(this).prop("value");
        if(percent > 100){
            $(this).val(100);
        }
        if(percent < 1){
            $(this).val(1);
        }
    });
});

function query(action, data, method){

    $.ajax({
        url: apiURI + 'api/v1/' + action,
        method: method,
        dataType: 'json',
        headers:{
            'Authorization' : 'Bearer ' + token,
        },
        data: data,
        success: function(data){
            createContent();
        },
    });

    return false;
}

function createContent(){
    $.ajax({
        url: '/apples',
        method: 'get',
        success: function(data){
            $("#content").html(data);
        }
    });
    return false;
}