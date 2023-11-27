
let category = "all";
let page = 1;

$(function(){
    rendering();
});

//Фильтр на странице шопов
$(".menu_filter").click(function(){
    $(".menu_filter").removeClass("menu_filter_active");
    $(this).addClass("menu_filter_active");

    $(".text_filter_shops").text($(this).find('h6').text());
    $(".select__input_Filter_shops").val("default");

    $(".input_search_shops").val("");
    $(".select__head_Filter_shops").text("Фильтровать по");
    category = $(this).attr("id");
    page = 1;

    rendering();
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
        rendering();
    });

    $(document).click(function (e) {
        if (!$(e.target).closest('.select_Filter_shops').length) {
            $('.select__head_Filter_shops').removeClass('open');
            $('.select__list_Filter_shops').fadeOut();
        }
    });
});



function rendering(){
    let searchInput = $.trim($('.input_search_shops').val());
    let filterShops = $(".select__input_Filter_shops").val();

    $.ajax({
        url: "/backend/script/admin/shop/shops.php",
        method: 'POST',
        dataType: 'json',
        data: {
            action: 'Select_Shops_Filter',
            category: category,
            parameter: filterShops,
            search: searchInput,
            page: page
        },
        success: function(data){


            $(".main-table").empty();
            $(".main-table").append('<tr class="border-bottom border-secondary text-secondary text-12 fw-bolder">\n' +
                '                            <td class="col-1 lh-lg">ID</td>\n' +
                '                            <td class="col-9">\n' +
                '                                <table class="col-12">\n' +
                '                                    <tr>\n' +
                '                                        <td class="col-2">Шоп</td>\n' +
                '                                        <td class="col-2">Владелец</td>\n' +
                '                                        <td class="col-2">Кол-во продаж</td>\n' +
                '                                        <td class="col-2">Рейтинг</td>\n' +
                '                                        <td class="col-2">Баланс</td>\n' +
                '                                        <td class="col-2">Доступно</td>\n' +
                '                                    </tr>\n' +
                '                                </table>\n' +
                '                            </td>\n' +
                '                            <td class="col-12 d-flex justify-content-center">\n' +
                '                            </td>\n' +
                '                        </tr>');

            if (data !== 0) {


                data['array'].forEach(function (array) {
                    $(".main-table").append('<tr class="border-bottom border-secondary text-14 fw-bolder">\n' +
                        '                            <td class="col-1 lh-lg">'+array['id']+'</td>\n' +
                        '                            <td class="col-9">\n' +
                        '                                <table class="col-12">\n' +
                        '                                    <tr>\n' +
                        '                                        <td class="col-2">'+array['name']+'</td>\n' +
                        '                                        <td class="col-2">'+array['user_name']+'</td>\n' +
                        '                                        <td class="col-2">'+array['orders_count']+'</td>\n' +
                        '                                        <td class="col-2">'+array['rating_value']+'</td>\n' +
                        '                                        <td class="col-2">Баланс</td>\n' +
                        '                                        <td class="col-2">Доступно</td>\n' +
                        '                                    </tr>\n' +
                        '                                </table>\n' +
                        '                            </td>\n' +
                        '                            <td class="col-12 d-flex justify-content-center">\n' +
                        '                                <a href="" class="col-7 my-3 py-1 a_shops rounded-3 text-center text-decoration-none border text-white border-secondary">\n' +
                        '                                    Открыть\n' +
                        '                                </a>\n' +
                        '                            </td>\n' +
                        '                        </tr>');
                });
                PaginationRendering(parseInt(data['items']));

            }
            else {

            }
        }
    });
}


function PaginationRendering (items) {

    let options = {
        items: items,
        itemsOnPage: 5,
        currentPage: page,
        prevText: "<",
        nextText: ">",
        displayedPages: 4,
        edges: 1,

        onPageClick: function(pageNumber, event) {
            $("#page").val(pageNumber);
            event.preventDefault();
            // обработчик клика на страницу
            rendering();

        }
    };

    $('#pagination-container').empty().pagination(options);
}


