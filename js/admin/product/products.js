$(document).ready(function () {
    $.ajax({
        url: "/backend/script/client/shop_filter.php",
        method: 'POST',
        dataType: 'json',
        data: {
            action: 'StartGlCategory'
        },
        success: function (data) {
            $("#global_categories").val(data);
        }
    }).then( function (){
        WriteFilter();
    });
});


jQuery(($) => {
    $('.select_Filter_shops').on('click', '.select__head_Filter_shops', function () {
        if ($(this).hasClass('open')) {
            $(this).removeClass('open');
            $(this).next().fadeOut();
        } else {
            $('.select__head_Filter_shops').removeClass('open');
            $('.select__list_Filter_shops').fadeOut();
            $(this).addClass('open');
            $(this).next().fadeIn();
        }
    });

    $('.select_Filter_shops').on('click', '.select__item_Filter_shops', function () {
        $('.select__head_Filter_shops').removeClass('open');
        $(this).parent().fadeOut();
        $(this).parent().prev().text($(this).text());
        $(this).parent().prev().prev().val($(this).attr('id'));
        WriteProductEndPagination();
        $(".ShowMore").removeClass("d-none");
    });

    $(document).click(function (e) {
        if (!$(e.target).closest('.select_Filter_shops').length) {
            $('.select__head_Filter_shops').removeClass('open');
            $('.select__list_Filter_shops').fadeOut();
        }
    });
});

function WriteFilter() {
    let global_categories = $("#global_categories").val();

    $(".filter-shops-div-select-parameters").empty();
    $(".clear_input").val('');

    $.ajax({
        url: "/backend/script/client/shop_filter_products.php",
        method: 'POST',
        dataType: 'json',
        data: {
            action: 'WriteFilter',
            global_categories: global_categories,
        },
        success: function (data) {
            console.log(data);
            $('#MaxPrice').val(data['MaxPrice']);
            $('#MinPrice').val(data['MinPrice']);
            PrintPrice();

            WriteSubcategory(data['subcategories']);
            PrintParameters(data['ParametersProduct']);
        }
    }).then( function () {
        WriteProductEndPagination();
    });
}

function ShowMoreProduct(){
    let ShopId = $("#ShopId").val();
    let global_categories = $("#global_categories").val();

    var page = parseInt($("#page").val())+1;

    let input_search_product = $(".input_search_product").val();
    let select__input_Filter_shops = $(".select__input_Filter_shops").val();

    let min = $("#min").val();
    let max = $("#max").val();

    let Subcategories = $("#subcategories").val();

    let ArrayParameters = $("#array-parameters").val();
    if (ArrayParameters !== "") {
        ArrayParameters = JSON.parse(ArrayParameters);
    }

    var myArray = [];
    let ArrayParametersUniq = $("#array-parameters-uniq").val();
    if (ArrayParametersUniq !== "") {

        ArrayParametersUniq = JSON.parse(ArrayParametersUniq);

        ArrayParametersUniq.forEach(function (array) {
            var key = array.replace('uniqParameter', '');

            let arrays = $("." + array).val();
            if (arrays !== "") {
                arrays = JSON.parse(arrays);
                myArray.push([key, arrays]);
            }
        });
    }

    if (myArray.length === 0) {
        myArray = "";
    }

    $.ajax({
        url: "/backend/script/client/shop_filter.php",
        method: 'POST',
        dataType: 'json',
        data: {
            action: 'filter_product',
            IdShop: ShopId,
            global_categories: global_categories,
            Subcategories: Subcategories,
            ArrayParameters: ArrayParameters,
            ArrayParametersUniq: myArray,
            min: min,
            max: max,
            search: input_search_product,
            sort: select__input_Filter_shops,
            page: page
        },
        success: function (data) {
            let type = $(".display_type").val();
            $(".ShowMore").addClass("d-none");

            if (type === "table_spisok") {

                data['data'].forEach(function (array) {
                    table_spisok(array);
                });
            } else {
                data['data'].forEach(function (array) {
                    table_table(array);
                });
            }
        }
    });
}

