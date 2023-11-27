$(function () {
    rendering();
});

let page = 1;
let table = $(".div_table");

function writeTr(id, name, email, tg, data, user_id){
    let newDate = data.split(' ');

    return ' <div class="col-12 d-flex text-14 text-white border-secondary border-bottom py-4">\n' +
        '                                <div class="col-1">\n' +
        '                                    <h6 class="text-14 text-break col-11">'+id+'</h6>\n' +
        '                                </div>\n' +
        '\n' +
        '                                <div class="col-2">\n' +
        '                                    <h6 class="text-14 text-break col-11">'+name+'</h6>\n' +
        '                                </div>\n' +
        '\n' +
        '                                <div class="col-2">\n' +
        '                                    <h6 class="text-14 text-break col-11">'+email+'</h6>\n' +
        '                                </div>\n' +
        '\n' +
        '                                <div class="col-2">\n' +
        '                                    <h6 class="text-14 text-break col-11">'+tg+'</h6>\n' +
        '                                </div>\n' +
        '\n' +
        '                                <div class="col-1">\n' +
        '                                    <h6 class="text-14 text-break col-11">'+newDate[0]+'</h6>\n' +
        '                                    <h6 class="text-14 text-break col-11">'+newDate[1]+'</h6>\n' +
        '                                </div>\n' +
        '\n' +
        '                                <div class="col-2 d-flex">\n' +
        '                                    <div class="col-10 mx-auto">\n' +
        '                                        <h6 class="text-14 text-break col-11">Competed</h6>\n' +
        '                                    </div>\n' +
        '                                </div>\n' +
        '\n' +
        '                                <div class="col-2">\n' +
        '                                    <div class="col-12 d-flex justify-content-end">\n' +
        '                                        <button class="py-1 px-3 border border-secondary rounded-3 text-white text-center bg-transparent mx-2">Открыть</button>\n' +
        '                                        <button onclick="approve.call(this)" data-user="'+user_id+'" class="py-1 px-3 border border-secondary rounded-3 text-white text-center bg-transparent">Одобрить</button>\n' +
        '                                    </div>\n' +
        '                                </div>\n' +
        '                            </div>';
}

function rendering() {
    let start_data = $("#start_data").val();
    let finish_data = $("#finish_data").val();
    let input_search = $(".input_search_application").val();

    table.empty();

    $.ajax({
        url: "/backend/script/admin/applications.php",
        method: 'POST',
        dataType: 'json',
        data: {
            action: 'select',
            page: page,
            start: start_data,
            finish: finish_data,
            search: input_search
        },
        success: function (data) {
            data['data'].forEach(function (array) {
                table.append(writeTr(array['id'], array['user_name'], array['user_email'], array['user_telegram'], array['data'], array['unique_id']));
            });

            PaginationRendering(data['count']);
        }
    });
}

function PaginationRendering(items) {

    let options = {
        items: items,
        itemsOnPage: 5,
        currentPage: page,
        prevText: "<",
        nextText: ">",
        displayedPages: 4,
        edges: 1,

        onPageClick: function (pageNumber, event) {
            page = pageNumber;
            rendering();
        }
    };

    $('#pagination-container').empty().pagination(options);
}

function approve(e) {
    if (confirm('Вы уверены?')) {
        let div = $(this);
        let id  = div.attr('data-user');

        $.ajax({
            url: "/backend/script/admin/applications.php",
            method: 'POST',
            dataType: 'json',
            data: {
                action: 'approve',
                id: id
            },
            success: function (data) {
                div.parent().parent().parent().remove();
            }
        });
    }
}