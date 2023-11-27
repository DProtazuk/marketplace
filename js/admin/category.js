$(function () {
    rendering();
});


function rendering() {
    let input_search = $(".input_search_category").val();
    let table = $(".div_category");
    table.empty();

    $.ajax({
        url: "/backend/script/admin/category/newCategory.php",
        method: 'POST',
        dataType: 'json',
        data: {
            search: input_search
        },
        success: function (data) {

            data.forEach(function (array) {
                table.append('<div class="col-12 d-flex text-14 text-white border-secondary border-bottom py-2 align-items-center">\n' +
                    '                                <div class="col-1 py-3">\n' +
                    '                                    <img src="/res/img/img-category/'+array['img']+'" class="col-10">\n' +
                    '                                </div>\n' +
                    '                                <div class="col-1"></div>\n' +
                    '                                <div class="col-2">'+array['name']+'</div>\n' +
                    '\n' +
                    '\n' +
                    '                                <div class="col-1 d-flex">\n' +
                    '                                    <a href="/page/admin/setting/categories/update_category.php?id='+array['id']+'" class="div_button border border-secondary rounded-2">\n' +
                    '                                        <img width="11" src="/res/img/btn_update.svg" alt="">\n' +
                    '                                    </a>\n' +
                    '\n' +
                    '                                    <a href="/backend/script/admin/setting/category.php?id='+array['id']+'" onclick="confirmation(event)" class="div_button border border-secondary rounded-2 mx-2">\n' +
                    '                                        <img width="11" src="/res/img/btn_del.svg" alt="">\n' +
                    '                                    </a>\n' +
                    '                                </div>\n' +
                    '                            </div>');
            });
        }
    });
}


function confirmation(event) {
    if (!confirm('Вы уверены, что хотите удалить?')) {
        event.preventDefault();
        return false;
    }
}