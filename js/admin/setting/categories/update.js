$(document).ready(function() {

});

$(window).on('beforeunload', function() {
    return "Вы уверены, что хотите покинуть эту страницу?";
});


{
    var getUrlParameter = function getUrlParameter(sParam) {
        var sPageURL = decodeURIComponent(window.location.search.substring(1)),
            sURLVariables = sPageURL.split('&'),
            sParameterName,
            i;
        for (i = 0; i < sURLVariables.length; i++) {
            sParameterName = sURLVariables[i].split('=');
            if (sParameterName[0] === sParam) {
                return sParameterName[1] === undefined ? true : sParameterName[1];
            }
        }
    };

    var id = getUrlParameter('id');

    var GlobalCategory;
    var GlobalCategoryParameters;
    var GlobalCategorySubcategories;

    var defaultImg;

    var status = false;
    var imgStatus = false;



    $.ajax({
        url: "/backend/script/admin/setting/category.php",
        method: 'POST',
        dataType: 'json',
        data: {
            action: "update_info",
            id: id
        },
        success: function (data) {
            GlobalCategory = data[2];
            defaultImg = GlobalCategory['img'];
            $(".input_name_gl_category").val(GlobalCategory['name']);
            $(".div_check_img").attr('src', "/res/img/img-category/"+ defaultImg);

            GlobalCategorySubcategories = data[0];
            $.each(GlobalCategorySubcategories, function(index, array) {
                $(".div_add_category").append(renderingSubcategories(array['id'], array['name']));
            });

            GlobalCategoryParameters = data[1];
            $.each(GlobalCategoryParameters, function(index, array) {
                $(".div_add_parameter").append(renderingParameters(array['id'], array['name'],  array['type'], array['mass']));
            });
        }
    });
}


//Загрузка Картинки
{
    function imgDown() {
        $(".inputImg").click();
    }

    function renderImg() {
        let img = $(".inputImg");

        $(".errorImg").text("");

        // Проверяем, был ли выбран файл
        if (img[0].files && img[0].files[0]) {
            var formData = new FormData();
            formData.append('file', img[0].files[0]);
            formData.append('action', 'checkImg');

            $.ajax({
                type: "post",
                url: '/backend/script/admin/setting/category.php',
                cache: false,
                contentType: false,
                processData: false,
                data: formData,
                dataType: 'html',
                success: function(data) {
                    if (data === "false") {
                        imgStatus = false;
                        $(".errorImg").text("Неверный тип!");
                        img.val(null);
                        $(".div_check_img").attr('src', "/res/img/img-category/"+ defaultImg);
                    } else {
                        imgStatus = true;
                        const file = img.prop('files')[0];
                        const fileUrl = URL.createObjectURL(file);

                        // Отображение временной картинки на странице
                        $(".div_check_img").attr('src', fileUrl);
                        $(".errorImg").text("");
                    }
                }
            });
        }
    }
}


