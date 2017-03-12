function displayListAll()
{
    $listAll = $("#listAll");
    $listOwn = $("#listOwn");
    $listOwn.addClass("none");
    $listAll.removeClass("none");
    return false;
}

function displayListOwn()
{
    $listAll = $("#listAll");
    $listOwn = $("#listOwn");
    $listAll.addClass("none");
    $listOwn.removeClass("none");
    return false;
}