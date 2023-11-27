let page = 1;

    $(document).ready(function () {
        WriteOrders();
    });


function WriteOrders() {
    let page = parseInt($("#page").val());
    let start_data = $("#start_data").val();
    let finish_data = $("#finish_data").val();
    let input_search_orders = $(".input_search_orders").val();

    $.ajax({
        url: "/backend/script/client/order/select_order.php",
        method: 'POST',
        dataType: 'json',
        data: {
            page: page,
            start_data: start_data,
            finish_data: finish_data,
            search: input_search_orders
        },
        success: function (data) {
            PaginationRendering(data['count'], page);

            $(".table_orders_select").remove();



            data['data'].forEach(function (array) {
                // Пример строки даты и времени из базы данных
                let dbDateTime = array['data'];
                let dbDate = new Date(dbDateTime);

                let currentDate = new Date();

                let timeDiff = currentDate - dbDate;

                let oneDayInMillis = 24 * 60 * 60 * 1000;

// Проверка, прошел ли один день
                if (timeDiff >= oneDayInMillis) {
                    Render(array);
                    // Прошел один день
                    console.log('Прошло более суток');
                } else {
                    RenderRefund(array);
                    // Не прошел один день
                    console.log('Не прошло суток');
                }
            });
        }
    });
}


function PaginationRendering(items, currentPage) {

    if(parseInt(items) < 4){
        $(".ShowMore").addClass("d-none");
    }

    let options = {
        items: items,
        itemsOnPage: 4,
        currentPage: currentPage,
        prevText: "<",
        nextText: ">",
        displayedPages: 4,
        edges: 1,

        onPageClick: function (pageNumber, event) {
            $("#page").val(pageNumber);
            event.preventDefault();
            WriteOrders();
            // обработчик клика на страницу
            let totalPages = $('#pagination-container').pagination('getPagesCount');
            if (pageNumber === totalPages) {
                $(".ShowMore").addClass("d-none");
            } else {
                $(".ShowMore").removeClass("d-none");
            }
        }
    };

    $('#pagination-container').empty().pagination(options);
}

function ShopMore() {

}


