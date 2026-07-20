$(document).ready( function () {
    $("#accessibleButton").on('keyup', function (event) {
        if (event.keyCode === 13) {
            this.click();
        }
    });
});
function toggleAccessibility() {
    if ($("#accessibility").attr("value") === "") { $("#accessibility").attr("value", "true"); }
    else { $("#accessibility").attr("value", ""); }
    $("body").toggleClass("access");
    $("form").toggleClass("formWidth");
    $(".form-control").toggleClass("form-control-lg form-control-access");
}