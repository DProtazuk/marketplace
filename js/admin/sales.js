let type = "sales";
let page = 1;
let table = $(".table_sales");



$(function () {
    $('.h6_type[data-type=' + type + ']').addClass("text-white");
    rendering();
});


function clickType(e) {
    $(".h6_type").removeClass("text-white");
    $(e).addClass("text-white");
    type = $(e).attr("data-type");
    page = 1;

    rendering();
}

function rendering() {
    if (type === "sales") {
        let start_data = $("#start_data").val();
        let finish_data = $("#finish_data").val();
        let input_search = $(".input_search").val();

        table.empty();

        let tr = '<div class="col-12 d-flex border-bottom border-secondary text-secondary text-12 fw-bolder">\n' +
            '                            <div class="col-1 lh-lg">Ордер</div>\n' +
            '                            <div class="col-1 lh-lg">Дата</div>\n' +
            '                            <div class="col-4">Наименование</div>\n' +
            '                            <div class="col-6 d-flex">\n' +
            '                                <div class="col-12 d-flex justify-content-between">\n' +
            '                                    <div class="col-2">Шоп</div>\n' +
            '                                    <div class="col-2">Клиент</div>\n' +
            '                                    <div class="col-2">Кол-во</div>\n' +
            '                                    <div class="col-2">Сумма</div>\n' +
            '                                    <div class="col-2">Прибыль мп</div>\n' +
            '                                    <div class="col-2"></div>\n' +
            '                                </div>\n' +
            '                            </div>\n' +
            '                        </div>';
        table.append(tr);

        $.ajax({
            url: "/backend/script/admin/sales.php",
            method: 'POST',
            dataType: 'json',
            data: {
                type: type,
                page: page,
                start: start_data,
                finish: finish_data,
                search: input_search
            },
            success: function (data) {
                data['array'].forEach(function (array) {
                    renderSales(array);
                });

                PaginationRendering(data['count']);
            }
        });
    }
    if(type === "refunds") {
        table.empty();

        let tr = '<div class="col-12 d-flex border-bottom border-secondary text-secondary text-12 fw-bolder">\n' +
            '                            <div class="col-1 lh-lg">Ордер</div>\n' +
            '                            <div class="col-1 lh-lg">Дата</div>\n' +
            '                            <div class="col-4">Наименование</div>\n' +
            '                            <div class="col-6 d-flex">\n' +
            '                                <div class="col-12 d-flex justify-content-between">\n' +
            '                                    <div class="col-2">Шоп</div>\n' +
            '                                    <div class="col-2">Клиент</div>\n' +
            '                                    <div class="col-2">Кол-во</div>\n' +
            '                                    <div class="col-2">Сумма</div>\n' +
            '                                    <div class="col-2">Прибыль мп</div>\n' +
            '                                    <div class="col-2"></div>\n' +
            '                                </div>\n' +
            '                            </div>\n' +
            '                        </div>';
        table.append(tr);
        PaginationRendering(1);
    }
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


function renderSales(array) {
    let newDate = array['orders_data'];
    newDate = newDate.split(' ');

    table.append('<div class="text-14 col-12 d-flex border-bottom border-secondary py-4">\n' +
        '                            <div class="col-1">'+array['orders_id']+'</div>\n' +
        '                            <div class="col-1 lh-lg">' +
        '                               <h6 class="text-14">'+newDate[0]+'</h6>' +
        '                               <h6 class="text-14">'+newDate[1]+'</h6>' +
        '                            </div>\n' +
        '                            <div class="col-4"><h6 class="">'+array['product_name']+'</h6></div>\n' +
        '                            <div class="col-6 d-flex">\n' +
        '                                <div class="col-12 d-flex justify-content-between">\n' +
        '                                    <div class="col-2">'+array['shop_name']+'</div>\n' +
        '                                    <div class="col-2">'+array['user_name']+'</div>\n' +
        '                                    <div class="col-2">'+array['orders_quantity']+'</div>\n' +
        '                                    <div class="col-2">'+array['orders_amount']+'</div>\n' +
        '                                    <div class="col-2">'+array['orders_amount']+'</div>\n' +
        '                                    <div class="col-2"><a href="/backend/script/admin/downOrders.php?id='+array['orders_id']+'" class="div_button border rounded-2 border-secondary"><img width="11" src="/res/img/svg_down.svg" alt=""></a></div>\n' +
        '                                </div>\n' +
        '                            </div>\n' +
        '                        </div>');
}