function RenderRefund(array) {

    let newDate = array['data'];
    newDate = newDate.split(' ');

    $(".table_orders").append('<div class="border-bottom border-secondary col-12 d-flex text-14 table_orders_select py-4 mt-3">\n' +
        '                            <div class="col-1">' + array['id'] + '</div>\n' +
        '                            <div class="col-1">' +
        '                                      <h6 class="text-14">' + newDate[0] + '</h6>\n' +
        '                                      <h6 class="text-14">' + newDate[1] + '</h6>\n' +
        '</div>\n' +
        '                            <div class="col-5 div_2_line text-14"> <h6 class="text-14 col-11">' + array['name'] + '</h6></div>\n' +
        '                            <div class="col-5">\n' +
        '                                <div class="col-12 d-flex justify-content-between">\n' +
        '                                    <div class="col-4">' +
        '                                      <h6 class="text-14">' + array['global_categories'] + '</h6>\n' +
        '                                      <h6 class="text-14">' + array['subcategories'] + '</h6>\n' +
        '</div>\n' +
        '                                    <div class="col-3">' + array['quantity'] + '</div>\n' +
        '                                    <div class="col-2">' + array['amount'] + '</div>\n' +
        '                                    <div class="col-3 d-flex">' +
        '<a href="/page/client/refund/start?id='+array['id']+'" class="col-5 d-flex justify-content-center">\n' +
        '                                            <svg class="border-1 rounded-1 border_blue cursor"  width="23" height="23" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
        '                                                <path d="M14.9567 6.28459L13.794 3.51909C13.6869 3.26453 13.4067 3.13952 13.1681 3.23985C12.9294 3.34019 12.8227 3.6279 12.9298 3.88245L13.8987 6.18704L11.7382 7.09544C11.4995 7.19578 11.3928 7.48348 11.4999 7.73804C11.6069 7.9926 11.8871 8.11761 12.1258 8.01728L14.7184 6.92719C14.9571 6.82685 15.0638 6.53915 14.9567 6.28459Z" fill="white"/>\n' +
        '                                                <path d="M14.3568 6.92103C14.474 6.97311 14.604 6.97528 14.7184 6.92719L14.7191 6.927C14.8336 6.87863 14.9229 6.78372 14.9675 6.66313C15.0119 6.54277 15.008 6.4066 14.9567 6.28459L14.9565 6.28399C14.9049 6.16182 14.8099 6.06386 14.6925 6.01167L12.0348 4.83069C10.9798 4.35907 9.84994 4.33827 9.84994 4.33827C8.7201 4.31747 7.68877 4.7511 7.68877 4.7511C6.65744 5.18472 5.88192 6.00663 5.88192 6.00663C5.1064 6.82854 4.70497 7.91338 4.70497 7.91338C4.6604 8.03382 4.66421 8.17006 4.71556 8.29218C4.76704 8.41439 4.86207 8.51275 4.97948 8.56503C5.09678 8.61726 5.22697 8.61956 5.34146 8.57142C5.45603 8.52314 5.54577 8.42817 5.59037 8.30762C5.92483 7.40377 6.57096 6.71899 6.57096 6.71899C7.2171 6.03421 8.07636 5.67293 8.07636 5.67293C8.93562 5.31165 9.87696 5.32898 9.87696 5.32898C10.8183 5.34631 11.6991 5.74004 11.6991 5.74004L14.3568 6.92103Z" fill="white"/>\n' +
        '                                                <path d="M5.07139 14.2785L6.23415 17.044C6.34118 17.2985 6.62141 17.4235 6.86005 17.3232C7.0987 17.2229 7.2054 16.9352 7.09837 16.6806L6.1294 14.376L8.28995 13.4676C8.5286 13.3673 8.6353 13.0796 8.52827 12.825C8.42124 12.5705 8.14101 12.4454 7.90236 12.5458L5.30971 13.6359C5.07106 13.7362 4.96436 14.0239 5.07139 14.2785Z" fill="white"/>\n' +
        '                                                <path d="M8.32903 14.8231L5.67136 13.6421C5.55414 13.59 5.42409 13.5878 5.30971 13.6359L5.30907 13.6361C5.19454 13.6845 5.10519 13.7794 5.06067 13.9C5.01624 14.0204 5.02009 14.1565 5.07139 14.2785L5.07168 14.2791C5.12324 14.4013 5.21819 14.4993 5.33564 14.5515L7.9933 15.7325C9.04836 16.2041 10.1782 16.2249 10.1782 16.2249C11.308 16.2457 12.3394 15.812 12.3394 15.812C13.3707 15.3784 14.1462 14.5565 14.1462 14.5565C14.9217 13.7346 15.3232 12.6498 15.3232 12.6498C15.3677 12.5293 15.3639 12.3931 15.3126 12.271C15.2611 12.1487 15.1661 12.0504 15.0487 11.9981C14.9314 11.9459 14.8012 11.9436 14.6867 11.9917C14.5721 12.04 14.4824 12.135 14.4378 12.2555C14.1033 13.1594 13.4572 13.8441 13.4572 13.8441C12.811 14.5289 11.9518 14.8902 11.9518 14.8902C11.0925 15.2515 10.1512 15.2342 10.1512 15.2342C9.20984 15.2168 8.32903 14.8231 8.32903 14.8231Z" fill="white"/>\n' +
        '                                            </svg>\n' +
        '\n' +
        '                                        </a>\n' +
        '\n' +
        '                                        <a href="/backend/script/client/order/downOrders.php?id='+array['id']+'" class="text-decoration-none col-4 d-flex justify-content-center">\n' +
        '                                            <svg class="border-1 rounded-1 border_blue cursor" width="23" height="23" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
        '                                                <path d="M9.87145 2.96875V16.0312C9.87145 16.3592 10.1381 16.625 10.4671 16.625C10.796 16.625 11.0627 16.3592 11.0627 16.0312V2.96875C11.0627 2.64083 10.796 2.375 10.4671 2.375C10.1381 2.375 9.87145 2.64083 9.87145 2.96875Z" fill="white"/>\n' +
        '                                                <path d="M10.8883 16.4511L16.249 11.1073C16.3607 10.996 16.4234 10.845 16.4234 10.6875C16.4234 10.53 16.3607 10.379 16.249 10.2677C16.1373 10.1563 15.9858 10.0938 15.8278 10.0938C15.6698 10.0938 15.5183 10.1563 15.4066 10.2677L10.4671 15.1916L5.52755 10.2677C5.41585 10.1563 5.26435 10.0938 5.10638 10.0938C4.9484 10.0938 4.7969 10.1563 4.6852 10.2677C4.5735 10.379 4.51074 10.53 4.51074 10.6875C4.51074 10.845 4.5735 10.996 4.6852 11.1073L10.0459 16.4511C10.2785 16.683 10.6556 16.683 10.8883 16.4511Z" fill="white"/>\n' +
        '                                            </svg>\n' +
        '                                        </a>\n' +
        '</div>\n' +
        '                                </div>\n' +
        '                            </div>\n' +
        '                        </div>');

}

