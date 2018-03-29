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