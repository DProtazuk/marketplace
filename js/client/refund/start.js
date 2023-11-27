const tableTr = '<tr class="border-bottom border-secondary text-secondary text-12 fw-bolder">\n' +
    '                            <td class="col-1 lh-lg">ID</td>\n' +
    '                            <td class="col-9">Товар</td>\n' +
    '                            <td class="col-1 py-3">\n' +
    '                                <div class="col-9 mx-auto d-flex justify-content-end">\n' +
    '                                    <div class="div_mini_svg div_mini_svg_glaw border-secondary"></div>\n' +
    '                                </div>\n' +
    '                            </td>\n' +
    '                        </tr>';

function writeTr(id,value) {
    return '<tr class="text-white border-bottom border-secondary Regular text-14">\n' +
        '                            <td class="col-1 lh-lg">'+id+'</td>\n' +
        '                            <td class="col-9">'+value +
        '                            </td>\n' +
        '                            <td class="col-1 py-4">\n' +
        '                                <div class="col-9 mx-auto d-flex justify-content-between">\n' +
        '\n' +
        '                                    <div class="div_mini_svg div_hover_blue">\n' +
        '                                        <svg width="19" height="19" viewBox="0 0 19 19" fill="none"\n' +
        '                                             xmlns="http://www.w3.org/2000/svg">\n' +
        '                                            <path d="M10.0938 16.0312L10.0938 2.96875C10.0938 2.64083 9.82792 2.375 9.5 2.375C9.17208 2.375 8.90625 2.64083 8.90625 2.96875L8.90625 16.0312C8.90625 16.3592 9.17208 16.625 9.5 16.625C9.82792 16.625 10.0938 16.3592 10.0938 16.0312Z"\n' +
        '                                                  fill="white"/>\n' +
        '                                            <path d="M9.08016 2.5489L3.7364 7.89266C3.62506 8.00401 3.5625 8.15503 3.5625 8.3125C3.5625 8.46997 3.62506 8.62099 3.7364 8.73234C3.84775 8.84369 3.99878 8.90625 4.15625 8.90625C4.31372 8.90625 4.46475 8.84369 4.5761 8.73234L9.5 3.80844L14.4239 8.73234C14.5353 8.84369 14.6863 8.90625 14.8438 8.90625C15.0012 8.90625 15.1522 8.84369 15.2636 8.73234C15.3749 8.62099 15.4375 8.46997 15.4375 8.3125C15.4375 8.15503 15.3749 8.00401 15.2636 7.89266L9.91984 2.5489C9.68797 2.31703 9.31203 2.31703 9.08016 2.5489Z"\n' +
        '                                                  fill="white"/>\n' +
        '                                        </svg>\n' +
        '                                    </div>\n' +
        '\n' +
        '                                    <div data-id="'+id+'" class="div_mini_svg div_mini_svg_check border-secondary">\n' +
        '\n' +
        '                                    </div>\n' +
        '                                </div>\n' +
        '                            </td>\n' +
        '                        </tr>';
}

function writeTrActive(id,value) {
    return '<tr class="text-white border-bottom border-secondary Regular text-14">\n' +
        '                            <td class="col-1 lh-lg">'+id+'</td>\n' +
        '                            <td class="col-9">'+value +
        '                            </td>\n' +
        '                            <td class="col-1 py-4">\n' +
        '                                <div class="col-9 mx-auto d-flex justify-content-between">\n' +
        '\n' +
        '                                    <div class="div_mini_svg div_hover_blue">\n' +
        '                                        <svg width="19" height="19" viewBox="0 0 19 19" fill="none"\n' +
        '                                             xmlns="http://www.w3.org/2000/svg">\n' +
        '                                            <path d="M10.0938 16.0312L10.0938 2.96875C10.0938 2.64083 9.82792 2.375 9.5 2.375C9.17208 2.375 8.90625 2.64083 8.90625 2.96875L8.90625 16.0312C8.90625 16.3592 9.17208 16.625 9.5 16.625C9.82792 16.625 10.0938 16.3592 10.0938 16.0312Z"\n' +
        '                                                  fill="white"/>\n' +
        '                                            <path d="M9.08016 2.5489L3.7364 7.89266C3.62506 8.00401 3.5625 8.15503 3.5625 8.3125C3.5625 8.46997 3.62506 8.62099 3.7364 8.73234C3.84775 8.84369 3.99878 8.90625 4.15625 8.90625C4.31372 8.90625 4.46475 8.84369 4.5761 8.73234L9.5 3.80844L14.4239 8.73234C14.5353 8.84369 14.6863 8.90625 14.8438 8.90625C15.0012 8.90625 15.1522 8.84369 15.2636 8.73234C15.3749 8.62099 15.4375 8.46997 15.4375 8.3125C15.4375 8.15503 15.3749 8.00401 15.2636 7.89266L9.91984 2.5489C9.68797 2.31703 9.31203 2.31703 9.08016 2.5489Z"\n' +
        '                                                  fill="white"/>\n' +
        '                                        </svg>\n' +
        '                                    </div>\n' +
        '\n' +
        '                                    <div data-id="'+id+'" class="div_mini_svg div_mini_svg_check">'+svg+'</div>\n' +
        '                                </div>\n' +
        '                            </td>\n' +
        '                        </tr>';
}

$(function(){
    WriteRefund();
});

function WriteRefund() {
    let id = new URLSearchParams(window.location.search).get("id");

    $.ajax({
        url: "/backend/client/refunds/filter_start.php",
        method: 'POST',
        dataType: 'json',
        data: {
            id: id
        },
        success: function (data) {
            let table = $(".table_refund");
            table.empty();
            table.append(tableTr);

            data.forEach(function (array) {
                let value = array['value'].substring(0, 110) + "...";

                table.append(writeTr(array['id'], value));
            });

        }
    });
}


