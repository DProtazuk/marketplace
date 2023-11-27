$(function () {
    rendering();
});


function rendering() {

    let table = $(".div_seller");
    let input_search = $(".input_search_seller").val();

    table.empty();


    $.ajax({
        url: "/backend/script/admin/users/client/search.php",
        method: 'POST',
        dataType: 'json',
        data: {
            search: input_search
        },
        success: function (data) {
            data.forEach(function (array) {
                table.append('<div class="col-12 d-flex text-14 text-white border-secondary border-bottom  align-items-center py-4">\n' +
                    '                                <div class="col-1 py-2">65444554</div>\n' +
                    '                                <div class="col-2">'+array['user_name']+'</div>\n' +
                    '                                <div class="col-2">'+array['email']+'</div>\n' +
                    '                                <div class="col-1">'+array['telegram']+'</div>\n' +
                    '                                <div class="col-2">'+array['order_count']+'</div>\n' +
                    '                                <div class="col-2">'+array['order_sum']+'</div>\n' +
                    '                                <div class="col-1">'+array['balance_client']+'</div>\n' +
                    '\n' +
                    '                                <div class="col-1 d-flex justify-content-end">\n' +
                    '                                    <a href="/page/admin/users/client/main.php?id='+array['unique_id']+'" class="py-1 text-decoration-none text-white px-3 border border-secondary rounded-3 text-white text-center bg-transparent">Открыть</a>\n' +
                    '                                </div>\n' +
                    '                            </div>');
            });
        }
    });
}