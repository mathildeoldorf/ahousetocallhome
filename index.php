<?php

session_start();

if(!$_SESSION){
    
}

$sTitle = 'Home';

require_once(__DIR__.'/functions.php'); 
require_once(__DIR__.'/components/header.php'); 

?>



    <form id="formSearch" class="absolute" action="">
    <h1>Let's find your new home</h1>
        <input id="txtSearch" type="text" name="search" placeholder="search properties by zipcode" maxlength="4" minlength="4">
    </form>
    <div class="search-background welcome bg-blue full-view-width">
  <h1 class="color-white text-center">Welcome</h1>
  </div>
    <section id="txtSearchResults" class="grid full-view-width three-column-grid">
    </section>
    

    <script>

        let txtSearch = document.querySelector('#txtSearch');
        let txtSearchResults = document.getElementById('txtSearchResults');

        txtSearch.addEventListener('input', function(){

            if(($('#txtSearch').val().length == 0)){
                $('#txtSearch').removeClass('error');
                $('#txtSearchResults').css("visibility", "hidden");
                $('#txtSearchResults').css("height", "2vw");
                return
            }
            
            doAjax();

            function doAjax(){
            $.ajax({
            url : "api/api-search.php",
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
                let sResult = `<div class="property-container"><a href="property.php?id=${aProperty[0]}"><div id='${aProperty[0]}' class='property bg-cover' style="background-image: url('images/properties/${aProperty[1]}')"></div></a></div>`;
                $('#txtSearchResults').append(sResult);
                
            });

            }).fail(function(){
            console.log('Nothing inside');
            });
            }

            if(txtSearch.value.length == 0){
                txtSearchResults.style.visibility = 'hidden';
                txtSearchResults.style.height = '2vw';
            }
            txtSearchResults.style.visibility = 'visible';
            txtSearchResults.style.height = '60vw';

            
        });
    </script>

<h1 class="text-center">Discover areas</h1>
  <section id="map_properties">

    <div id='map'></div>

    <div id="properties">

     <?php
      
      $jAgents = $jData->agents; 

        $aProperties = [];

      foreach ($jAgents as $sAgentId => $jAgent) {
        $jAgentProperties = $jAgent->properties;

      foreach($jAgentProperties as $sAgentPropertyId => $jAgentProperty){

        if($jAgentProperty->verification != 0){
        ?>
        <div class="property-container relative">
        <a class="" href="property.php?id=<?= $sAgentPropertyId; ?>">
        <div class="property-overlay absolute">
            <h3 class="address uppercase"><?= $jAgentProperty->address->street.' '.$jAgentProperty->address->streetnumber;?></h3> 
            <h3 class="address uppercase"><?= $jAgentProperty->address->postalcode.' '.$jAgentProperty->address->city; ?></h3>
            <h3 class="address uppercase"><?=$jAgentProperty->price ?> kr</h3>
        </div>
          <div id='Right<?=$sAgentPropertyId?>' class='property bg-cover' style="background-image: url('images/properties/<?= $jAgentProperty->images[0]?>')">
          </div>
          </a>
          </div>
      <?php

    array_push($aProperties, $jAgentProperty);
        }
      }
    }
?>
    </div>
  </section>

  <script>
    
      const sjAgentProperties = '<?php echo json_encode($aProperties); ?>';
      let ajAgentProperties = JSON.parse(sjAgentProperties) // convert text into an object
      console.log(ajAgentProperties);

      mapboxgl.accessToken = 'pk.eyJ1Ijoic2FudGlhZ29kb25vc28iLCJhIjoiY2swYzVoYmNmMHlkZzNibzR4NTNxamU3cSJ9.QNJx-cfl48aSOx8purGNeA';
      var map = new mapboxgl.Map({
      container: 'map',
      center: [12.555050, 55.704001], // starting position
      zoom: 12, // starting zoom
      style: 'mapbox://styles/santiagodonoso/ck0c6jrhh02va1cnp07nfsv64'
      
      });
      map.addControl(new mapboxgl.NavigationControl());

    // JSON works with for in loops
    // Arrays work with forEach and also with for of
    for( let jAgentProperty of ajAgentProperties ){ // json object with json objects in it

    console.log(jAgentProperty);
    
      var el = document.createElement('a');
      el.href = '#Right'+jAgentProperty.id;
      el.className = 'marker';
      el.className = 'bg-contain';
      el.style.backgroundImage = 'url(images/marker.svg)';
      el.style.width = "50px";
      el.style.height = "50px";
      el.id = jAgentProperty.id;
      el.addEventListener('click', function() {
        removeActiveClassFromProperty();
        document.getElementById(this.id).classList.add('active'); // left
        document.getElementById('Right'+this.id).classList.add('active'); // right
      });
    // add marker to map
    new mapboxgl.Marker(el).setLngLat(jAgentProperty.address.coordinates).addTo(map);      
  } // end loop

    function removeActiveClassFromProperty(){
      let properties = document.querySelectorAll('.active')
      properties.forEach( function( oPropertyDiv ) {
        oPropertyDiv.classList.remove('active')
      } )
    }  


</script>

<?php
require_once(__DIR__.'/components/footer.php'); 