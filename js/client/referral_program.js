$(document).ready(function(){
    $('.copy-referral-link').click(function(){

        var clipboard = new ClipboardJS('.copy-referral-link');
        $('.copy-referral-link path').attr('fill-opacity', 1);

    });

    Write_span_coming();
});


$("#form_add_value").submit(function(event) {
    var hiddenInputValue = $(".select__input_Filter_favorite").val(); // Получаем значение из скрытого поля

    if (hiddenInputValue === "") {
        alert("Выберите тип платежной системы!");
        event.preventDefault(); // Предотвращаем отправку формы, если скрытое поле пустое
    }
});

function update_value() {
    let value = $(".h6_value").html();
    $(".div_value").empty();

    $(".div_value").append('<input value="'+value+'" type="text" class="input-price-seller mx-3 col-9 border-0 px-2 text-white input_payment">' +
        '<button class="btn bg-transparent border_blue btn_buy my-4 px-4 text-14 lh-1 text-white position-absolute bottom-0 btn_save" onclick="btn_save_update();">Изменить</button>');
}

function btn_save_update() {
    let value = $(".input_payment").val();

    if(!value) {
        alert("Введите данные!");
    }
    else {
        $.ajax({
            url: '/backend/script/client/referral_program/update_value.php',
            method: 'POST',
            dataType: 'html',
            data: {
                value:value,
            },
            success: function (data) {
                console.log(data);
                if(data === "save") {
                    location.reload();
                }
            }
        });
    }
}

const table_orders = "<tr class=\"border-bottom border-secondary text-secondary text-12\">\n" +
    "                            <td class=\"col-2 lh-lg\">Дата</td>\n" +
    "                            <td class=\"col-6\">Платежные данные</td>\n" +
    "                            <td class=\"col-2\">Сумма</td>\n" +
    "                            <td class=\"col-2\">Исполнение</td>\n" +
    "                        </tr>";


const table_coming = "<tr class=\"border-bottom border-secondary text-secondary text-12\">\n" +
    "                            <td class=\"col-2 lh-lg\">Дата</td>\n" +
    "                            <td class=\"col-3\">Сумма покупки</td>\n" +
    "                            <td class=\"col-3\">Процент отчислений</td>\n" +
    "                            <td class=\"col-2\">Приход</td>\n" +
    "                            <td class=\"col-2\">Исполнение</td>\n" +
    "                        </tr>";


function table_orders_write(status) {
    if(status == "") {

    }
}


$(document).ready(function () {

    $(".span_coming").click(function () {
        let finishDate = new Date();
        finishDate = finishDate.getFullYear() + '-' + ('0' + (finishDate.getMonth() + 1)).slice(-2) + '-' + ('0' + finishDate.getDate()).slice(-2);
        $('#finish').val(finishDate);

        let startDate = new Date();  // текущая дата
        startDate.setMonth(startDate.getMonth() - 1);  // отнять один месяц
        startDate = startDate.getFullYear() + '-' + ('0' + (startDate.getMonth() + 1)).slice(-2) + '-' + ('0' + startDate.getDate()).slice(-2);
        $('#start').val(startDate);

        $(".span_coming").removeClass('text-secondary').addClass('text-white');
        $(".span_orders").removeClass('text-white').addClass('text-secondary');

        Write_span_coming();
    });

    $(".span_orders").click(function () {
        let finishDate = new Date();
        finishDate = finishDate.getFullYear() + '-' + ('0' + (finishDate.getMonth() + 1)).slice(-2) + '-' + ('0' + finishDate.getDate()).slice(-2);
        $('#finish').val(finishDate);

        let startDate = new Date();  // текущая дата
        startDate.setMonth(startDate.getMonth() - 1);  // отнять один месяц
        startDate = startDate.getFullYear() + '-' + ('0' + (startDate.getMonth() + 1)).slice(-2) + '-' + ('0' + startDate.getDate()).slice(-2);
        $('#start').val(startDate);

        $(".span_orders").removeClass('text-secondary').addClass('text-white');
        $(".span_coming").removeClass('text-white').addClass('text-secondary');

        Write_span_orders();
    });
});

function Write_span_coming() {
    let table = $("table");

    table.empty();

    let start = $("#start").val();
    let finish = $("#finish").val();

    $.ajax({
        url: '/backend/script/client/referral_program/data.php',
        method: 'POST',
        dataType: 'json',
        data: {
            action: "select_coming",
            start: start,
            finish: finish
        },
        success: function (data) {
            table.append(table_coming);

            data.forEach(function (array) {
                if(array['status'] == "passed") {
                    table.append(create_str_Competed(array));
                }
                else {
                    table.append(create_str_In_Progress(array));
                }
            });
        }
    });
}