function WriteProductEndPagination() {
    let global_categories = $("#global_categories").val();

    var page = $("#page").val();

    let input_search_product = $(".input_search_product").val();
    let select__input_Filter_shops = $(".select__input_Filter_shops").val();

    let min = $("#minPrice").val();
    let max = $("#maxPrice").val();

    let Subcategories = $("#subcategories").val();

    let ArrayParameters = $("#array-parameters").val();
    if (ArrayParameters !== "") {
        ArrayParameters = JSON.parse(ArrayParameters);
    }

    var myArray = [];
    let ArrayParametersUniq = $("#array-parameters-uniq").val();
    if (ArrayParametersUniq !== "") {

        ArrayParametersUniq = JSON.parse(ArrayParametersUniq);

        ArrayParametersUniq.forEach(function (array) {
            var key = array.replace('uniqParameter', '');

            let arrays = $("." + array).val();
            if (arrays !== "") {
                arrays = JSON.parse(arrays);
                myArray.push([key, arrays]);
            }
        });
    }

    if (myArray.length === 0) {
        myArray = "";
    }

    $.ajax({
        url: "/backend/script/admin/product/products.php",
        method: 'POST',
        dataType: 'json',
        data: {
            action: 'filter_product',
            global_categories: global_categories,
            Subcategories: Subcategories,
            ArrayParameters: ArrayParameters,
            ArrayParametersUniq: myArray,
            min: min,
            max: max,
            search: input_search_product,
            sort: select__input_Filter_shops,
            page: page
        },
        success: function (data) {
            console.log(data);
            PaginationRendering(data['count'], page);
            PrintProduct(data);
        }
    });
}

$('body').on('mouseover', '.div-product', function () {
    $(this).css("min-height", "329px");
    $(this).css("max-height", "329px");

    $(this).find(".div-product-description").css("margin-top", "97px");

    $(this).find(".div_none").css("height", "73px");
    $(this).find(".div-product-h6").css("max-height", "50px");
    $(this).find(".div-product-h6").css("overflow", "hidden");

    $(this).find(".div-product-img .div-product-img-img").css("transform", "scale(1.3)");
    $(this).find(".div-product-description").css("background", "#343434");
})
    .on('mouseout', '.div-product', function () {
        $(this).css("min-height", "314px");
        $(this).css("max-height", "314px");

        $(this).find(".div_none").css("height", "88px");

        $(this).find(".div-product-description").css("margin-top", "82px");
        $(this).find(".div-product-h6").css("max-height", "35px");
        $(this).find(".div-product-h6").css("overflow", "hidden");

        $(this).find(".div-product-img img").css("transform", "scale(1)");
        $(this).find(".div-product-description").css("background", "transparent");
    });


//Нажатие на Глобальную категорию и отрисовка согласно глобальной категории
$('body').on("click", ".filter-shop-gl-category", function () {
    var GlCategory = 0;
    GlCategory = $(this).attr("id");

    $(".filter-shop-gl-category").removeClass("menu_filter_active");
    $(this).addClass("menu_filter_active");

    $("#global_categories").val(GlCategory);
    $(".name_gl_category").text($(this).find('h6').text());

    $(".div-array-select").empty();
    $(".clear_input").val('');

    $(".select__input_Filter_shops").val("default");
    $(".select__head_Filter_shops").text("Фильтровать по");

    WriteFilter();
});


function WriteSubcategory(data) {
    let variable = $(".filter-shops-div-subcategories");

    variable.empty();
    variable.append('<div class="col-12 d-flex justify-content-center align-items-center my-4 cursor show-filter-setting">\n' +
        '            <h6 class="text-white my-auto text-14 mx-1">Категории</h6>\n' +
        '            <img class="img-transform transform2" width="10" height="9" src="/res/img/arrow.png">\n' +
        '        </div>');

    variable.append('<div class="col-12 filter-content div-setting-variable transition d-none"></div>');

    let index = 0;
    data.forEach(function (array) {
        index++;

        $('.div-setting-variable').append('<div data-status="0" data-index="' + index + '" data-id="' + array['id'] + '" class="col-8 mx-auto d-flex my-3 cursor sidebar_category">\n' +
            '        <div class="rounded-circle border border-white sidebar_category_circle sidebar_category_circle_' + index + '" style="width: 12px; height: 12px"></div>\n' +
            '         <div class="rounded-circle bg_blue d-none sidebar_category_img sidebar_category_img_' + index + '" style="width: 12px; height: 12px"></div>\n' +
            '        <h6 class="text-12 text-white my-auto mx-2">' + array['name'] + '</h6>\n' +
            '    </div>');
    });
}


