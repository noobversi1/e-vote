$(document).ready(function() {
    //hilangkan tombol cari
    //$('#tombol-cari').hide();

    //event ketika keyword ditulis
    $('#keyword').on('keyup', function() {
        //munculkan icon loading
        $('.loader').show();

        //ajax menggunakan load
        $('#datadpt').load('ajax/ajaxdpt.php?keyword=' + $('#keyword').val());

        //ajax menggunakan s.get()
        //$.get('ajax/ajaxdpt.php?keyword=' + $('#keyword').val(), function(data) {
        //    $('#datadpt').html(data);
        //    $('.loader').hide();
        //});        
    });
});