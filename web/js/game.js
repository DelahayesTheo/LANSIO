function chooseToPlay(idGame, path)
{
    var route = '';
    if (path == 'USER') {
        route = Routing.generate("user_play_game", {"game": idGame});
    } else if (path == 'GUEST') {
        route = Routing.generate("user_guest_add_game", {"game": idGame});
    }
    $.get(route, function(data){
        $gameSelectedCounter = $('#choose-to-play-counter-' + idGame);
        $gameSelectedLink = $("#choose-to-play-link-"+ idGame);
        $gameSelectedDiv = $("#choose-to-play-div-"+ idGame);
        $plusOrMinus = $("#choose-to-play-link-"+ idGame +" img");
        if (path == 'USER') {
            $gameSelectedLink.attr("onclick", "removeGamePlayed(" + idGame + ", 'USER'); return false");

        } else if (path == 'GUEST') {
            $gameSelectedLink.attr("onclick", "removeGamePlayed(" + idGame + ", 'GUEST'); return false");
        }
        $gameSelectedDiv.addClass("active");
        $plusOrMinus.attr("src","/img/minus-5-xxl.png");
        var counter = parseInt($gameSelectedCounter.text());
        $gameSelectedCounter.text(counter+1);
    });
    return false;
}

function removeGamePlayed(idGame, path)
{
    swal({
            title : "Arrêter de jouez ?",
            text: "Voulez-vous vraiment enlever ce jeu de la liste ?!",
            type : "info",
            showCancelButton : "true",
            confirmButtonColor : '#DD6B55',
            confirmButtonText : "Supprimer",
            cancelButtonText : "Retour"
        },
        function () {
            var route = '';
            if (path == 'USER') {
                route = Routing.generate("user_remove_game", {"game": idGame});
            } else if (path == 'GUEST') {
                route = Routing.generate("user_guest_remove_game", {"game": idGame});
            }
            $.get(route, function (data) {
                $gameSelectedCounter = $('#choose-to-play-counter-' + idGame);
                $gameSelectedLink = $("#choose-to-play-link-" + idGame);
                $gameSelectedDiv = $("#choose-to-play-div-"+ idGame);
                $plusOrMinus = $("#choose-to-play-link-"+ idGame +" img");
                if (path == 'USER') {
                    $gameSelectedLink.attr("onclick", "chooseToPlay(" + idGame + ", 'USER'); return false");

                } else if (path == 'GUEST') {
                    $gameSelectedLink.attr("onclick", "chooseToPlay(" + idGame + ", 'GUEST'); return false");
                }
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