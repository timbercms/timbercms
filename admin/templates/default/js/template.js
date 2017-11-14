$(document).on('change', 'select[name="component"], select[name="controller"]', function() {
    $(".admin-form").submit();
});