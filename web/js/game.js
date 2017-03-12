function chooseToPlay(idGame)
{
    var route = Routing.generate("user_play_game", {"game" : idGame});
    $.get(route, function(data){
        $gameSelectedCounter = $('#choose-to-play-counter-' + idGame);
        $gameSelectedLink = $("#choose-to-play-link-"+ idGame);
        $gameSelectedDiv = $("#choose-to-play-div-"+ idGame);
        $plusOrMinus = $("#choose-to-play-link-"+ idGame +" img");
        $gameSelectedLink.attr("onclick", "removeGamePlayed("+ idGame +")");
        $gameSelectedDiv.addClass("active");
        $plusOrMinus.attr("src","/img/minus-5-xxl.png");
        var counter = parseInt($gameSelectedCounter.text());
        $gameSelectedCounter.text(counter+1);
    });
    return false;
}

function removeGamePlayed(idGame)
{
    swal({
            title : "Arrêter de jouez ?",
            text : "Voulez-vous vraiment enlever ce jeu de votre liste ?!",
            type : "info",
            showCancelButton : "true",
            confirmButtonColor : '#DD6B55',
            confirmButtonText : "Supprimer",
            cancelButtonText : "Retour"
        },
        function() {
            var route = Routing.generate("user_remove_game", {"game": idGame});
            $.get(route, function (data) {
                $gameSelectedCounter = $('#choose-to-play-counter-' + idGame);
                $gameSelectedLink = $("#choose-to-play-link-" + idGame);
                $gameSelectedDiv = $("#choose-to-play-div-"+ idGame);
                $plusOrMinus = $("#choose-to-play-link-"+ idGame +" img");
                $gameSelectedLink.attr("onclick", "chooseToPlay(" + idGame + ")");
                $gameSelectedDiv.removeClass("active");
                $plusOrMinus.attr("src","/img/plus-5-xxl.png");
                var counter = parseInt($gameSelectedCounter.text());
                $gameSelectedCounter.text(counter-1);
            })
        });
    return false;
}

function displayList()
{
    $list = $("#list");
    $form = $("#form");
    $form.addClass("none");
    $list.removeClass("none");
    return false;
}

function displayAskForm()
{
    $list = $("#list");
    $form = $("#form");
    $list.addClass("none");
    $form.removeClass("none");
    return false;
}
function emptyGameRequestFields()
{
    $("#request_admin_game_name").attr("value", null);
    $("#request_admin_game_kind").attr("value", null);
    $("#request_admin_game_nbMaxPlayer").attr("value", null);
}