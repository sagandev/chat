function showAlert(type, text) {
    $("body").prepend(`<div class='alert alert-${type}' role='alert'>${text}</div>`)
    $(".alert").first().hide().fadeIn(200).delay(2000).fadeOut(1000, function () {
        $(this).remove();
    });
}
