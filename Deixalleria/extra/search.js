function displaySelect(id) {
    document.getElementById(id).classList.toggle("show");
    idSelect = "#"+id;
}

var idSelect;

window.onclick = function(event) {
    if (!event.target.matches('.dropbtn') && !event.target.matches('.cerca')) {
        if (event.target.matches('.anchorOption')) {
            $(event.target).parent().val($(event.target).attr('value'));
            $(idSelect).prev().html($(event.target).html() + '<i class="dropbtn fas fa-caret-down"></i>');
        }
        if (event.target.matches('.chooseUser')) { canviarInfo(); }
        else if (event.target.matches('.consultUser')) { mostrarMunicipi(); }
        var dropdowns = document.getElementsByClassName("dropdown-content");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) { openDropdown.classList.remove('show'); }
        }
    }
};

function mostrarMunicipi() {
    $.ajax({
        type: "POST",
        url: "procesa.php",
        data: "municipi_usuari=" + $("#nifList").val(),        // Identifica l'usuari mitjançant el valor del seu DNI
        success: function (opciones) {
            $("#municipis").val(opciones);     // Especifica el municipi de l'usuari
            $("#municipis").next().val(opciones);     // Especifica el municipi de l'usuari
            $("#municipis").prev().html(opciones + '<i class="dropbtn fas fa-caret-down"></i>');
        }
    });
}

function omplirEspais() {       // Omple d'informació els inputs de l'inici en escollir un usuari
    $.ajax({
        type: "POST",
        url: "procesa.php",
        data: "categoria_usuari=" + $("#nifList").val(),       // Identifica l'usuari mitjançant el valor del seu DNI
        success: function (opciones) {
            $("#categories").val(opciones);        // Especifica la categoria de l'usuari
            $("#categories").next().val(opciones);     // Especifica el municipi de l'usuari
            $("#categories").prev().html(opciones + '<i class="dropbtn fas fa-caret-down"></i>');
        }
    });
    $.ajax({
        type: "POST",
        url: "procesa.php",
        data: "nom_usuari=" + $("#nifList").val(),     // Identifica l'usuari mitjançant el valor del seu DNI
        success: function (opciones) { $("#nomUsuari").val(opciones); }     // Especifica el nom de l'usuari
    });
    $.ajax({
        type: "POST",
        url: "procesa.php",
        data: "cognom1_usuari=" + $("#nifList").val(),     // Identifica l'usuari mitjançant el valor del seu DNI
        success: function (opciones) { $("#cognom1Usuari").val(opciones); }     // Especifica el primer cognom de l'usuari
    });
    $.ajax({
        type: "POST",
        url: "procesa.php",
        data: "cognom2_usuari=" + $("#nifList").val(),     // Identifica l'usuari mitjançant el valor del seu DNI
        success: function (opciones) { $("#cognom2Usuari").val(opciones); }     // Especifica el segon cognom de l'usuari
    });
    $.ajax({
        type: "POST",
        url: "procesa.php",
        data: "nif_usuari=" + $("#nifList").val(),     // Identifica l'usuari mitjançant el valor del seu DNI
        success: function (opciones) { $("#nifUsuari").val(opciones); }     // Especifica el DNI de l'usuari
    });
    mostrarMunicipi();
    $.ajax({
        type: "POST",
        url: "procesa.php",
        data: "carrer_usuari=" + $("#nifList").val(),      // Identifica l'usuari mitjançant el valor del seu DNI
        success: function (opciones) { $("#carrerUsuari").val(opciones); }      // Especifica el carrer de l'usuari
    });
    $.ajax({
        type: "POST",
        url: "procesa.php",
        data: "pis_usuari=" + $("#nifList").val(),        // Identifica l'usuari mitjançant el valor del seu DNI
        success: function (opciones) { $("#pisos").val(opciones); }     // Especifica el pis de l'usuari
    });
    $.ajax({
        type: "POST",
        url: "procesa.php",
        data: "num_usuari=" + $("#nifList").val(),     // Identifica l'usuari mitjançant el valor del seu DNI
        success: function (opciones) { $("#numUsuari").val(opciones); }     // Especifica el nº de carrer de l'usuari
    });
}

function canviarInfo() {
    $("#btn-5").attr('disabled', 'disabled');
    $("#btn-4").attr('disabled', 'disabled');
    omplirEspais();         // Omple d'informció els inputs de l'inici segons l'usuari escollit
    if ($("#categories").val() !== 'PRIVATS') {
        $("#cognom1Usuari").removeAttr('required');
        $("#cognom2Usuari").removeAttr('required');
    }
    setTimeout( function () {   // Activa/desactiva el botó 'Següent' segons si falta informació important de l'usuari
        if (($("#categories").val() === 'PRIVATS') && $("#nomUsuari").val() && $("#cognom1Usuari").val() && $("#cognom2Usuari").val() && $("#municipis").val() && $("#nifUsuari").val() && $("#carrerUsuari").val()) {
            $("#btn-5").removeAttr('disabled');
        }
        else if (($("#categories").val() !== 'PRIVATS') && $("#nomUsuari").val() && $("#municipis").val() && $("#nifUsuari").val() && $("#carrerUsuari").val()) {
            $("#btn-5").removeAttr('disabled');
        }
        else { $("#btn-5").attr('disabled', 'disabled'); }
    }, 750);        // Temps que tarda en activar-se el botó
}

$(document).ready( function () {
    $(".dropbtn").click(function(event) { displaySelect(this.nextElementSibling.id); });
    $(".cerca").keyup(function(event) {
        var selected = false;
        var input, filter, select, option;
        input = document.getElementById(this.id);
        filter = input.value.toUpperCase();
        if (this.classList.contains("cercaAccess")) {
            select = document.getElementById($(this).next().attr("id"));
            option = select.getElementsByTagName('option');
        }
        else {
            select = document.getElementById(this.parentNode.id);
            option = select.getElementsByTagName('a');
        }
        for (var i = 0; i < option.length; i++) {
            if (option[i].innerHTML.toUpperCase().indexOf(filter) > -1) {
                option[i].style.display = "";
                option[i].disabled = false;
                if (selected === false) {
                    option[i].selected = true;
                    selected = true;
                }
            }
            else {
                option[i].style.display = "none";
                option[i].disabled = true;
                option[i].selected = false;
            }
        }
    });
    $("div.dropbtn").each(function() {
        this.addEventListener("keyup", function(event) {
           if (event.keyCode === 13) { this.click(); }
        });
    });
    $("a.anchorOption").each(function() {
        this.addEventListener("keyup", function(event) {
           if (event.keyCode === 13) { this.click(); }
        });
    });
});