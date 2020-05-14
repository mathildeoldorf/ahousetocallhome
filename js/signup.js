$('.signup').submit(function(e){

    console.log('form submitted');
    
    e.preventDefault();
    let formData = new FormData(this);

    console.log(formData);

        $.ajax({
            url : "api/api-signup.php",
            method : "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType : "JSON", // Convert the data (text) from server into JSON{} in JQUERY
        }).done(function(data) {
            console.log(data);
            if(data.status != 0){
                $('.signup').remove();
                $('.signup-container').append('<div class="success ja-items-center grid signup bg-blue"><h1>Welcome</h1> <p class="uppercase">An email has been sent. Please press the link in the email to verify your account and get started!</p></div>');
            }
        })
});