//Нажатие на подкатегорию и занесение в скрытый инпут
$('body').on('click', '.sidebar_category', function () {
    $(".sidebar_category .sidebar_category_img").addClass("d-none");
    $(".sidebar_category .sidebar_category_circle").removeClass("d-none");

    if($(this).attr("data-status") === "0"){
        $(".sidebar_category_img_" + $(this).attr("data-index")).removeClass("d-none");
        $(".sidebar_category_circle_" + $(this).attr("data-index")).addClass("d-none");

        $("#subcategories").val($(this).attr('data-id'));
        $(this).attr("data-status", 1);
    }
    else {
        $(".sidebar_category_img_" + $(this).attr("data-index")).addClass("d-none");
        $(".sidebar_category_circle_" + $(this).attr("data-index")).removeClass("d-none");

        $("#subcategories").val("");
        $(this).attr("data-status", 0);
    }


});


function PrintPrice() {
    let max = parseFloat($('#MaxPrice').val());
    let min = parseFloat($('#MinPrice').val());

    $('#filter-shop-input-price_products').slider({
        range: true,
        min: min,
        max: max,
        values: [min, max],
        slide: function (event, ui) {
            $('#minPrice').val(ui.values[0]);
            $('#maxPrice').val(ui.values[1]);
        }
    });

    $('#minPrice').val(min);
    $('#maxPrice').val(max);
}

$('body').on('click', '.sidebar_parameter', function () {
    let index = $(this).attr('data-index');
    let status = $(this).attr('data-status');

    var id = $(this).attr('data-id');

    if (parseFloat(status) === 0) {
        $(".sidebar_parameter_img_" + index).removeClass('d-none');
        $(".sidebar_parameter_circle_" + index).addClass('d-none');
        $(this).attr('data-status', 1);

        AddArrayParameters(id);

    } else {
        $(".sidebar_parameter_circle_" + index).removeClass('d-none');
        $(".sidebar_parameter_img_" + index).addClass('d-none');
        $(this).attr('data-status', 0);

        DeleteArrayParameter(id);
    }
});

$('body').on('click', '.uniqParameter', function () {
    let index = $(this).attr('data-index');
    let status = $(this).attr('data-status');

    var id = $(this).attr('data-id');
    var input = $(this).attr('data-input');

    if (parseFloat(status) === 0) {
        $(".uniqParameter_img_" + index).removeClass('d-none');
        $(".uniqParameter_circle_" + index).addClass('d-none');
        $(this).attr('data-status', 1);

        AddUniqParameter(input, id);

    } else {
        $(".uniqParameter_circle_" + index).removeClass('d-none');
        $(".uniqParameter_img_" + index).addClass('d-none');
        $(this).attr('data-status', 0);

        DeleteUniqParameter(input, id);
    }
});


function AddUniqParameter(input, id) {
    let myJson = $('.' + input).val();

    if (myJson !== '') {
        let myArray = JSON.parse(myJson);
        myArray.push(id);
        let array = JSON.stringify(myArray);
        $('.' + input).val(array);
    } else {
        let myArray = [];
        myArray.push(id);
        let array = JSON.stringify(myArray);
        $('.' + input).val(array);
    }
}

function DeleteUniqParameter(input, id) {
    let myJson = $('.' + input).val();
    let myArray = JSON.parse(myJson);

    var index = myArray.indexOf(id);

    if (index !== -1) {
        myArray.splice(index, 1);
        let array = JSON.stringify(myArray);

        if(jQuery.isEmptyObject(myArray)){
            $('.' + input).val("");
        }
        else $('.' + input).val(array);

    }
}


function AddArrayParameters(id) {
    let myJson = $('#array-parameters').val();

    if (myJson !== '') {
        let myArray = JSON.parse(myJson);
        myArray.push(id);
        let array = JSON.stringify(myArray);
        $('#array-parameters').val(array);
    } else {
        let myArray = [];
        myArray.push(id);
        let array = JSON.stringify(myArray);
        $('#array-parameters').val(array);
    }
}


function DeleteArrayParameter(id) {
    let myJson = $('#array-parameters').val();
    let myArray = JSON.parse(myJson);

    var index = myArray.indexOf(id);

    if (index !== -1) {
        myArray.splice(index, 1);
        let array = JSON.stringify(myArray);

        if(jQuery.isEmptyObject(myArray)){
            $('#array-parameters').val("");
        }
        else $('#array-parameters').val(array);
    }
}