function Render(array) {

    let newDate = array['data'];
    newDate = newDate.split(' ');


    $(".table_orders").append('<div class="border-bottom border-secondary col-12 d-flex text-14 table_orders_select py-4 mt-3">\n' +
        '                            <div class="col-1">' + array['id'] + '</div>\n' +
        '                            <div class="col-1">' +
        '                                      <h6 class="text-14">' + newDate[0] + '</h6>\n' +
        '                                      <h6 class="text-14">' + newDate[1] + '</h6>\n' +
        '</div>\n' +
        '                            <div class="col-5 div_2_line text-14"> <h6 class="text-14 col-11">' + array['name'] + '</h6></div>\n' +
        '                            <div class="col-5">\n' +
        '                                <div class="col-12 d-flex justify-content-between">\n' +
        '                                    <div class="col-4">' +
        '                                      <h6 class="text-14">' + array['global_categories'] + '</h6>\n' +
        '                                      <h6 class="text-14">' + array['subcategories'] + '</h6>\n' +
        '</div>\n' +
        '                                    <div class="col-3">' + array['quantity'] + '</div>\n' +
        '                                    <div class="col-2">' + array['amount'] + '</div>\n' +
        '                                    <div class="col-3">' +
        '<a href="/backend/script/client/order/downOrders.php?id='+array['id']+'" class="col-4 d-flex justify-content-center">\n' +
            '                                            <svg class="border-1 rounded-1 border_blue cursor" width="23" height="23" viewBox="0 0 20 19" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
                '                                                <path d="M9.87145 2.96875V16.0312C9.87145 16.3592 10.1381 16.625 10.4671 16.625C10.796 16.625 11.0627 16.3592 11.0627 16.0312V2.96875C11.0627 2.64083 10.796 2.375 10.4671 2.375C10.1381 2.375 9.87145 2.64083 9.87145 2.96875Z" fill="white"/>\n' +
                '                                                <path d="M10.8883 16.4511L16.249 11.1073C16.3607 10.996 16.4234 10.845 16.4234 10.6875C16.4234 10.53 16.3607 10.379 16.249 10.2677C16.1373 10.1563 15.9858 10.0938 15.8278 10.0938C15.6698 10.0938 15.5183 10.1563 15.4066 10.2677L10.4671 15.1916L5.52755 10.2677C5.41585 10.1563 5.26435 10.0938 5.10638 10.0938C4.9484 10.0938 4.7969 10.1563 4.6852 10.2677C4.5735 10.379 4.51074 10.53 4.51074 10.6875C4.51074 10.845 4.5735 10.996 4.6852 11.1073L10.0459 16.4511C10.2785 16.683 10.6556 16.683 10.8883 16.4511Z" fill="white"/>\n' +
                '                                            </svg>\n' +
            '                                        </a>\n' +
        '</div>\n' +
        '                                </div>\n' +
        '                            </div>\n' +
        '                        </div>');



}