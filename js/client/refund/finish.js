const IdOrder = new URLSearchParams(window.location.search).get("id");
const ArrayOrder = new URLSearchParams(window.location.search).get("array");

var ArrayThis = [];

// var array = $.map(ArrayOrder.split(','), function(value) {
//     return parseInt(value);
// });

const svg = '<svg width="19" height="19" viewBox="0 0 19 19" fill="none"\n' +
    '                                             xmlns="http://www.w3.org/2000/svg">\n' +
    '                                            <path d="M3.98257 9.08038L3.98234 9.08016C3.87099 8.96881 3.71997 8.90625 3.5625 8.90625C3.40503 8.90625 3.25401 8.96881 3.14266 9.08016C3.03131 9.1915 2.96875 9.34253 2.96875 9.5C2.96875 9.50951 2.96898 9.51902 2.96944 9.52852C2.97653 9.67596 3.03828 9.81547 3.14266 9.91984L3.14288 9.92007L7.29891 14.0761C7.53078 14.308 7.90672 14.308 8.13859 14.0761L16.4511 5.76359C16.5624 5.65224 16.625 5.50122 16.625 5.34375C16.625 5.18628 16.5624 5.03526 16.4511 4.92391C16.3397 4.81256 16.1887 4.75 16.0312 4.75C15.8738 4.75 15.7228 4.81256 15.6114 4.92391L7.71875 12.8166L3.98257 9.08038Z"\n' +
    '                                                  fill="white"/>\n' +
    '                                        </svg>';

function adjustTextareaHeight(event) {
    let textarea = event.target;
    textarea.style.height = "auto";
    textarea.style.height = textarea.scrollHeight + "px";
}


