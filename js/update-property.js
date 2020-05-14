$('#updatePropertyBtn').click( function(e){
    e.preventDefault();

    $('#update-property-form').show();

    $('.close').click(function(e){
        e.preventDefault();
        $('#update-property-form').hide();
    });

});