$(document).ready(function () {

    $(".sidebar_geo").click(function () {
        let index = $(this).attr('data-index');
        let status = $(this).attr('data-status');

        if (parseFloat(status) === 0) {
            $(".sidebar_geo_img_" + index).removeClass('d-none');
            $(".sidebar_geo_circle_" + index).addClass('d-none');
            $(this).attr('data-status', 1);
        } else {
            $(".sidebar_geo_circle_" + index).removeClass('d-none');
            $(".sidebar_geo_img_" + index).addClass('d-none');
            $(this).attr('data-status', 0);
        }
    });

    $(".sidebar_parameters").click(function () {
        let index = $(this).attr('data-index');
        let status = $(this).attr('data-status');

        if (parseFloat(status) === 0) {
            $(".sidebar_parameters_img_" + index).removeClass('d-none');
            $(".sidebar_parameters_circle_" + index).addClass('d-none');
            $(this).attr('data-status', 1);
        } else {
            $(".sidebar_parameters_circle_" + index).removeClass('d-none');
            $(".sidebar_parameters_img_" + index).addClass('d-none');
            $(this).attr('data-status', 0);
        }
    });
});


$(".sidebar_input_price").on("input", function () {
    $('#slider').slider({
        range: true,
        min: 0,
        max: 15000,
        values: [$('#min').val(), $('#max').val()],
        slide: function (event, ui) {
            $('#min').val(ui.values[0]);
            $('#max').val(ui.values[1]);
        }
    });
});



function PrintParameters(array) {
    var parameter = $(".filter-shops-div-parameters");
    var select = $(".filter-shops-div-select-parameters");

    parameter.empty();
    select.empty();

    let index = 0;

    array.forEach(function (array) {

        if (array['type'] === "select") {
            select.append('<div class="col-12 filter-shops-div-select-parameters_' + array['name'] + '">' +
                '<div class="col-12 d-flex justify-content-center align-items-center my-4 cursor show-filter-setting">\n' +
                '            <h6 class="text-white my-auto text-14 mx-1">' + array['name'] + '</h6>\n' +
                '            <img class="img-transform transform2" width="10" height="9" src="/res/img/arrow.png">\n' +
                '        </div>' +
                '</div>');

            $('.filter-shops-div-select-parameters_' + array['name']).append('<div class="col-12 filter-shops-div-parameters filter-content filter-content_' + array['name'] + ' transition d-none"></div>');

            let ArraySelect = $.parseJSON(array['mass']);

            $(".div-array-select").append("<input type='hidden' class='uniqParameter" + array['id'] + "'>");

            let myJson = $('#array-parameters-uniq').val();

            let key = 'uniqParameter' + array['id'];

            if (myJson !== '') {
                let myArray = JSON.parse(myJson);
                myArray.push(key);
                let array = JSON.stringify(myArray);
                $('#array-parameters-uniq').val(array);
            } else {
                let myArray = [];
                myArray.push(key);
                let array = JSON.stringify(myArray);
                $('#array-parameters-uniq').val(array);
            }


            ArraySelect.forEach(function (SelectArray) {
                index++;

                $('.filter-content_' + array['name']).append('<div data-status="0" data-index="' + index + '" data-id="' + SelectArray + '" data-input="uniqParameter' + array['id'] + '" class="col-8 mx-auto d-flex my-3 cursor uniqParameter">\n' +
                    '        <div class="rounded-circle border border-white uniqParameter_circle_' + index + '" style="width: 12px; height: 12px"></div>\n' +
                    '         <div class="rounded-circle bg_blue d-none uniqParameter_img_' + index + '" style="width: 12px; height: 12px"></div>\n' +
                    '        <h6 class="text-12 text-white my-auto mx-2">' + SelectArray + '</h6>\n' +
                    '    </div>');
            });
        } else {
            index++;
            parameter.append('<div data-status="0" data-index="' + index + '" data-id="' + array['id'] + '" class="col-8 mx-auto d-flex my-3 cursor sidebar_parameter">\n' +
                '        <div class="rounded-circle border border-white sidebar_parameter_circle_' + index + '" style="width: 12px; height: 12px"></div>\n' +
                '         <div class="rounded-circle bg_blue d-none sidebar_parameter_img_' + index + '" style="width: 12px; height: 12px"></div>\n' +
                '        <h6 class="text-12 text-white my-auto mx-2">' + array['name'] + '</h6>\n' +
                '    </div>');
        }
    });
}



