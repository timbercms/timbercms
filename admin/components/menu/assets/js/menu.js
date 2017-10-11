jQuery("input[name='title']").focusout(function () {
    alert("Test");
    if ($("input[name='alias']").val().length == 0)
    {
        createAlias($("input[name='title']").val());
    }
});