const svg = '<svg width="19" height="19" viewBox="0 0 19 19" fill="none"\n' +
    '                                             xmlns="http://www.w3.org/2000/svg">\n' +
    '                                            <path d="M3.98257 9.08038L3.98234 9.08016C3.87099 8.96881 3.71997 8.90625 3.5625 8.90625C3.40503 8.90625 3.25401 8.96881 3.14266 9.08016C3.03131 9.1915 2.96875 9.34253 2.96875 9.5C2.96875 9.50951 2.96898 9.51902 2.96944 9.52852C2.97653 9.67596 3.03828 9.81547 3.14266 9.91984L3.14288 9.92007L7.29891 14.0761C7.53078 14.308 7.90672 14.308 8.13859 14.0761L16.4511 5.76359C16.5624 5.65224 16.625 5.50122 16.625 5.34375C16.625 5.18628 16.5624 5.03526 16.4511 4.92391C16.3397 4.81256 16.1887 4.75 16.0312 4.75C15.8738 4.75 15.7228 4.81256 15.6114 4.92391L7.71875 12.8166L3.98257 9.08038Z"\n' +
    '                                                  fill="white"/>\n' +
    '                                        </svg>';


$("body").on("click", ".div_mini_svg_check", function (){
    let hasClass = $(this).hasClass("border-secondary");
    if (hasClass) {
        $(this).removeClass("border-secondary");
        $(this).append(svg);
        $(".btn_save").prop('disabled', false);

        let allWithoutBorder = true;
        $('.div_mini_svg_check').each(function() {
            if ($(this).hasClass('border-secondary')) {
                allWithoutBorder = false;
                return false; // Прерываем цикл each(), если найден элемент с классом 'border-secondary'
            }
        });

        if (allWithoutBorder) {
            $(".div_mini_svg_glaw").removeClass("border-secondary");
            $(".div_mini_svg_glaw").append(svg);
        }
    } else {
        $(".btn_save").prop('disabled', true);

        $(this).addClass("border-secondary");
        $(this).empty();

        $(".div_mini_svg_glaw").addClass("border-secondary");
        $(".div_mini_svg_glaw").empty();
    }
});

$("body").on("click", ".div_mini_svg_glaw", function () {
    let hasClass = $(this).hasClass("border-secondary");
    if (hasClass) {
        $(".btn_save").prop('disabled', false);
        $(".div_mini_svg_check").addClass("border-secondary");
        $(".div_mini_svg_check").empty();

        $(this).removeClass("border-secondary");
        $(this).append(svg);

        $(".div_mini_svg_check").removeClass("border-secondary");
        $(".div_mini_svg_check").append(svg);

        $("#ArrayId").val("");
        var elements = document.getElementsByClassName("div_mini_svg_check"); // Получаем все элементы с классом "data-id"
        var idArray = [];

        for (var i = 0; i < elements.length; i++) {
            var element = elements[i];
            var buttonId = element.getAttribute("data-id"); // Получаем значение атрибута data-id элемента
            idArray.push(buttonId); // Добавляем значение в массив
        }
        $("#ArrayId").val(idArray); // Обновляем значение скрытого input

    } else {
        $(".btn_save").prop('disabled', true);

        $(this).addClass("border-secondary");
        $(this).empty();

        $(".div_mini_svg_check").addClass("border-secondary");
        $(".div_mini_svg_check").empty();

        $("#ArrayId").val("");
    }
});
$("body").on("click", ".div_mini_svg_check", function () {
    let id = $(this).attr('data-id');

    let hiddenInputValue = $("#ArrayId").val(); // Получаем текущее значение скрытого input
    let idArray = hiddenInputValue ? hiddenInputValue.split(",") : []; // Разделяем значение по запятым или создаем пустой массив

    // Проверяем, если значение уже присутствует в массиве, то удаляем его
    let index = idArray.indexOf(id);
    if (index !== -1) {
        idArray.splice(index, 1); // Удаляем значение из массива
    } else {
        idArray.push(id); // Добавляем значение в массив
    }

    let updatedValue = idArray.join(","); // Объединяем значения массива с запятыми
    $("#ArrayId").val(updatedValue); // Обновляем значение скрытого input
});


function Search() {
    let id = new URLSearchParams(window.location.search).get("id");
    let search = $(".input_search_account").val();
    let hiddenInputValue = $("#ArrayId").val(); // Получаем текущее значение скрытого input

    $.ajax({
        url: "/backend/client/refunds/filter_start.php",
        method: 'POST',
        dataType: 'json',
        data: {
            id: id,
            search: search,
            hiddenInputValue: hiddenInputValue
        },
        success: function (data) {
            console.log(data);

            let hasClass = $(".div_mini_svg_glaw").hasClass("border-secondary");

            let table = $(".table_refund");
            table.empty();
            table.append(tableTr);

            if (!hasClass) {
                $(".div_mini_svg_glaw").removeClass("border-secondary");
                $(".div_mini_svg_glaw").append(svg);
            }

            if (data['search'].length !== 0) {
                $(".div_mini_svg_glaw").addClass("border-secondary");
                $(".div_mini_svg_glaw").empty();

                data['search'].forEach(function (array) {
                    let value = array['value'].substring(0, 110) + "...";

                    table.append(writeTr(array['id'], value));
                });
            }

            if (data['check'].length !== 0) {
                data['check'].forEach(function (array) {
                    let value = array['value'].substring(0, 110) + "...";

                    table.append(writeTrActive(array['id'], value));
                });
            }
        }
    });
}