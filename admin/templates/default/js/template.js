$(document).on('change', 'select[name="component"], select[name="controller"]', function() {
    $(".admin-form").submit();
});
$(document).on('click', '.save-and-new', function() {
    $(".admin-form").attr("action", $(this).attr("data-action"));
    $(".admin-form").submit();
});
$(document).on('click', '.delete-by-ids', function() {
    swal({
        title: 'Really delete?',
        text: "You won't be able to undo this!",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.value)
        {
            $(".admin-form").submit();
        }
    })
});