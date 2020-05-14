$('.likeBtnIcon.inactive').click(function(e){

e.preventDefault();
console.log('clicked like');

$(this).removeClass('inactive');
$(this).addClass('active');


formData = new FormData;

    console.log(formData);

        $.ajax({
            url : "api/api-like-property.php",
            method : "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType : "JSON", // Convert the data (text) from server into JSON{} in JQUERY
        }).done(function(data) {
            let propertyId = data;
            console.log(data);
        }).fail(function(){
            console.log('failure');
        })

})

$('.likeBtnIcon.active').click(function(e){

    e.preventDefault();
    console.log('clicked unlike');
    $(this).removeClass('active');
    $(this).addClass('inactive');

    formData = new FormData;

    console.log(formData);

        $.ajax({
            url : "api/api-unlike-property.php",
            method : "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType : "JSON", // Convert the data (text) from server into JSON{} in JQUERY
        }).done(function(data) {
            let propertyId = data;
            console.log(data);
        }).fail(function(){
            console.log('failure');
        })

})