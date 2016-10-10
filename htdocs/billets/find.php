<?php session_start();
// If user hasn't logged in, have them do that now. 
if (!isset($_SESSION["uname"])) {
    header("Location: ../login.php"); // comment this line to disable login (for debug) 
}
?>
<html>
    <head> 
    <?php include '../include/head_common.php'; ?>

    <script type = "text/javascript" >
    var data = <?php echo $sql->queryJSON("select posn, tkey, val from nextGen.billetData;"); ?>; 

    // Restructure the data from "long" form to "wide" form. 

    var completed = [];
    var outData = []; 
    
    // "Unmelt" the dataframe 
    for (var i = 0; i < data.length; ++i){
    	var scratch = {}; 
    	var id = data[i].posn; 
    	if ($.inArray(id, completed) > -1){
    		continue; 
    	} else {
    		var myData = data.filter(function(x) {
    			return x.posn == id; 
    		});
    		scratch.id = id; 
    		for (var j = 0; j < myData.length; ++j){
    			scratch[myData[j].tkey] = myData[j].val;
    		}
    		outData.push(scratch);
    		completed.push(id); 
    	}
    }
    data = outData; outData = []; 

    for (var i = 0; i < data.length; ++i){
    	outData.push(["<a href='/billets/view.php?billet=" + data[i].id + "'>" + data[i].id + "</a>",
    		          data[i].afsc, 
    		          data[i].grade,
    		          data[i].location,
    		          data[i].unit]
    		          );
    }

    $(function(){
		$('#mainTable').DataTable({
			data: outData,
			dom: 'Bfrtip',
			buttons: ['csv', 'excel'], 
			columns: [
				{title: "Billet #"},
				{title: "AFSC"},
				{title: "Grade"},
				{title: "Location"},
				{title: "Unit"}
			]
		});

    });

    </script>


    </head>
<body>
<?php include '../banner.php'; ?>
<div class="col-md-3">  </div>
    <div class="col-md-5">
    <br> <br> <br> <br> 
    <table id = "mainTable" class="display" cellspacing="0" width="100%">
    </table>


    </div>

</div>


</body>
</html>
