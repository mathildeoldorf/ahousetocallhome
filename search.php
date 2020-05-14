<?php

session_start();

$sTitle = 'Home';

require_once(__DIR__.'/functions.php'); 
require_once(__DIR__.'/components/header.php'); 

?>



    <form id="formSearch" class="absolute" action="">
    <h1>Search properties by zipcode</h1>
        <input id="txtSearch" type="text" name="search" placeholder="search properties" maxlength="4" minlength="4">
    </form>

    <section id="txtSearchResults" class="grid full-view-width full-view-height three-column-grid">
    </section>

    <script>

        let txtSearch = document.querySelector('#txtSearch');
        let txtSearchResults = document.getElementById('txtSearchResults');

        txtSearch.addEventListener('input', function(){

            

            if(($('#txtSearch').val().length == 0)){
                $('#txtSearch').removeClass('error');
                $('#txtSearchResults').css("visibility", "hidden");
                return
            }
            
            setTimeout(doAjax, 1000);

            function doAjax(){
            $.ajax({
            url : "api/api-search-test.php",
            data : $('#formSearch').serialize(),
            dataType : "JSON"

            }).done(function(aProperties){
            console.log(aProperties);
            $('#txtSearchResults').empty();
            
            // JAVASCRIPT FOR LOOP
            // for (let i = 0; i < aMatches.length; i++) { 
            // $('#txtSearchResults').append('<div>'+ aMatches[i] + '</div>');            
            // }

            // JQUERY EACH LOOP
            $(aProperties).each( function( index, aProperty){
                let sResult = `<a href="property.php?id=${aProperty[0]}"><div id='${aProperty[0]}' class='property bg-cover' style="background-image: url('images/properties/${aProperty[1]}')"></div></a>`;
                $('#txtSearchResults').append(sResult);

            });

            }).fail(function(){
            console.log('Nothing inside');
            });
            }
           

            if(txtSearch.value.length == 0){
                // console.log('nothing inside');
                txtSearchResults.style.visibility = 'hidden';
            }
            txtSearchResults.style.visibility = 'visible';

            
        })
    </script>

    

<?php

require_once(__DIR__.'/components/footer.php'); 