function Write_span_orders() {
    let table = $("table");

    table.empty();

    let start = $("#start").val();
    let finish = $("#finish").val();

    $.ajax({
        url: '/backend/script/client/referral_program/data.php',
        method: 'POST',
        dataType: 'json',
        data: {
            action: "select_orders",
            start: start,
            finish: finish
        },
        success: function (data) {
            console.log(data);
            table.append(table_orders);

            data.forEach(function (array) {
                if(array['status'] === "Competed") {
                    console.log(array);
                    table.append(create_str_Competed_orders(array));
                }
                else {

                }
            });
        }
    });
}

function create_str_Competed(array) {
    return '<tr class="text-white" style="font-weight: 400; font-size: 14px; line-height: 20px;">\n' +
        '                            <td class="col-2 lh-lg">'+array['data']+'</td>\n' +
        '                            <td class="col-3">'+array['orders_amount']+' р.</td>\n' +
        '                            <td class="col-3">'+array['ReferralPercentage']+'%</td>\n' +
        '                            <td class="col-2">'+array['amount']+'₽</td>\n' +
        '                            <td class="col-2">\n' +
        '                                <div class="col-12 mx-auto d-flex justify-content-start align-items-center py-3">\n' +
        '                                    <div class="rounded-circle"\n' +
        '                                         style="width: 6px; height: 6px; background: #A1E3CB;"></div>\n' +
        '                                    <span class="text-12 mx-2" style="color: #A1E3CB;">Competed</span>\n' +
        '                                </div>\n' +
        '                            </td>\n' +
        '                        </tr>';
}

function create_str_In_Progress(array) {
    return '<tr class="text-white" style="font-weight: 400; font-size: 14px; line-height: 20px;">\n' +
        '                            <td class="col-2 lh-lg">'+array['data']+'</td>\n' +
        '                            <td class="col-3">'+array['orders_amount']+' р.</td>\n' +
        '                            <td class="col-3">'+array['ReferralPercentage']+'%</td>\n' +
        '                            <td class="col-2">'+array['amount']+'р.</td>\n' +
        '                            <td class="col-2">\n' +
        '                                <div class="col-12 mx-auto d-flex justify-content-start align-items-center py-3">\n' +
        '                                    <div class="rounded-circle"\n' +
        '                                         style="width: 6px; height: 6px; background: #8A8CD9;"></div>\n' +
        '                                    <span class="text-12 mx-2" style="color: #8A8CD9;">In Progress</span>\n' +
        '                                </div>\n' +
        '                            </td>\n' +
        '                        </tr>';
}

function create_str_Competed_orders(array) {
    return '<tr class="text-white Regular" style="font-size: 14px; line-height: 20px;">\n' +
        '                            <td class="col-2 lh-lg ">'+array['data']+'</td>\n' +
        '                            <td class="col-6">'+array['name']+' '+array['payment_details']+'</td>\n' +
        '                            <td class="col-2">'+array['amount']+'₽</td>\n' +
        '                            <td class="col-2">\n' +
        '                                <div class="col-12 mx-auto d-flex justify-content-start align-items-center py-3">\n' +
        '                                    <div class="rounded-circle" style="width: 6px; height: 6px; background: #A1E3CB;">\n' +
        '\n' +
        '                                    </div>\n' +
        '\n' +
        '                                    <span class="text-12 mx-2" style="color: #A1E3CB;">'+array['status']+'</span>\n' +
        '                                </div>\n' +
        '                            </td>\n' +
        '                        </tr>';
}


$(document).ready(function() {
    $("input[type='date']").change(function() {
        // Ваш код обработки события здесь

        if($(".span_coming").hasClass("text-white")) {
            Write_span_coming();
        }
        else Write_span_orders();

    });
});

jQuery(($) => {
    $('.select_Filter_favorite').on('click', '.select__head_Filter_favorite', function () {
        if ($(this).hasClass('open')) {
            $(this).removeClass('open');
            $(this).next().fadeOut();
        } else {
            $('.select__head_Filter_favorite').removeClass('open');
            $('.select__list_Filter_favorite').fadeOut();
            $(this).addClass('open');
            $(this).next().fadeIn();
        }
    });

    $('.select_Filter_favorite').on('click', '.select__item_Filter_favorite', function () {
        $('.select__head_Filter_favorite').removeClass('open');
        $(this).parent().fadeOut();
        $(this).parent().prev().text($(this).text());
        $(this).parent().prev().prev().val($(this).attr('id'));


    });

    $(document).click(function (e) {
        if (!$(e.target).closest('.select_Filter_favorite').length) {
            $('.select__head_Filter_favorite').removeClass('open');
            $('.select__list_Filter_favorite').fadeOut();
        }
    });
});