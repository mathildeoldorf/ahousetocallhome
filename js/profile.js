$('#updateProfileBtn').click(function(e){
    e.preventDefault();
    $('#update-profile-form').show();

    $('.close').click(function(e){
        e.preventDefault();
        $('#update-profile-form').hide();
    });

});

$('#updateBtn').click( function(e){

    e.preventDefault();

    console.log('updating');
    // Go to the parent and extract the ID and pass as a command to the API
    let sUserId = $(this).parent().attr('id');

    // GETTING INFO FROM INPUT FIELDS
    let sFirstName = $('#txtNewFirstName').val();
    let sLastName = $('#txtNewLastName').val();
    let sEmail = $('#txtNewEmail').val();
    let sPassword = $('#txtNewPassword').val();

    let fImage = document.querySelector('#fileNewImage');

    let formData = new FormData();

    // PUSHING DATA INTO THE JSON OBJECT FORMDATA

    formData.append('txtFirstName', sFirstName);
    formData.append('txtLastName', sLastName);
    formData.append('txtEmail', sEmail);
    formData.append('txtPassword', sPassword);
    formData.append('fImage', fImage.files[0]);

    $.ajax({
        url : "api/api-update-profile.php",
        method : "POST",
        data : formData, // MAIN AJAX KEYS!!
        contentType: false,
        processData: false,
        dataType : "JSON", // Convert the data (text) from server into JSON{} in JQUERY AND SEND TO THE API
    }).done(function(jData){
        console.log(jData);
        $('#update-profile-form').hide();
        $('#profile').append('<div class="success ja-items-center grid signup bg-blue"><h1>Hi '+sFirstName+'</h1><p class="uppercase">Your profile is updated!</p></div>');
        
        setTimeout(function(){
            $('.success').hide();
            setTimeout(function(){

            }, 1000);
            location.reload(true);
           
        }, 2000);

    })
});

$('#createPropertyBtn').click(function(e){
    e.preventDefault();
    $('#create-property-form').show();

    $('.close').click(function(e){
        e.preventDefault();
        $('#create-property-form').hide();
    });

});