//Работа с Подкатегориями
{
    //Добавление существующих покдатегорий
    function renderingSubcategories(id, name) {
        return '<div class="col-12 d-flex mb-3">\n' +
            '                                <div class="col-12 d-flex border border-secondary px-4 py-2 rounded-4 border-opacity-50"\n' +
            '                                     style="background: rgba(255, 255, 255, 0.1);">\n' +
            '                                    \n' +
            '                                    <div class="col-10">\n' +
            '\n' +
            '                                        <h6 class="opacity-50 text-14">Название Подкатегории</h6>\n' +
            '\n' +
            '                                        <input id="'+id+'" required name="email" value="'+name+'"\n' +
            '                                               class="text-white input_name_subcategories text-16 col-10 rounded-2 border-0 bg-transparent input_name_category"\n' +
            '                                               type="text"\n' +
            '                                               style=" outline:none;">\n' +
            '                                    </div>\n' +
            '\n' +
            '                                    <div class="col-2 d-flex justify-content-end align-items-center">\n' +
            '                                        <svg onclick="deleteSubcategories.call(this)" class="cursor" width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
            '                                            <path d="M14.4239 3.73641L3.73641 14.4239C3.62506 14.5353 3.5625 14.6863 3.5625 14.8438C3.5625 15.0012 3.62506 15.1522 3.73641 15.2636C3.84776 15.3749 3.99878 15.4375 4.15625 15.4375C4.31372 15.4375 4.46474 15.3749 4.57609 15.2636L15.2636 4.57609C15.3749 4.46474 15.4375 4.31372 15.4375 4.15625C15.4375 3.99878 15.3749 3.84776 15.2636 3.73641C15.1522 3.62506 15.0012 3.5625 14.8438 3.5625C14.6863 3.5625 14.5353 3.62506 14.4239 3.73641Z" fill="white"/>\n' +
            '                                            <path d="M4.57609 3.73641C4.46474 3.62506 4.31372 3.5625 4.15625 3.5625C3.99878 3.5625 3.84776 3.62506 3.73641 3.73641C3.62506 3.84776 3.5625 3.99878 3.5625 4.15625C3.5625 4.31372 3.62506 4.46474 3.73641 4.57609L14.4239 15.2636C14.5353 15.3749 14.6863 15.4375 14.8438 15.4375C15.0012 15.4375 15.1522 15.3749 15.2636 15.2636C15.3749 15.1522 15.4375 15.0012 15.4375 14.8438C15.4375 14.6863 15.3749 14.5353 15.2636 14.4239L4.57609 3.73641Z" fill="white"/>\n' +
            '                                        </svg>\n' +
            '                                    </div>\n' +
            '                                </div>\n' +
            '                            </div>';
    }

    function deleteSubcategories() {
        
        $(this).parent().parent().parent().remove();

        if (!$('input').hasClass('input_name_subcategories')) {
            addCategory();
        }
    }


    function addCategory() {
        let category = '<div class="col-12 d-flex mb-3">\n' +
            '                                <div class="col-12 d-flex border border-secondary px-4 py-2 rounded-4 border-opacity-50"\n' +
            '                                     style="background: rgba(255, 255, 255, 0.1);">\n' +
            '                                    \n' +
            '                                    <div class="col-10">\n' +
            '\n' +
            '                                        <h6 class="opacity-50 text-14">Название Подкатегории</h6>\n' +
            '\n' +
            '                                        <input required name="email" value=""\n' +
            '                                               class="text-white input_name_subcategories text-16 col-10 rounded-2 border-0 bg-transparent input_name_category"\n' +
            '                                               type="text"\n' +
            '                                               style=" outline:none;">\n' +
            '                                    </div>\n' +
            '\n' +
            '                                    <div class="col-2 d-flex justify-content-end align-items-center">\n' +
            '                                        <svg onclick="deleteSubcategories.call(this)" class="cursor" width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">\n' +
            '                                            <path d="M14.4239 3.73641L3.73641 14.4239C3.62506 14.5353 3.5625 14.6863 3.5625 14.8438C3.5625 15.0012 3.62506 15.1522 3.73641 15.2636C3.84776 15.3749 3.99878 15.4375 4.15625 15.4375C4.31372 15.4375 4.46474 15.3749 4.57609 15.2636L15.2636 4.57609C15.3749 4.46474 15.4375 4.31372 15.4375 4.15625C15.4375 3.99878 15.3749 3.84776 15.2636 3.73641C15.1522 3.62506 15.0012 3.5625 14.8438 3.5625C14.6863 3.5625 14.5353 3.62506 14.4239 3.73641Z" fill="white"/>\n' +
            '                                            <path d="M4.57609 3.73641C4.46474 3.62506 4.31372 3.5625 4.15625 3.5625C3.99878 3.5625 3.84776 3.62506 3.73641 3.73641C3.62506 3.84776 3.5625 3.99878 3.5625 4.15625C3.5625 4.31372 3.62506 4.46474 3.73641 4.57609L14.4239 15.2636C14.5353 15.3749 14.6863 15.4375 14.8438 15.4375C15.0012 15.4375 15.1522 15.3749 15.2636 15.2636C15.3749 15.1522 15.4375 15.0012 15.4375 14.8438C15.4375 14.6863 15.3749 14.5353 15.2636 14.4239L4.57609 3.73641Z" fill="white"/>\n' +
            '                                        </svg>\n' +
            '                                    </div>\n' +
            '                                </div>\n' +
            '                            </div>';

        $(".div_add_new_category").append(category);
    }
}



