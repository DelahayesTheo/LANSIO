function closeRequest(idSupportRequest) {
    var route = Routing.generate("admin_close_request", {"support": idSupportRequest});
    $.get(route, function (data) {
        $('#request-' + idSupportRequest).remove();
    });
    return false;
}
