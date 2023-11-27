let page = 1;

//Селект с Глобальными категориями
jQuery(($) => {
    $('.selectGlCat').on('click', '.select__headGlCat', function () {
        if ($(this).hasClass('open')) {
            $(this).removeClass('open');
            $(this).next().fadeOut();
        } else {
            $('.select__headGlCat').removeClass('open');
            $('.select__listGlCat').fadeOut();
            $(this).addClass('open');
            $(this).next().fadeIn();
        }
    });

    $('.selectGlCat').on('click', '.select__itemGlCat', function () {
        $('.select__headGlCat').removeClass('open');
        $(this).parent().fadeOut();
        $(this).parent().prev().text($(this).text());
        $(this).parent().prev().prev().val($(this).attr('id'));

        renderProducts();
    });

    $(document).click(function (e) {
        if (!$(e.target).closest('.selectGlCat').length) {
            $('.select__headGlCat').removeClass('open');
            $('.select__listGlCat').fadeOut();
        }
    });
});

$(document).ready(function () {
    renderProducts();
    renderInfo();
});

function renderProducts(){
    let seacrh = $(".input_search_product").val();
    let category = $("#global_category").val();


    $.ajax({
        url: '/backend/script/seller/product/products.php',
        method: 'post',
        dataType: 'json',
        async: false,
        data: {
            action: "selectProduct",
            page: page,
            search: $.trim(seacrh),
            category: category
        },
        success: function (data) {

            PaginationRendering(data['count']);
            $(".table_products_select").remove();

            data['array'].forEach(function (array) {
                let amount = parseFloat(array['price'])*parseFloat(array['quantity']);
                $(".table_products").append('<div class="col-12 d-flex border-bottom border-secondary text-white text-14 py-3 table_products_select">\n' +
                    '                            <div class="col-1">\n' +
                    '                                <h6 class="text-14">'+array["product_id"]+'</h6>\n' +
                    '                            </div>\n' +
                    '\n' +
                    '                            <div class="col-3">\n' +
                    '                                <h6 class="div_2_line col-11 text-14">'+array["product_name"]+'</h6>\n' +
                    '                            </div>\n' +
                    '\n' +
                    '                            <div class="col-2">\n' +
                    '                                <h6 class="text-14">'+array["global_category"]+' /</h6>\n' +
                    '                                <h6 class="text-14">'+array["subcategories"]+'</h6>\n' +
                    '                            </div>\n' +
                    '\n' +
                    '                            <div class="col-1 ">\n' +
                    '                                <h6 class="text-14">'+array["quantity"]+'</h6>\n' +
                    '                            </div>\n' +
                    '\n' +
                    '                            <div class="col-1 ">\n' +
                    '                                <h6 class="text-14">'+array["price"]+'</h6>\n' +
                    '                            </div>\n' +
                    '\n' +
                    '                            <div class="col-1 ">\n' +
                    '                                <h6 class="text-14">'+amount+'</h6>\n' +
                    '                            </div>\n' +
                    '\n' +
                    '                            <div class="col-1 ">\n' +
                    '                                <h6 class="text-14">'+array['orders_count']+'</h6>\n' +
                    '                            </div>\n' +
                    '\n' +
                    '                            <div class="col-2 d-flex justify-content-around">\n' +
                    '                                <div onclick="renderModalLoading.call(this)" data-product="'+array['product_id']+'" data-bs-toggle="modal" data-bs-target="#loading_product" class="div_button border border-secondary rounded-2">\n' +
                    '                                    <img width="14" src="/res/img/svg_down.svg" alt="">\n' +
                    '                                </div>\n' +
                    '\n' +
                    '                                <div data-bs-toggle="modal" data-bs-target="#down_product" class="div_button border border-secondary rounded-2">\n' +
                    '                                    <img width="14" src="/res/img/btn_upload.svg" alt="">\n' +
                    '                                </div>\n' +
                    '\n' +
                    '                                <a href="/page/seller/product/update.js?id='+array['product_id']+'" class="div_button border border-secondary rounded-2">\n' +
                    '                                    <img width="15" src="/res/img/btn_update.svg" alt="">\n' +
                    '                                </a>\n' +
                    '\n' +
                    '                                <div data-bs-toggle="modal" data-bs-target="#copy_product" class="div_button border border-secondary rounded-2">\n' +
                    '                                    <img width="15" src="/res/img/btn_copy.svg" alt="">\n' +
                    '                                </div>\n' +
                    '\n' +
                    '                                <div data-bs-toggle="modal" data-bs-target="#delete_product" class="div_button border border-secondary rounded-2">\n' +
                    '                                    <img width="15" src="/res/img/btn_del.svg" alt="">\n' +
                    '                                </div>\n' +
                    '                            </div>\n' +
                    '                        </div>\n');
            });
        }
    });
}

function renderInfo() {
    $.ajax({
        url: '/backend/script/seller/product/products.php',
        method: 'post',
        dataType: 'json',
        async: false,
        data: {action: 'statistics'},
        success: function (data) {
            $(".countOrders").text(data['countOrders']);
            $(".countProducts").text(data['countProducts']);
            $(".sumOrders").text(data['sumOrders']);
            $(".sumProducts").text(data['sumProducts']);
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


function renderModalLoading() {

    $.ajax({
        url: '/backend/script/seller/product/products.php',
        method: 'post',
        dataType: 'json',
        async: false,
        data: {action: 'renderModalLoading', id: $(this).attr('data-product')},
        success: function (data) {
            $(".product_id").html("ID "+data['id']);
            $(".product_name").html(data['name']);
            $(".product_quantity").html("В наличии "+data['quantity']+" шт.");
            $(".product_price").html("Цена  "+data['price']+"р.");
            $(".num_rating").html("Рейтинг  "+data['num_rating']+".");
            $(".div_rating").empty().append(data['rating']);
        }
    });
}