$("body").on("click", ".div_mini_svg_check", function () {
    let hasClass = $(this).hasClass("border-secondary");
    if (hasClass) {
        $(this).removeClass("border-secondary");
        $(this).append(svg);
        $(".btn_save").prop('disabled', false);

        let allWithoutBorder = true;
        $('.div_mini_svg_check').each(function () {
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

        ArrayThis = [];
        var elements = document.getElementsByClassName("div_mini_svg_check"); // Получаем все элементы с классом "data-id"

        for (var i = 0; i < elements.length; i++) {
            var element = elements[i];
            var buttonId = element.getAttribute("data-id"); // Получаем значение атрибута data-id элемента
            ArrayThis.push(buttonId); // Добавляем значение в массив
        }

    } else {
        ArrayThis = [];

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

    var index = ArrayThis.indexOf(id);

    if (index === -1) {
        ArrayThis.push(id);
    } else {
        ArrayThis.splice(index, 1);
    }

});


$(function () {
    WriteRefund();
    // sessionStorage.clear();
    // sessionStorage.setItem('orders', new URLSearchParams(window.location.search).get("id"));
    // sessionStorage.setItem('array', new URLSearchParams(window.location.search).get("array"));
});

const tableTr = '<tr class="border-bottom border-secondary text-secondary text-12 fw-bolder">\n' +
    '                            <td class="col-1 lh-lg">ID</td>\n' +
    '                            <td class="col-8">Товар</td>\n' +
    '                            <td class="col-3 py-3">\n' +
    '                                <div class="col-12 d-flex justify-content-end">\n' +
    '                                    <div onclick="$(\'textarea\').val(\'\');" class="div_mini_svg mx-3 bg_hover">\n' +
    '                                        <svg class="mx-auto my-auto" width="19" height="19" viewBox="0 0 19 19"\n' +
    '                                             fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
    '                                            <path d="M14.4239 3.73641L3.73641 14.4239C3.62506 14.5353 3.5625 14.6863 3.5625 14.8438C3.5625 15.0012 3.62506 15.1522 3.73641 15.2636C3.84776 15.3749 3.99878 15.4375 4.15625 15.4375C4.31372 15.4375 4.46474 15.3749 4.57609 15.2636L15.2636 4.57609C15.3749 4.46474 15.4375 4.31372 15.4375 4.15625C15.4375 3.99878 15.3749 3.84776 15.2636 3.73641C15.1522 3.62506 15.0012 3.5625 14.8438 3.5625C14.6863 3.5625 14.5353 3.62506 14.4239 3.73641Z"\n' +
    '                                                  fill="white"/>\n' +
    '                                            <path d="M4.57609 3.73641C4.46474 3.62506 4.31372 3.5625 4.15625 3.5625C3.99878 3.5625 3.84776 3.62506 3.73641 3.73641C3.62506 3.84776 3.5625 3.99878 3.5625 4.15625C3.5625 4.31372 3.62506 4.46474 3.73641 4.57609L14.4239 15.2636C14.5353 15.3749 14.6863 15.4375 14.8438 15.4375C15.0012 15.4375 15.1522 15.3749 15.2636 15.2636C15.3749 15.1522 15.4375 15.0012 15.4375 14.8438C15.4375 14.6863 15.3749 14.5353 15.2636 14.4239L4.57609 3.73641Z"\n' +
    '                                                  fill="white"/>\n' +
    '                                        </svg>\n' +
    '                                    </div>\n' +
    '\n' +
    '\n' +
    '                                    <div  data-id="\'+id+\'" class="div_mini_svg div_mini_svg_glaw border-secondary"></div>\n' +
    '                                </div>\n' +
    '                            </td>\n' +
    '                        </tr>';


function writeTr(id, value) {
    return ' <tr class="text-white Regular">\n' +
        '                            <td class="col-1">\n' +
        '                                <h6 class="text-14">' + id + '</h6>\n' +
        '                            </td>\n' +
        '                            <td class="col-9">\n' +
        '                                <h6 class="text-14">\n' +
        '                                    ' + value + '\n' +
        '                                </h6>\n' +
        '                            </td>\n' +
        '                            <td class="col-2 py-4">\n' +
        '                                <div class="col-12 d-flex">\n' +
        '                                    <div class="col-12 d-flex justify-content-end">\n' +
        '\n' +
        '                                        <button onclick="ShowDescription.call(this)" data-id="' + id + '" class="rounded-3 mx-3 w-85sm text-white bg-transparent border_blue btn_buy bg-transparent text-decoration-none text-center align-items-center d-flex justify-content-center text-14">\n' +
        '                                            Инфо\n' +
        '                                        </button>\n' +
        '\n' +
        '                                        <div data-id="' + id + '" class="div_mini_svg div_mini_svg_check border-secondary"></div>\n' +
        '                                    </div>\n' +
        '                                </div>\n' +
        '                            </td>\n' +
        '                        </tr>' +
        '<tr class="text-white Regular d-none tr-' + id + '">\n' +
        '                            <td class="col-1"></td>\n' +
        '                            <td class="col-9">\n' +
        '                                <textarea maxlength="600" oninput="adjustTextareaHeight(event)" class="col-12 p-3 text-white bg-white bg-opacity-10 border border-secondary rounded-3 border-opacity-50" name="" id="" cols="30" rows="3"></textarea>\n' +
        '\n' +
        '\n' +
        '                                <div class="col-12 my-4 div_render">\n' +
        '                                <input class="ArrayHidden'+id+'">' +
        '                                <input type="file" class="InputHiddenFile InputHiddenFile'+id+'">\n' +
        '                                    <svg data-input="InputHiddenFile'+id+'" class="cursor svgAddImg" width="100" height="100" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
        '                                        <rect width="100" height="100" rx="16" fill="white" fill-opacity="0.1"/>\n' +
        '                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M66.5456 63.7331C66.5456 63.7331 65.31 64.9688 63.5625 64.9688H35.4375C35.4375 64.9688 33.69 64.9688 32.4544 63.7331C32.4544 63.7331 31.2188 62.4975 31.2188 60.75V41.0625C31.2188 41.0625 31.2188 39.315 32.4544 38.0794C32.4544 38.0794 33.69 36.8438 35.4375 36.8438H40.3099L42.7049 33.2512C42.9657 32.86 43.4048 32.625 43.875 32.625H55.125C55.5952 32.625 56.0343 32.86 56.2951 33.2512L58.6901 36.8438H63.5625C63.5625 36.8438 65.31 36.8438 66.5456 38.0794C66.5456 38.0794 67.7812 39.315 67.7812 41.0625V60.75C67.7812 60.75 67.7812 62.4975 66.5456 63.7331ZM64.5569 61.7444C64.5569 61.7444 64.9688 61.3325 64.9688 60.75V41.0625C64.9688 41.0625 64.9688 40.48 64.5569 40.0681C64.5569 40.0681 64.145 39.6562 63.5625 39.6562H57.9375C57.4673 39.6562 57.0282 39.4213 56.7674 39.03L54.3724 35.4375H44.6276L42.2326 39.03C41.9718 39.4213 41.5327 39.6562 41.0625 39.6562H35.4375C35.4375 39.6562 34.855 39.6562 34.4431 40.0681C34.4431 40.0681 34.0312 40.48 34.0312 41.0625V60.75C34.0312 60.75 34.0312 61.3325 34.4431 61.7444C34.4431 61.7444 34.855 62.1562 35.4375 62.1562H63.5625C63.5625 62.1562 64.145 62.1562 64.5569 61.7444Z" fill="white"/>\n' +
        '                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M49.5 42.4688C49.5 42.4688 52.7037 42.4687 54.969 44.7341C54.969 44.7341 57.2344 46.9994 57.2344 50.2031C57.2344 50.2031 57.2344 53.4068 54.969 55.6722C54.969 55.6722 52.7037 57.9375 49.5 57.9375C49.5 57.9375 46.2963 57.9375 44.031 55.6722C44.031 55.6722 41.7656 53.4068 41.7656 50.2031C41.7656 50.2031 41.7656 46.9994 44.031 44.7341C44.031 44.7341 46.2963 42.4688 49.5 42.4688ZM49.5 45.2812C49.5 45.2812 47.4613 45.2813 46.0197 46.7228C46.0197 46.7228 44.5781 48.1644 44.5781 50.2031C44.5781 50.2031 44.5781 52.2418 46.0197 53.6834C46.0197 53.6834 47.4613 55.125 49.5 55.125C49.5 55.125 51.5387 55.125 52.9803 53.6834C52.9803 53.6834 54.4219 52.2418 54.4219 50.2031C54.4219 50.2031 54.4219 48.1644 52.9803 46.7228C52.9803 46.7228 51.5387 45.2812 49.5 45.2812Z" fill="white"/>\n' +
        '                                    </svg>\n' +
        '\n' +
        '                                </div>\n' +
        '                            </td>\n' +
        '                            <td class="col-2"></td>\n' +
        '                        </tr>';
}

function WriteRefund() {

    $.ajax({
        url: "/backend/client/refunds/finish.php",
        method: 'POST',
        dataType: 'json',
        data: {
            array: ArrayOrder
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

function ShowDescription() {
    let tr = ".tr-" + $(this).attr('data-id');

    if ($(tr).hasClass('d-none')) {
        $(this).addClass("bg_blue");
        $(tr).removeClass('d-none');
    } else {
        $(this).removeClass("bg_blue");
        $(tr).addClass('d-none');
    }
}


$('body').on('click', '.svgAddImg', function () {
    $('.'+$(this).attr('data-input')).trigger('click');
});

$(document).ready(function () {
    $("body").on("change", ".InputHiddenFile", function (event) {
        var selectedFile = event.target.files[0];
        if (selectedFile && selectedFile.type.startsWith('image/')) {
            var reader = new FileReader(); // Создание объекта FileReader для чтения файла

            reader.onload = function (event) {
                var imgSrc = event.target.result; // Получение Data URL файла

                // Создание элемента <img> и установка источника изображения
                var imgElement = $('<img class="mx-3" width="150">');
                imgElement.attr('src', imgSrc);

                // Добавление элемента <img> в контейнер изображений
                imgElement.appendTo('.div_render');
            };

            // Чтение файла как Data URL
            reader.readAsDataURL(selectedFile);
        }
        else alert(123)

    });
});
