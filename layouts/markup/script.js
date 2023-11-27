$(function () {
    activeMenu();
});

function activeMenu() {
    let active_menu = $('.active_menu').val();
    let active_mini = $('.active_menu').attr('data-mini');
    let type = $('.active_menu').attr('data-type');
    let submenu = "."+$('.active_menu').attr('data-submenu');

    if (type === "sidebar") {
        $("." + active_menu).addClass("menu_sidebar_active bg_active_menu");
        $("." + active_mini).addClass("bg_active_menu menu_sidebar_active");

        if ($("." + active_menu).next().hasClass("submenu")) {
            $("." + active_menu).next().removeClass("d-none");
            $("." + active_menu).next().find(submenu).addClass('element_hover_h4');
        }
    } else {
        $("." + active_menu).addClass("text-white").removeClass("text-opacity-50");
    }


}


jQuery(($) => {
    $('.select_standard').on('click', '.select__head_standard', function () {
        if ($(this).hasClass('open')) {
            $(this).removeClass('open');
            $(this).next().fadeOut();
        } else {
            $('.select__head_standard').removeClass('open');
            $('.select__list_standard').fadeOut();
            $(this).addClass('open');
            $(this).next().fadeIn();
        }
    });

    // $('.select').on('click', '.select__item_standard', function () {
    //     $('.select__head_standard').removeClass('open');
    //     $(this).parent().fadeOut();
    //     $(this).parent().prev().text($(this).text());
    //     $("."+$(this).attr("data-input")).val($(this).attr('id'))
    // });

    $(document).click(function (e) {
        if (!$(e.target).closest('.select_standard').length) {
            $('.select__head_standard').removeClass('open');
            $('.select__list_standard').fadeOut();
        }
    });
});

function btnMenu() {
    $.post('/layouts/markup/status.php', {action: 'ajax_status'}, function (data) {
        if (data === "closed") {
            $(".my-menu").css("width", "4%");
            $(".span_sidebar").addClass("d-none");
            $(".scroll_none").addClass("d-none");
            $(".my-content").addClass("my-content-mini");

            $(".big_sidebar").addClass("d-none");
            $(".mini_sidebar").removeClass("d-none");
        } else {
            $(".my-menu").css("width", "14%");
            $(".span_sidebar").removeClass("d-none");
            $(".scroll_none").removeClass("d-none");
            $(".my-content").removeClass("my-content-mini");

            $(".big_sidebar").removeClass("d-none");
            $(".mini_sidebar").addClass("d-none");

        }
    });
}


$(function () {
    $(document).on("click", ".multimenu", function () {
        if ($(this).next().hasClass("d-none")) {
            $(this).next().removeClass("d-none");
        } else {
            $(this).next().addClass("d-none");
        }
    });
});

