var type = "coming";

//Оплата баланса
{
    $(".img-payment-method").click( function (){
        $(".img-payment-method").removeClass("border_blue_2");
        $(this).addClass("border_blue_2");

        $(".input_payment_method").val("1");
    });


    $(".but_amount").click( function (){
        $(".input-payment-amount").val($(this).attr("data-amount"));
    });


    $('input[type="number"]').on('input', function(){
        // Получаем значение поля
        var value = $(this).val();
        // Проверяем, является ли значение целым числом
        if(!Number.isInteger(parseFloat(value))){
            // Если значение не является целым числом, удаляем последний символ
            $(this).val(value.slice(0, -1));
        }
        // Проверяем, является ли значение меньше 1
        if(parseFloat(value) < 1){
            // Если значение меньше 1, устанавливаем значение 1
            $(this).val(1);
        }
    });


    $(".button-top-up").click( function () {
        let input_payment_method = $(".input_payment_method").val();

        if(input_payment_method !== ""){
            let input = $('#amount').val();

            if(input !== ''){
                $('#ButtonSend').attr('type', 'submit');
            }
            else {
                $('#amount').focus();
                alert("Введите сумму");
            }
        }
        else alert("Выберите метод оплаты");
    });
}


//Отрисовка таблицы приходы
{
    // Главная в таблице приходов
    var GlawStrComing = '<tr class="border-bottom border-secondary text-secondary text-12 fw-bolder">\n' +
        '                            <td class="col-2 lh-lg">Дата</td>\n' +
        '                            <td class="col-6">Платежные данные</td>\n' +
        '                            <td class="col-2">Сумма</td>\n' +
        '                            <td class="col-2">Исполнение</td>\n' +
        '                        </tr>';

    //Отрисовка строк таблицы
    function StrComing(data, payment_details, amount, name) {
        let str;

        if(name == "Completed"){
            str =  '<div class="col-12 mx-auto d-flex justify-content-start align-items-center py-3">' +
                        '<div class="rounded-circle" style="width: 6px; height: 6px; background: #A1E3CB;">' +
                        '</div>' +
                        '<span class="text-12 mx-2" style="color: #A1E3CB;">Completed</span>' +
                    '</div>';
        }
        if(name == "2"){
            str =  '<div class="col-12 mx-auto d-flex justify-content-start align-items-center py-3">' +
                '<div class="rounded-circle" style="width: 6px; height: 6px; background: #95A4FC;">' +
                '</div>' +
                '<span class="text-12 mx-2" style="color: #95A4FC;">In Progress</span>' +
                '</div>';
        }

        function ReturnTr(){
            return '<tr class="text-white Regular" style="font-weight: 400; font-size: 14px; line-height: 20px;">' +
                '                            <td class="col-2 lh-lg">'+data+'</td>' +
                '                            <td class="col-6">'+payment_details+'</td>' +
                '                            <td class="col-2">'+amount+'</td>' +
                '                            <td class="col-2">'+str+'</td>' +
                '                        </tr>';
        }

        return ReturnTr();
    }
}

//Отрисовка таблицы приходы
{
    // Главная в таблице приходов
    var GlawStrExpenditure = '<tr class="border-bottom border-secondary text-secondary text-12 fw-bolder">\n' +
        '                            <td class="col-2 lh-lg">Дата</td>\n' +
        '                            <td class="col-6">Ордер</td>\n' +
        '                            <td class="col-2">Сумма</td>\n' +
        '                            <td class="col-2">Исполнение</td>\n' +
        '                        </tr>';

    //Отрисовка строк таблицы
    function StrExpenditure(data, payment_details, amount, name, type) {
        let str;

        if(name == "Completed"){
            str =  '<div class="col-12 mx-auto d-flex justify-content-start align-items-center py-3">' +
                '<div class="rounded-circle" style="width: 6px; height: 6px; background: #A1E3CB;">' +
                '</div>' +
                '<span class="text-12 mx-2" style="color: #A1E3CB;">Completed</span>' +
                '</div>';
        }
        if(name == "In Progress"){
            str =  '<div class="col-12 mx-auto d-flex justify-content-start align-items-center py-3">' +
                '<div class="rounded-circle" style="width: 6px; height: 6px; background: #95A4FC;">' +
                '</div>' +
                '<span class="text-12 mx-2" style="color: #95A4FC;">In Progress</span>' +
                '</div>';
        }

        function ReturnTr(){
            if(type === 'order'){
                return '<tr class="text-white Regular" style="font-weight: 400; font-size: 14px; line-height: 20px;">' +
                    '                            <td class="col-2 lh-lg">'+data+'</td>' +
                    '                            <td class="col-6"><a class="text-decoration-none text-white text_blue_hover" href="/page/client/orders?id='+payment_details+'">'+payment_details+'</a></td>' +
                    '                            <td class="col-2">'+amount+'</td>' +
                    '                            <td class="col-2">'+str+'</td>' +
                    '                        </tr>';
            }

        }

        return ReturnTr();
    }
}

function DateReturn() {
    let finishDate = new Date();
    finishDate = finishDate.getFullYear() + '-' + ('0' + (finishDate.getMonth() + 1)).slice(-2) + '-' + ('0' + finishDate.getDate()).slice(-2);
    $('.data-finish').val(finishDate);

    let startDate = new Date();  // текущая дата
    startDate.setMonth(startDate.getMonth() - 1);  // отнять один месяц
    startDate = startDate.getFullYear() + '-' + ('0' + (startDate.getMonth() + 1)).slice(-2) + '-' + ('0' + startDate.getDate()).slice(-2);
    $('.data-start').val(startDate);
}

$(".span_table").click(function () {

    DateReturn();

    $(".span_table").removeClass("text-white").addClass("text-secondary fw-bolder");
    $(this).addClass("text-white").removeClass("text-secondary fw-bolder");
    type = $(this).attr("data-type");
    write_table();
});




function write_table() {
    console.log(type);
    let start = $('.data-start').val();
    let finish = $('.data-finish').val();

    $.ajax({
        url: "/backend/script/client/balance/balance_history.php",
        method: 'POST',
        dataType: 'json',
        data: {
            start: start,
            finish: finish,
            type: type
        },
        success: function (data) {
            let action = $("table");
            action.empty();

            if(type === "coming") {
                action.append(GlawStrComing);

                data.forEach(function (array) {
                    action.append(StrComing(array['data'], array['payment_details'], array['amount'], array['name']));
                });
            }
            else {
                action.append(GlawStrExpenditure);

                data.forEach(function (array) {
                    action.append(StrExpenditure(array['data'], array['payment_details'], array['amount'], array['name'], array['type']));
                });
            }
        }, error(data){
            let action = $("table");
            action.empty();
        }
    });
}

$(document).ready(function () {
    write_table();
});

$(".input-data").change( function () {
    write_table();
});