function createAlias(string)
{
    string = string.replace(/ /g, '-');
    string = encodeURI(string).toLowerCase();
    $("input[name='alias']").val(string);
}