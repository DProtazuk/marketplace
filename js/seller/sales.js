const salesMain = "<div class=\"border-bottom border-secondary py-1 col-12 d-flex text-secondary text-12 fw-bolder align-items-center table_orders_main\">\n" +
    "                                <div class=\"col-1 lh-lg\">Ордер</div>\n" +
    "                                <div class=\"col-1 lh-lg\">Дата</div>\n" +
    "                                <div class=\"col-4\">Наименование</div>\n" +
    "                                <div class=\"col-6\">\n" +
    "                                    <div class=\"col-12 d-flex justify-content-between\">\n" +
    "                                        <div class=\"col-4\">Категория</div>\n" +
    "                                        <div class=\"col-3\">Покупатель</div>\n" +
    "                                        <div class=\"col-2\">Кол-во</div>\n" +
    "                                        <div class=\"col-2\">Сумма</div>\n" +
    "                                        <div class=\"col-1\"></div>\n" +
    "                                    </div>\n" +
    "                                </div>\n" +
    "                            </div>";

let type = "sales";
let page = 1;

$(document).ready(function () {
    writeTable();
});

$(".span_type").click( function (){
    type = $(this).attr("data-type");

    $(".span_type").removeClass("text-white");
    $(this).addClass("text-white");

    DateReturn();
    writeTable();
});



function DateReturn() {
    $(".input-search").val("");
    page = 1;

    let finishDate = new Date();
    finishDate = finishDate.getFullYear() + '-' + ('0' + (finishDate.getMonth() + 1)).slice(-2) + '-' + ('0' + finishDate.getDate()).slice(-2);
    $('#data-finish').val(finishDate);

    let startDate = new Date();  // текущая дата
    startDate.setMonth(startDate.getMonth() - 1);  // отнять один месяц
    startDate = startDate.getFullYear() + '-' + ('0' + (startDate.getMonth() + 1)).slice(-2) + '-' + ('0' + startDate.getDate()).slice(-2);
    $('#data-start').val(startDate);
}


function writeTable() {

    $(".table_info").empty();

    if(type === "sales"){
        $(".table_info").append(salesMain);
    }


    let start_data = $("#data-start").val();
    let finish_data = $("#data-finish").val();
    let input_search = $(".input-search").val();

    $.ajax({
        url: "/backend/script/seller/sales.php",
        method: 'POST',
        dataType: 'json',
        data: {
            action: type,
            page: page,
            start_data: start_data,
            finish_data: finish_data,
            search: input_search
        },
        success: function (data) {

            if(type === "sales"){
                PaginationRendering(parseInt(data['count']));

                data['data'].forEach(function (array) {
                    let newDate = array['data'];
                    newDate = newDate.split(' ');

                    $(".table_info").append('<div class="border-bottom border-secondary col-12 d-flex text-white text-14 py-3 table_orders_select">\n' +
                        '                                <div class="col-1">' + array['id'] + '</div>\n' +
                        '                                <div class="col-1">    ' +
                        '                                    <h6 class="text-14">' + newDate[0] + '</h6>' +
                        '                                     <h6 class="text-14">' + newDate[1] + '</h6></div>' +
                        '                               <div class="col-4 div_2_line text-14"> <h6 class="text-14 col-11">' + array['product_name'] + '</h6></div>\n' +
                        '                                <div class="col-6">\n' +
                        '                                    <div class="col-12 d-flex justify-content-between">\n' +
                        '                                        <div class="col-4">' +
                        '                                      <h6 class="text-14">' + array['global_category_name'] + ' /</h6>' +
                        '                                      <h6 class="text-14">' + array['subcategory_name'] + '</h6></div>' +
                        '                                        <div class="col-3">'+array['user_name']+'</div>\n' +
                        '                                        <div class="col-2">'+array['quantity']+'</div>\n' +
                        '                                        <div class="col-2">'+array['amount']+'</div>\n' +
                        '                                        <div class="col-1">\n' +
                        '                                            <a href="/backend/script/seller/DownOrders.php?id='+array['id']+'"\n' +
                        '                                                 class="div_button border border-secondary rounded-2">\n' +
                        '                                                <img width="14" src="/res/img/btn_down.svg" alt="">\n' +
                        '                                            </a>\n' +
                        '                                        </div>\n' +
                        '                                    </div>\n' +
                        '                                </div>\n' +
                        '                            </div>');
                });
            }
            else {

            }


        }, error(data){
            let action = $("table");
            action.empty();
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

        onPageClick: function (pageNumber) {
            page = pageNumber;
            writeTable();

        }
    };

    $('#pagination-container').empty().pagination(options);
}