//Работа с Параметрами
{

    $(document).on('click', '.select__head_parameter', function () {
        if ($(this).hasClass('open')) {
            $(this).removeClass('open');
            $(this).next().fadeOut();
        } else {
            $('.select__head_parameter').removeClass('open');
            $('.select__list_parameter').fadeOut();
            $(this).addClass('open');
            $(this).next().fadeIn();
        }
    });

    $(document).on('click', '.select__item_parameter', function () {
        $('.select__head_parameter').removeClass('open');
        $(this).parent().fadeOut();
        $(this).parent().prev().text($(this).text());
        $(this).parent().prev().prev().val($(this).attr('id'));
    });

    $(document).click(function (e) {
        if (!$(e.target).closest('.select__parameter').length) {
            $('.select__head_parameter').removeClass('open');
            $('.select__list_parameter').fadeOut();
        }
    });

    function addParameter() {
        let parameter = '                                <div class="col-12 d-flex mb-3">\n' +
            '                                    <div class="col-12 d-flex border border-secondary px-4 py-2 rounded-4 border-opacity-50 align-items-center"\n' +
            '                                         style="background: rgba(255, 255, 255, 0.1);">\n' +
            '                                        <div class="col-7">\n' +
            '\n' +
            '                                            <h6 class="opacity-50 text-14">Название Параметра</h6>\n' +
            '\n' +
            '                                            <input required value=""\n' +
            '                                                   class="text-white input_name_parameter text-16 col-10 rounded-2 border-0 bg-transparent input_name_category"\n' +
            '                                                   type="text"\n' +
            '                                                   style=" outline:none;">\n' +
            '                                        </div>\n' +
            '\n' +
            '                                        <div class="select select__parameter input-price-seller rounded-2 col-3 text-13 bg_silver border_input"\n' +
            '                                             style="background-color: rgba(255, 255, 255, 0.1) !important; min-height: 28px !important; max-height: 28px; !important;">\n' +
            '                                            <input class="select__input select__input_parameter" type="hidden" value="none">\n' +
            '                                            <div class="select__head select__head_parameter text-white px-2 text-13 text-opacity-75 d-flex align-items-center"\n' +
            '                                                 style="min-height: 28px; !important;"><h6 class="text-14 my-auto">Выбрать</h6>\n' +
            '                                            </div>\n' +
            '                                            <ul class="select__list select__list_parameter p-1 bg-opacity-50 rounded-2"\n' +
            '                                                style="display: none;">\n' +
            '                                                <li id="checkbox"\n' +
            '                                                    class="select__item select__item_parameter py-1 mt-1 d-flex align-items-center">\n' +
            '                                                    Чекбокс\n' +
            '                                                </li>\n' +
            '                                                <li id="input_day"\n' +
            '                                                    class="select__item select__item_parameter py-1 mt-1 d-flex align-items-center">\n' +
            '                                                    Инпут - дней\n' +
            '                                                </li>\n' +
            '\n' +
            '                                                <li id="input_ht"\n' +
            '                                                    class="select__item select__item_parameter py-1 mt-1 d-flex align-items-center">\n' +
            '                                                    Инпут - шт.\n' +
            '                                                </li>\n' +
            '\n' +
            '                                                <li id="input_ed"\n' +
            '                                                    class="select__item select__item_parameter py-1 mt-1 d-flex align-items-center">\n' +
            '                                                    Инпут - ед.\n' +
            '                                                </li>\n' +
            '\n' +
            '                                                <li id="input_geo"\n' +
            '                                                    class="select__item select__item_parameter py-1 mt-1 d-flex align-items-center">\n' +
            '                                                    Гео\n' +
            '                                                </li>\n' +
            '\n' +
            '                                                <li id="input_bm"\n' +
            '                                                    class="select__item select__item_parameter py-1 mt-1 d-flex align-items-center">\n' +
            '                                                    Бм\n' +
            '                                                </li>\n' +
            '\n' +
            '                                            </ul>\n' +
            '                                        </div>\n' +
            '\n' +
            '                                        <div class="col-2 d-flex justify-content-end align-items-center">\n' +
            '                                            <svg onclick="deleteParameter.call(this)" class="cursor" width="19"\n' +
            '                                                 height="19" viewBox="0 0 19 19" fill="none"\n' +
            '                                                 xmlns="http://www.w3.org/2000/svg">\n' +
            '                                                <path d="M14.4239 3.73641L3.73641 14.4239C3.62506 14.5353 3.5625 14.6863 3.5625 14.8438C3.5625 15.0012 3.62506 15.1522 3.73641 15.2636C3.84776 15.3749 3.99878 15.4375 4.15625 15.4375C4.31372 15.4375 4.46474 15.3749 4.57609 15.2636L15.2636 4.57609C15.3749 4.46474 15.4375 4.31372 15.4375 4.15625C15.4375 3.99878 15.3749 3.84776 15.2636 3.73641C15.1522 3.62506 15.0012 3.5625 14.8438 3.5625C14.6863 3.5625 14.5353 3.62506 14.4239 3.73641Z"\n' +
            '                                                      fill="white"/>\n' +
            '                                                \\n\' +\n' +
            '                                                <path d="M4.57609 3.73641C4.46474 3.62506 4.31372 3.5625 4.15625 3.5625C3.99878 3.5625 3.84776 3.62506 3.73641 3.73641C3.62506 3.84776 3.5625 3.99878 3.5625 4.15625C3.5625 4.31372 3.62506 4.46474 3.73641 4.57609L14.4239 15.2636C14.5353 15.3749 14.6863 15.4375 14.8438 15.4375C15.0012 15.4375 15.1522 15.3749 15.2636 15.2636C15.3749 15.1522 15.4375 15.0012 15.4375 14.8438C15.4375 14.6863 15.3749 14.5353 15.2636 14.4239L4.57609 3.73641Z"\n' +
            '                                                      fill="white"/>\n' +
            '                                            </svg>\n' +
            '                                        </div>\n' +
            '                                    </div>\n' +
            '                                </div>\n';

        $(".div_add_new_parameter").append(parameter);
    }


    function deleteParameter() {
        $(this).parent().parent().parent().remove();

        if (!$('input').hasClass('input_name_parameter')) {
            addParameter();
        }
    }


    function renderingParameters(id, name, type, mass) {
        let filterName;
        let filter;

        if(type === "checkbox"){
            filter = "checkbox";
            filterName = "Чекбокс";
        }
        if(type === "two_inputs"){
            filter = "input_bm";
            filterName = "БМ";
        }
        if(type === "input"){
            if (mass === "дней"){
                filter = "input_day";
                filterName = "Инпут - дней";
            }
            if (mass === "шт."){
                filter = "input_ed";
                filterName = "Инпут - ед.";
            }
            if (mass === "ед."){
                filter = "input_day";
                filterName = "Инпут - дней";
            }
        }
        if(type === "select"){
            filter = "input_geo";
            filterName = "Гео";
        }

        let parameter = '<div class="col-12 d-flex mb-3">\n' +
            '                                    <div class="col-12 d-flex border border-secondary px-4 py-2 rounded-4 border-opacity-50 align-items-center"\n' +
            '                                         style="background: rgba(255, 255, 255, 0.1);">\n' +
            '                                        <div class="col-7">\n' +
            '\n' +
            '                                            <h6 class="opacity-50 text-14">Название Параметра</h6>\n' +
            '\n' +
            '                                            <input id="'+id+'" required value="'+name+'"\n' +
            '                                                   class="text-white input_name_parameter text-16 col-10 rounded-2 border-0 bg-transparent "\n' +
            '                                                   type="text"\n' +
            '                                                   style=" outline:none;">\n' +
            '                                        </div>\n' +
            '\n' +
            '                                        <div class="select select__parameter input-price-seller rounded-2 col-3 text-13 bg_silver border_input"\n' +
            '                                             style="background-color: rgba(255, 255, 255, 0.1) !important; min-height: 28px !important; max-height: 28px; !important;">\n' +
            '                                            <input class="select__input select__input_parameter" type="hidden" value="'+filter+'">\n' +
            '                                            <div class="select__head select__head_parameter text-white px-2 text-13 text-opacity-75 d-flex align-items-center"\n' +
            '                                                 style="min-height: 28px; !important;"><h6 class="text-14 my-auto">'+filterName+'</h6>\n' +
            '                                            </div>\n' +
            '                                            <ul class="select__list select__list_parameter p-1 bg-opacity-50 rounded-2"\n' +
            '                                                style="display: none;">\n' +
            '                                                <li id="checkbox"\n' +
            '                                                    class="select__item select__item_parameter py-1 mt-1 d-flex align-items-center">\n' +
            '                                                    Чекбокс\n' +
            '                                                </li>\n' +
            '                                                <li id="input_day"\n' +
            '                                                    class="select__item select__item_parameter py-1 mt-1 d-flex align-items-center">\n' +
            '                                                    Инпут - дней\n' +
            '                                                </li>\n' +
            '\n' +
            '                                                <li id="input_ht"\n' +
            '                                                    class="select__item select__item_parameter py-1 mt-1 d-flex align-items-center">\n' +
            '                                                    Инпут - шт.\n' +
            '                                                </li>\n' +
            '\n' +
            '                                                <li id="input_ed"\n' +
            '                                                    class="select__item select__item_parameter py-1 mt-1 d-flex align-items-center">\n' +
            '                                                    Инпут - ед.\n' +
            '                                                </li>\n' +
            '\n' +
            '                                                <li id="input_geo"\n' +
            '                                                    class="select__item select__item_parameter py-1 mt-1 d-flex align-items-center">\n' +
            '                                                    Гео\n' +
            '                                                </li>\n' +
            '\n' +
            '                                                <li id="input_bm"\n' +
            '                                                    class="select__item select__item_parameter py-1 mt-1 d-flex align-items-center">\n' +
            '                                                    Бм\n' +
            '                                                </li>\n' +
            '\n' +
            '                                            </ul>\n' +
            '                                        </div>\n' +
            '\n' +
            '                                        <div class="col-2 d-flex justify-content-end align-items-center">\n' +
            '                                            <svg onclick="deleteParameter.call(this)" class="cursor" width="19"\n' +
            '                                                 height="19" viewBox="0 0 19 19" fill="none"\n' +
            '                                                 xmlns="http://www.w3.org/2000/svg">\n' +
            '                                                <path d="M14.4239 3.73641L3.73641 14.4239C3.62506 14.5353 3.5625 14.6863 3.5625 14.8438C3.5625 15.0012 3.62506 15.1522 3.73641 15.2636C3.84776 15.3749 3.99878 15.4375 4.15625 15.4375C4.31372 15.4375 4.46474 15.3749 4.57609 15.2636L15.2636 4.57609C15.3749 4.46474 15.4375 4.31372 15.4375 4.15625C15.4375 3.99878 15.3749 3.84776 15.2636 3.73641C15.1522 3.62506 15.0012 3.5625 14.8438 3.5625C14.6863 3.5625 14.5353 3.62506 14.4239 3.73641Z"\n' +
            '                                                      fill="white"/>\n' +
            '                                                \\n\' +\n' +
            '                                                <path d="M4.57609 3.73641C4.46474 3.62506 4.31372 3.5625 4.15625 3.5625C3.99878 3.5625 3.84776 3.62506 3.73641 3.73641C3.62506 3.84776 3.5625 3.99878 3.5625 4.15625C3.5625 4.31372 3.62506 4.46474 3.73641 4.57609L14.4239 15.2636C14.5353 15.3749 14.6863 15.4375 14.8438 15.4375C15.0012 15.4375 15.1522 15.3749 15.2636 15.2636C15.3749 15.1522 15.4375 15.0012 15.4375 14.8438C15.4375 14.6863 15.3749 14.5353 15.2636 14.4239L4.57609 3.73641Z"\n' +
            '                                                      fill="white"/>\n' +
            '                                            </svg>\n' +
            '                                        </div>\n' +
            '                                    </div>\n' +
            '                                </div>\n';


        return parameter;
    }
}