$(".sidebar_input_price").on("input", function () {
    let max = parseInt($('#MaxPrice').val());
    let min = parseFloat($('#MinPrice').val());

    $('#slider').slider({
        range: true,
        min: min,
        max: max,
        values: [$('#min').val(), $('#max').val()],
        slide: function (event, ui) {
            $('#min').val(ui.values[0]);
            $('#max').val(ui.values[1]);
        }
    });
});



$("body").on("click", '.show-filter-setting', function () {

    if ($(this).find(".img-transform").hasClass('transform2')) {

        $(this).find(".img-transform").addClass("transform").removeClass("transform2");
        $(this).next('.filter-content').removeClass("d-none");
    }
    else {
        $(this).find(".img-transform").addClass("transform2").removeClass("transform");
        $(this).next('.filter-content').addClass("d-none");
    }
});




//svg Нажатие

$(".svg_spisok").click(function () {
    $(".div_print_product").addClass('opacity-0');
    $(this).removeClass('opacity-50');
    $(".svg_table").addClass('opacity-50');

    $(".display_type").val("table_spisok");
    $(".div_print_product").removeClass("d-flex", "flex-wrap");
    $('.div_print_product').css('gap', '0%');

    WriteProductEndPagination();
    $(".div_print_product").removeClass('opacity-0');
});

$(".svg_table").click(function () {
    $(".div_print_product").addClass('opacity-0');

    $(this).removeClass('opacity-50');
    $(".svg_spisok").addClass('opacity-50');

    $(".display_type").val("table_table");
    $(".div_print_product").addClass("d-flex flex-wrap");
    $('.div_print_product').css('gap', '4%');

    WriteProductEndPagination();
    $(".div_print_product").removeClass('opacity-0');

});

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
            // обработчик клика на страницу
            WriteProductEndPagination();
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

function PrintProduct(array) {
    $(".div_print_product").empty();
        array['data'].forEach(function (array) {
            table_spisok(array);
        });

}

function table_spisok(array) {
    $(".div_print_product").append("<div class=\"col-12 d-flex text-14 text-white py-4 border-secondary border-bottom\">\n" +
        "                                <div class=\"col-1\">"+array['product_id']+"</div>\n" +
        "                                <div class=\"col-4\">\n" +
        "                                    <h6 class=\"text-14 col-11 div_2_line\">" + array['product_name'] + "</h6>\n" +
        "                                    </div>\n" +
        "                                <div class=\"col-6\">\n" +
        "                                    <div class=\"col-12 d-flex justify-content-between\">\n" +
        "                                        <div class=\"col-2\">" + array['shop_name'] + "</div>\n" +
        "                                        <div class=\"col-3\">" +
        "<h6>"+array['global_categories']+" /</h6>" +
        "<h6 class='col-10'>"+array['subcategories']+"</h6>" +
        "                                         </div>\n" +
        "                                        <div class=\"col-2\">" + array['quantity'] + "</div>\n" +
        "                                        <div class=\"col-2\">" + array['price'] + "</div>\n" +
        "                                        <div class=\"col-2\">" + parseFloat(array['quantity']) * parseFloat(array['price']) + "</div>\n" +
        "                                        <div class=\"col-2\">" + array['count_orders'] + "</div>\n" +
        "                                    </div>\n" +
        "                                </div>\n" +
        "\n" +
        "                                <div class=\"col-1 d-flex justify-content-around\">\n" +
        "                                    <a href='/page/admin/product/update.php?id="+array['product_id']+"' class=\"div_button border border-secondary rounded-2\">\n" +
        "                                        <img width=\"11\" src=\"/res/img/btn_update.svg\" alt=\"\">\n" +
        "                                    </a>\n" +
        "\n" +
        "                                    <div class=\"div_button border border-secondary rounded-2\">\n" +
        "                                        <img width=\"11\" src=\"/res/img/btn_del.svg\" alt=\"\">\n" +
        "                                    </div>\n" +
        "                                </div>\n" +
        "                            </div>");
}
