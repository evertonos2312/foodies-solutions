$(document).ready(function () {
    $('#valor').mask('000.000.000.000.000,00', {
        reverse: true
    });
    $('#data').datepicker({
        format: 'dd/mm/yyyy',
        todayBtn: 'linked',
        language: 'pt-BR',
        autoclose: true
    });

});