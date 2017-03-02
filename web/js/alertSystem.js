function alertOnDelete(path, id)
{
    swal({
        title : "Valider la suppression ?",
        text : "Vous ne pourrez pas récupérer les données effacées!",
        type : "warning",
        showCancelButton : "true",
        confirmButtonColor : '#DD6B55',
        confirmButtonText : "Supprimer",
        cancelButtonText : "Retour"
    },
    function(){
        if(path == "ADMIN_GAME") {
            var route = Routing.generate("admin_delete_game", {game : id});
            $.get( route, function( data ) {
                $("#game-"+id).remove();
            });
        }
    })
    return false;
}