<?php session_start();
// If user hasn't logged in, have them do that now. 
if (!isset($_SESSION["uname"])) {
    header("Location: ../login.php"); // comment this line to disable login (for debug) 
}
?>
<meta name="viewport" content="initial-scale=1.0, user-scalable=no"/>
<html>
    <head> 
    <?php include '../include/head_common.php'; ?>

    <script type = "text/javascript" >
    var data = <?php echo $sql->queryJSON("select posn, tkey, val from nextGen.billetData order by posn;"); ?>; 

    var lat_lon = <?php echo $sql->queryJSON("select * from nextGen.locations;"); ?>; 

    // Restructure the data from "long" form to "wide" form. 
    var completed = [];
    var outData = []; 
    
    // "Unmelt" the dataframe 
    for (var i = 0; i < data.length; ++i){
    	var scratch = {}; // the row we're going to add 
    	var id = data[i].posn;

    	// For each row, see if we've found a new billet 
    	if ($.inArray(id, completed) > -1){
    		continue; 
    	} else { // it's a new billet 
    		// Filter all of the data down to the one's we found 
    		var myData = data.filter(function(x) {
    			return x.posn == id; 
    		});

    		// Build out the row 
    		scratch.id = id; 
    		for (var j = 0; j < myData.length; ++j){
    			if (Object.keys(scratch).indexOf(myData[j].tkey) == -1){
    				scratch[myData[j].tkey] = myData[j].val;
    			} else { 
    				scratch[myData[j].tkey] += ", " + myData[j].val;
    			}
    		}

    		// Get the corresponding lat/lon data
    		var myLat_Lon = lat_lon.filter(function(x){
    			return x.location == scratch.location;
    		});
    		scratch.lat = +myLat_Lon[0].lat;
    		scratch.lon = +myLat_Lon[0].lon;

    		// Add the row 
    		outData.push(scratch);
    		// Don't do the same id again 
    		completed.push(id); 
    	}
    }
	test = data; 
    // rename and de-allocate extra 
    data = outData; outData = []; 

    // Build a giant array of the data for table display 
    for (var i = 0; i < data.length; ++i){
    	outData.push(["<a href='/billets/view.php?billet=" + data[i].id + "'>" + data[i].id + "</a>",
    		          data[i].afsc, 
    		          data[i].grade,
    		          data[i].dutyTitle,
    		          data[i].location,
    		          data[i].unit]
    		          );
    }

    // Things to run after page load 
    $(function(){

    	// Populate the table 
		$('#mainTable').DataTable({
			data: outData,
			dom: 'Bfrtip',
			buttons: ['csv', 'excel'], 
			columns: [
				{title: "Billet #"},
				{title: "AFSC"},
				{title: "Grade"},
				{title: "Duty Title"},
				{title: "Location"},
				{title: "Unit"}
				
			]
		});

		// initialize the map
		var map = L.map('map').setView([39.8282, -60], 2);

		// load a tile layer
		L.tileLayer('https://api.mapbox.com/styles/v1/jlepird/ciu4azfa300by2jo1vhynt4tl/tiles/256/{z}/{x}/{y}?access_token=pk.eyJ1IjoiamxlcGlyZCIsImEiOiJjaXU0YWpzMDcwaG1mMnRvMWQ1OWUyajNtIn0.GdK0FhpdJkfEvN3HxPwDDw',
		{
		  attribution: 'Tiles by <a href="https://www.mapbox.com/">MapBox</a>',
		  maxZoom: 17,
		  minZoom: 1
		}).addTo(map);

		// Plot the locations of our data 
		for (var i = 0; i < data.length; ++i){
			var id = data[i].id;
			 
			var marker = new L.marker([data[i].lon, data[i].lat],
				                   {bounceOnAdd: true}).addTo(map);

			marker.bindPopup("Billet: <a href='/billets/view.php?billet=" + id + "'>" + id + "</a>" + 
				              "<br>Location: " + data[i].location + 
				              "<br>Unit: " +     data[i].unit); 
				 
		}


		

    });



    </script>

    <style>
    	#map {
		  width: 100%;
		  height: 100%;
		  margin: 0;
		  padding: 0;
		}
    </style>

    </head>
<body>
<?php include '../banner.php'; ?>
<div class="col-md-1" align="right">  
</div>
<div class="col-md-10">
    <br> <br> <br> <br> 

    <div id ="map" ></div>

    <br> 

    <table id = "mainTable" class="display" cellspacing="0" width="100%">
    </table>


    </div>

</div>


</body>
</html>
