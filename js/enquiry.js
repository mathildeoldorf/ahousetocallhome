

$('#makeEnquiry').click(function(e){

    console.log('form submitted');
    
    e.preventDefault();

    formData = new FormData;

    let sEnquiry = $('#enquiryMessage').val();

    console.log(sEnquiry);

    formData.append('txtEnquiry', sEnquiry);

    console.log(formData);

        $.ajax({
            url : "api/api-enquiry.php",
            method : "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType : "JSON", // Convert the data (text) from server into JSON{} in JQUERY
        }).done(function(data) {
            console.log(data);
            $('.cta-container').append('<h1>Hi! Your enquiry has been sent!</h1>');
        }).fail(function(){
            console.log('failure');
        })
});