function update() {

    let arraySubcategories = [];
    let arraySubcategoriesNew = [];

    let arrayParameters = [];
    let arrayParametersNew = [];

    $("div").removeClass("border-danger border-2");
    $(".errorImg").val("");
    $(".text-error").text("");

    let input_name_gl_category = $(".input_name_gl_category").val();

    if(input_name_gl_category.trim() === '') {
        $(".input_name_gl_category").parent().parent().addClass("border-danger border-2");
        $(".input_name_gl_category").focus();
        return false;
    }
    else status = true;

    let isFirstConditionPassed = false;

    if ($('input').hasClass('input_name_subcategories')) {
        $('.input_name_subcategories').each(function() {
            let input_name_subcategories = $(this).val();

            if(input_name_subcategories.trim() === '') {
                $(this).parent().parent().addClass("border-danger border-2");
                $(this).focus();
                isFirstConditionPassed = false;
                status = false;
                return false;
            } else {
                status = true;
                isFirstConditionPassed = true;

                var element = $(this); // Текущий элемент в цикле
                var elementId = element.attr('id'); // Значение атрибута "id" текущего элемента

                //Для существующих
                if (elementId) {
                    let elementData = {
                        id: elementId,
                        name: element.val()
                    };
                    arraySubcategories.push(elementData);
                }
                else {
                    arraySubcategoriesNew.push(element.val());
                }
            }
        });
    }
    else isFirstConditionPassed = true;


    if (isFirstConditionPassed && $('input').hasClass('input_name_parameter')) {
        status = false;

        $('.input_name_parameter').each(function() {
            let input_name_parameter = $(this).val();

            if(input_name_parameter.trim() === '') {
                $(this).parent().parent().addClass("border-danger border-2");
                $(this).focus();
                status = false;
                return false;
            } else {
                let block = $(this).parent().parent();
                let element = block.find('.select__input_parameter');
                let idValue = element.val();

                if (idValue === "none"){
                    $(this).parent().parent().addClass("border-danger border-2");
                    $(this).focus();
                    return false;
                }
                else {
                    status = true;

                    var input = $(this); // Текущий элемент в цикле
                    var elementId = input.attr('id'); // Значение атрибута "id" текущего элемента

                    //Для существующих
                    if (elementId) {
                        let elementData = {
                            id: elementId,
                            name: input_name_parameter,
                            key: idValue
                        };
                        arrayParameters.push(elementData);
                    }
                    else {
                        let elementData = {
                            name: input_name_parameter,
                            key: idValue
                        };
                        arrayParametersNew.push(elementData);
                    }

                }
            }
        });
    }


    if(status) {
        let formData = new FormData();

        formData.append('action', 'update');
        formData.append('id', id);
        formData.append('name_global_category', input_name_gl_category);

        if(imgStatus){
            let img = $(".inputImg");
            formData.append('file', img[0].files[0]);
        }
        if (arraySubcategories.length !== 0) {
            formData.append('arraySubcategories', JSON.stringify(arraySubcategories));
        }
        if (arraySubcategoriesNew.length !== 0) {
            formData.append('arraySubcategoriesNew', JSON.stringify(arraySubcategoriesNew));
        }
        if (arrayParameters.length !== 0) {
            formData.append('arrayParameters', JSON.stringify(arrayParameters));
        }
        if (arrayParametersNew.length !== 0) {
            formData.append('arrayParametersNew', JSON.stringify(arrayParametersNew));
        }

        // // Вывод содержимого объекта formData в консоль
        // for (let pair of formData.entries()) {
        //     console.log(pair[0] + ': ' + pair[1]);
        // }

        $.ajax({
            url: "/backend/script/admin/setting/category.php",
            method: 'POST',
            dataType: 'html',
            cache: false,
            contentType: false,
            processData: false,
            data: formData,
            success: function (data) {
                console.log(data);
                if (data === "save"){
                    alert("Изменения сохранены!");
                    window.location.href = "/page/admin/setting/categories/search";
                }
            }
        });
    }

}
