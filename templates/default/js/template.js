$(document).on('click', '.mobile-menu-button', function() {
    $(".mobile-menu-container").toggleClass("active");
});
$(document).on('click', '.parent-toggler', function() {
    $(this).parent().toggleClass("active");
    if ($(this).parent().hasClass("active"))
    {
        $(this).children().removeClass("fa-chevron-down").addClass("fa-chevron-up");
    }
    else
    {
        $(this).children().removeClass("fa-chevron-up").addClass("fa-chevron-down");
    }
});
$(document).on('click', '.header-preview', function(el) {
    var els = $("[data-label]");
    $(els).each(function (i, element) {
        $(element).removeClass("active");
    });
    $(this).addClass("active");
});