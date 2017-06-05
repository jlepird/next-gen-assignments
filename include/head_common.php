<meta charset="utf-8">
<title> Air Force Talent Marketplace</title>

<!-- CSS files --> 
<!-- <link rel="stylesheet" href="/include/datatables/jquery.dataTables.min.css" type = "text/css"/> -->
<!-- <link rel="stylesheet" href="/include/datatables/buttons.dataTables.min.css" type = "text/css" /> -->

<!-- CSS Include -->
<link rel="stylesheet" href="/css/myvector.css" type="text/css" />
<link rel="stylesheet" href="/css/a9.css" type = "text/css" />
<link rel="stylesheet" href="/include/chosen/chosen.css" />
<link rel="stylesheet" href="/include/dc/web/css/dc.min.css" />
<!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.6/css/bootstrap.min.css" integrity="sha384-rwoIResjU2yc3z8GV/NPeZWAv56rSmLldC3R/AZzGRnGxQQKnKkoFVhFQhNUwEyJ" crossorigin="anonymous"> -->
<link rel="stylesheet" href="/include/bootstrap-toggle/css/bootstrap-toggle.min.css" />
<link rel="stylesheet" href="/include/datatables/colReorder.dataTables.min.css" />
<link rel="stylesheet" href="/include/sweetalert/sweetalert.css"/>
<link rel="stylesheet" href="/include/jquery/ui/jquery-ui.min.css"/>

<!-- favicon stuff --> 
<link rel="apple-touch-icon" sizes="180x180" href="/icon/apple-touch-icon.png">
<link rel="icon" type="image/png" href="/icon/favicon-32x32.png" sizes="32x32">
<link rel="icon" type="image/png" href="/icon/favicon-16x16.png" sizes="16x16">
<link rel="manifest" href="/icon/manifest.json">
<link rel="mask-icon" href="/icon/safari-pinned-tab.svg" color="#5bbad5">
<meta name="theme-color" content="#ffffff">

<!-- Javascript libraries --> 
<script type="text/javascript" src="/include/jquery/jquery.min.js"></script>
<script type="text/javascript" src="/include/datatables/jquery.dataTables.min.js" ></script>
<script type="text/javascript" src="/include/datatables/dataTables.buttons.min.js"> </script>
<script type="text/javascript" src="/include/datatables/buttons.flash.min.js"> </script>
<script type="text/javascript" src="/include/datatables/jszip.min.js"></script>
<script type="text/javascript" src="/include/datatables/buttons.html5.min.js"></script>
<script type="text/javascript" src="/include/datatables/buttons.print.min.js"></script>
<script type="text/javascript" src="/include/chosen/chosen.jquery.js"></script>
<script type="text/javascript" src="/include/dc/web/js/d3.js"></script>
<script type="text/javascript" src="/include/dc/web/js/crossfilter.js"></script>
<script type="text/javascript" src="/include/dc/web/js/colorbrewer.js"></script>
<script type="text/javascript" src="/include/dc/web/js/dc.min.js"></script>
<script type="text/javascript" src="/include/bootstrap-toggle/js/bootstrap-toggle.min.js"></script>
<script type="text/javascript" src="/include/datatables/dataTables.colReorder.min.js"></script>
<script type="text/javascript" src="/include/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript" src="/include/jquery/ui/jquery-ui.min.js"></script>
<script type="text/javascript" src="/include/lodash.min.js"></script>


<script type="text/javascript">
/* Functions used across multiple pages */

function helpNRPP(){
	swal({
	title: "Prioritization Levels",
	text: "<div style=\"text-align: left;\">Not all billets have the same likelihood of being filled. Air Staff prioritizes billets into three tiers: <ul> <li> \"Must Fill\" (100% filled) </li> <li> \"Priority\" (~85%) </li> <li> \"Entitlement\" (Remainder of Officers) </li> </ul> </div>",
	imageUrl: "../images/help.jpg",
	html: true
})}

function tutorial(){
	swal({title: "Tutorial", 
		  text: "Click on any chart to filter down.", 
						  confirmButtonText:"Continue",
						  cancelButtonText:"Exit", 
						  showCancelButton:true,
						  closeOnConfirm: false
	}, function(){
		swal({title: "Tutorial", 
		  text: "Click reset to reset a filter or \"Reset all Filters\" to start with a fresh page.", 
						  confirmButtonText:"Continue",
						  cancelButtonText:"Exit", 
						  showCancelButton:true,
						  closeOnConfirm: false
	}, function(){
		swal({title: "Tutorial", 
		  text: "The table at the bottom shows what you've filtered down to. Click the toggle under \"Favorite\" to mark that entry for later.", 
						  confirmButtonText:"Continue",
						  cancelButtonText:"Exit", 
						  showCancelButton:true,
						  closeOnConfirm: false
	}, function(){
		swal({title: "Tutorial", 
		  text: "Click on entries in the table to open a new tab with even more information.", 
						  confirmButtonText:"Exit Tutorial"
	});	
	});
	});
	});
}

</script>

<!-- PHP functions --> 
<?php 
include_once( $_SERVER['DOCUMENT_ROOT'] . "/include/funs.php"); 
if (extension_loaded('newrelic')) {
  newrelic_set_appname("AF Talent Marketplace");
}
?>