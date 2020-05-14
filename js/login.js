$('.loginBtn').click(function(e){

    e.preventDefault();
    
    console.log('login attempted');

    // GETTING INFO FROM INPUT FIELDS
    let sEmail = $('#txtEmail').val();
    let sPassword = $('#txtPassword').val();

    formData = new FormData;

    console.log(sPassword);
    console.log(sEmail);

    // PUSHING DATA INTO THE JSON OBJECT FORMDATA

    formData.append('txtEmail', sEmail);
    formData.append('txtPassword', sPassword);
    
    console.log(formData);
    
        $.ajax({
            url : "api/api-login.php",
            method : "POST",
            data: formData,
            contentType: false,
            processData: false,
            dataType : "JSON", // Convert the data (text) from server into JSON{} in JQUERY
        }).done(function(data) {
            let login = data;
            console.log(login);
            location.href = 'profile.php';
               
        }).fail(function(data){
            console.log('failure');
            
            location.href = 'profile.php';
        })
})