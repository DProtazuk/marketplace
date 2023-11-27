$(function () {
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


jQuery(($) => {
    $('.select_Filter_type').on('click', '.select__head_Filter_type', function () {
        if ($(this).hasClass('open')) {
            $(this).removeClass('open');
            $(this).next().fadeOut();
        } else {
            $('.select__head_Filter_type').removeClass('open');
            $('.select__list_Filtertype').fadeOut();
            $(this).addClass('open');
            $(this).next().fadeIn();
        }
    });

    $('.select_Filter_type').on('click', '.select__item_Filter_type', function () {
        $('.select__head_Filter_type').removeClass('open');
        $(this).parent().fadeOut();
        $(this).parent().prev().text($(this).text());
        $(this).parent().prev().prev().val($(this).attr('id'));

        let type = $("#type").val();

        if (type === "time") {
            $(".div_time").removeClass("d-none");
            $(".div_quantity").addClass("d-none");
        }
        if (type === "quantity") {
            $(".div_time").addClass("d-none");
            $(".div_quantity").removeClass("d-none");
        }
    });

    $(document).click(function (e) {
        if (!$(e.target).closest('.select_Filter_type').length) {
            $('.select__head_Filter_type').removeClass('open');
            $('.select__list_Filter_type').fadeOut();
        }
    });
});


jQuery(($) => {
    $('.select_Filter_type_update').on('click', '.select__head_Filter_type_update', function () {
        if ($(this).hasClass('open')) {
            $(this).removeClass('open');
            $(this).next().fadeOut();
        } else {
            $('.select__head_Filter_type_update').removeClass('open');
            $('.select__list_Filtertype_update').fadeOut();
            $(this).addClass('open');
            $(this).next().fadeIn();
        }
    });

    $('.select_Filter_type_update').on('click', '.select__item_Filter_type_update', function () {
        $('.select__head_Filter_type_update').removeClass('open');
        $(this).parent().fadeOut();
        $(this).parent().prev().text($(this).text());
        $(this).parent().prev().prev().val($(this).attr('id'));

        let type = $("#type_update").val();

        if (type === "time") {
            $(".div_time").removeClass("d-none");
            $(".div_quantity").addClass("d-none");
        }
        if (type === "quantity") {
            $(".div_time").addClass("d-none");
            $(".div_quantity").removeClass("d-none");
        }
    });

    $(document).click(function (e) {
        if (!$(e.target).closest('.select_Filter_type_update').length) {
            $('.select__head_Filter_type_update').removeClass('open');
            $('.select__list_Filter_type_update').fadeOut();
        }
    });
});


function createDiscounts() {
    $(".text-error").text("");
    let name = $("#create_name").val();
    let shop = $("#shop").val();
    let percent = $("#create_percent").val();
    let type = $("#type").val();
    let quantity_discount = $("#quantity_discount").val();
    let start_data = $("#start_data").val();
    let finish_data = $("#finish_data").val();

    $.ajax({
        url: "/backend/script/admin/setting/discounts.php",
        method: 'POST',
        dataType: 'html',
        data: {
            action: "create",
            name: name,
            shop: shop,
            percent: percent,
            type: type,
            quantity_discount: quantity_discount,
            start_data: start_data,
            finish_data: finish_data

        },
        success: function (data) {
            if (data === "error") {
                $(".text-error").text("Проверьте введенные данные!");
            }
            if (data === "shop") {
                $(".text-error").text("Данного Шопа не существует!");
            }
            if (data === "data") {
                $(".text-error").text("Проверьте введенные даты!");
            }
            if (data === "no save") {
                $(".text-error").text("Такая скидка уже есть!");
            }
            if (data === "save") {
                location.reload();
            }
        }
    });
}


function rendering() {
    let filter = $(".select__input_Filter_shops").val();
    let input_search = $(".input_search_discounts").val();
    $(".table_write").empty();

    $.ajax({
        url: "/backend/script/admin/setting/discounts.php",
        method: 'POST',
        dataType: 'json',
        data: {
            action: "select",
            filter: filter,
            search: input_search
        },
        success: function (data) {
            data.forEach(function (array) {
                writeDiscounts(array);
            });
        }
    });
}

function writeDiscounts(array) {
    let discounts_id = array['discounts_id'];
    let discounts_name = array['discounts_name'];
    let discounts_percent = array['discounts_percent'];

    let quantity;
    let period;
    let shop;
    let type;

    {
        if (array['discounts_type'] === "quantity") {
            quantity = array['discounts_quantity'] + " / ";
            period = "";
            type = "По кол-ву";
        }
        if (array['discounts_type'] === "time") {
            let discounts_data_start = array['discounts_data_start'];
            discounts_data_start = discounts_data_start.split(' ');
            discounts_data_start = discounts_data_start[0];

            let discounts_data_finish = array['discounts_data_finish'];
            discounts_data_finish = discounts_data_finish.split(' ');
            discounts_data_finish = discounts_data_finish[0];

            quantity = "0";
            period = discounts_data_start + "<br>" + discounts_data_finish;
            type = "По времени";
        }
    }


    {
        if (array['shop_name'] === null) {
            shop = "Все";
        } else {
            shop = array['shop_name'];
        }
    }

    $(".table_write").append('<div id="div_discount_'+discounts_id+'" class="col-12 d-flex text-14 text-white border-secondary border-bottom py-4">\n' +
        '                                <div class="col-1">' + discounts_id + '</div>\n' +
        '                                <div class="col-2">' + discounts_name + '</div>\n' +
        '                                <div class="col-2 my-2">' + type + '</div>\n' +
        '                                <div class="col-2">' + shop + '</div>\n' +
        '                                <div class="col-2">' + period +
        '                                    </div>' +
        '                                <div class="col-1">' + discounts_percent + '%</div>\n' +
        '                                <div class="col-1">' + quantity + '</div>\n' +
        '\n' +
        '                                <div class="col-1 d-flex justify-content-around">\n' +
        '                                    <div data-updateDiscounts="' + discounts_id + '" onclick="renderingUpdateModal.call(this)" data-bs-toggle="modal" data-bs-target="#deleteDiscount" class="div_button border border-secondary rounded-2">\n' +
        '                                        <img width="11" src="/res/img/btn_update.svg" alt="">\n' +
        '                                    </div>\n' +
        '\n' +
        '                                    <div data-deleteDiscounts="' + discounts_id + '" onclick="deleteDiscounts.call(this)" class="div_button border border-secondary rounded-2">\n' +
        '                                        <img width="11" src="/res/img/btn_del.svg" alt="">\n' +
        '                                    </div>\n' +
        '                                </div>\n' +
        '                            </div>');
}


function deleteDiscounts() {
    let discounts_id = $(this).attr("data-deleteDiscounts");

    if (confirm('Удалить скидку ID?' + discounts_id)) {
        let div = $(this);

        $.ajax({
            url: "/backend/script/admin/setting/discounts.php",
            method: 'POST',
            dataType: 'html',
            data: {
                action: "delete",
                discounts_id: discounts_id
            },
            success: function (data) {
                if (data === "delete") {
                    div.parent().parent().remove();
                }
            }
        });
    }
}

function renderingUpdateModal() {
    let discounts_id = $(this).attr("data-updateDiscounts");

    $.ajax({
        url: "/backend/script/admin/setting/discounts.php",
        method: 'POST',
        dataType: 'json',
        data: {
            action: "selectOne",
            discounts_id: discounts_id
        },
        success: function (data) {
            $("#discount_id").val(data['discounts_id']);
            $("#update_name").val(data['discounts_name']);
            $("#update_percent").val(data['discounts_percent']);

            if (data['shop_name'] === null) {
                $("#update_shop").val("all");
                $(".text_update_shop").text("Для всех");
            } else {
                $("#update_shop").val(data['shop_id']);
                $(".text_update_shop").text(data['shop_name']);
            }


            if (data['discounts_type'] === "quantity") {
                $(".div_time").addClass("d-none");
                $(".div_quantity").removeClass("d-none");

                $("#type_update").val("quantity");
                $(".type_name_update").text("По кол-ву");
                $("#quantity_discount_update").val(data['discounts_quantity'])
            }
            if (data['discounts_type'] === "time") {
                $(".div_time").removeClass("d-none");
                $(".div_quantity").addClass("d-none");

                $("#type_update").val("time");
                $(".type_name_update").text("По периоду");

                let discounts_data_start = data['discounts_data_start'];
                discounts_data_start = discounts_data_start.split(' ');
                discounts_data_start = discounts_data_start[0];

                let discounts_data_finish = data['discounts_data_finish'];
                discounts_data_finish = discounts_data_finish.split(' ');
                discounts_data_finish = discounts_data_finish[0];

                $("#start_data_update").val(discounts_data_start);
                $("#finish_data_update").val(discounts_data_finish);
            }
        }
    });
}

function updateDiscounts() {
    let status = false;
    $(".text-error").text("");
    let id = $("#discount_id").val();
    let name = $("#update_name").val();
    let shop = $("#update_shop").val();
    let percent = $("#update_percent").val();
    let type = $("#type_update").val();
    let quantity_discount = $("#quantity_discount_update").val();
    let start_data = $("#start_data_update").val();
    let finish_data = $("#finish_data_update").val();

    $.ajax({
        url: "/backend/script/admin/setting/discounts.php",
        method: 'POST',
        dataType: 'html',
        data: {
            id:id,
            action: "update",
            name: name,
            shop: shop,
            percent: percent,
            type: type,
            quantity_discount: quantity_discount,
            start_data: start_data,
            finish_data: finish_data

        },
        success: function (data) {

            if (data === "error") {
                $(".text-error").text("Проверьте введенные данные!");
            }
            if (data === "shop") {
                $(".text-error").text("Данного Шопа не существует!");
            }
            if (data === "data") {
                $(".text-error").text("Проверьте введенные даты!");
            }
            if (data === "no save") {
                $(".text-error").text("Такой скидки нет!");
            }
            if (data === "no name") {
                $(".text-error").text("Такая скидка уже используеться!");
            }
            if (data === "save") {
                status = true;
                let quantity;
                let period;

                {
                    if (type === "quantity") {
                        quantity = quantity_discount + " / ";
                        period = "";
                        type = "По кол-ву";
                    }
                    if (type === "time") {
                        let discounts_data_start = start_data;
                        discounts_data_start = discounts_data_start.split(' ');
                        discounts_data_start = discounts_data_start[0];

                        let discounts_data_finish = finish_data;
                        discounts_data_finish = discounts_data_finish.split(' ');
                        discounts_data_finish = discounts_data_finish[0];

                        quantity = "0";
                        period = discounts_data_start + "<br>" + discounts_data_finish;
                        type = "По времени";
                    }
                }


                {
                    if (shop === null) {
                        shop = "Все";
                    } else {
                        shop = shop;
                    }
                }
                $("#div_discount_"+id).empty().append('                                <div class="col-1">' + id + '</div>\n' +
                    '                                <div class="col-2">' + name + '</div>\n' +
                    '                                <div class="col-2 my-2">' + type + '</div>\n' +
                    '                                <div class="col-2">' + shop + '</div>\n' +
                    '                                <div class="col-2">' + period +
                    '                                    </div>' +
                    '                                <div class="col-1">' + percent + '%</div>\n' +
                    '                                <div class="col-1">' + quantity + '</div>\n' +
                    '\n' +
                    '                                <div class="col-1 d-flex justify-content-around">\n' +
                    '                                    <div data-updateDiscounts="' + id + '" onclick="renderingUpdateModal.call(this)" data-bs-toggle="modal" data-bs-target="#deleteDiscount" class="div_button border border-secondary rounded-2">\n' +
                    '                                        <img width="11" src="/res/img/btn_update.svg" alt="">\n' +
                    '                                    </div>\n' +
                    '\n' +
                    '                                    <div data-deleteDiscounts="' + id + '" onclick="deleteDiscounts.call(this)" class="div_button border border-secondary rounded-2">\n' +
                    '                                        <img width="11" src="/res/img/btn_del.svg" alt="">\n' +
                    '                                    </div>\n' +
                    '                                </div>');
            }
        }
    }).then( function () {
        if(status){
            $('#deleteDiscount').modal('hide');
        }
    });
}