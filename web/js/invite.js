function deleteGuest(idGuest) {
    swal({
            title: "Supprimer l'invité ?",
            text: "Si vous supprimez l'invité toutes les modifications faites à ce dernier seront perdues",
            type: "info",
            showCancelButton: "true",
            confirmButtonColor: '#DD6B55',
            confirmButtonText: "Supprimer",
            cancelButtonText: "Retour"
        },
        function () {
            var route = Routing.generate("user_guest_delete", {"guest": idGuest});
            $.get(route, function (data) {
                window.location.reload()
            });
        })
}
