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

function removeEquipmentBringed(idEquipmentBringed) {
    swal({
            title: "Valider la suppression ?",
            text: "T'es sûr que ton doigt à pas glisser ?",
            type: "warning",
            showCancelButton: "true",
            confirmButtonColor: '#DD6B55',
            confirmButtonText: "Supprimer",
            cancelButtonText: "Retour"
        },
        function () {
            var route = Routing.generate("user_equipment_delete_bringed", {"bringed": idEquipmentBringed});
            $.get(route, function (data) {
                $("#own-" + idEquipmentBringed).remove();
            });
        });
    return false;
}