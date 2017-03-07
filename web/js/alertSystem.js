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
        var route = null;
        if(path == "ADMIN_GAME") {
            route = Routing.generate("admin_delete_game", {game : id});
            $.get( route, function( data ) {
                $("#game-"+id).remove();
            });
        }
        if(path == "GAME_REQUEST") {
            route = Routing.generate("admin_reject_request_game", {requestGame : id});
            $.get( route, function( data ) {
                $("#request-"+id).remove();
            });
        }
    })
    return false;
}