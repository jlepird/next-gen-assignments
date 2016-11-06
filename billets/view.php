<?php session_start();
// If user hasn't logged in, have them do that now. 
if (!isset($_SESSION["uname"])) {
    header("Location: ../login.php"); // comment this line to disable login (for debug) 
}
?>
<!DOCTYPE html> 
<html>
    <head> 
    <?php include '../include/head_common.php'; ?>
    </head>
    <script type = "text/javascript"> 
    var data = <?php
    	$billet = $_GET['billet']; 
    	$data = $sql->queryJSON("select posn, tkey, val from billetData where posn = '" . $billet . "';");
        echo $data; 
    ?>; 

    var favorited = <?php echo "'" . $sql->queryValue("select count(*) from favorites where username = '" . $_SESSION["uname"] . "' and posn = '" . $billet . "';") . "'"; ?>;

    var toggleOptions = {
        on: "<span style='font-size: 100%;'> &starf; </span>",
        off: ""
    };

    function toggleFavorite(x){
        $.ajax({
            url:"/billets/changeFavorite.php",
            type: 'post',
            data: {"billet" : <?php echo "'" . $billet . "'"; ?>,
                   "case" : x.checked}
        });
    }

    // Run on page load 
    $(function(){
        /* Update the values that we have */ 
        var toUpdate = document.getElementsByClassName("autopop");
        for (var i = 0; i < toUpdate.length; ++i){
            var row = data.filter(function(x){
                return x.tkey == toUpdate[i].name.replace("[]", ""); 
            }); 
            if (row.length == 1) {
                toUpdate[i].value = row[0].val;

            } else { // It's a drop-down with multiple selects 
                // For each value that we found... 
                for (var j = 0; j < row.length; ++j ){

                // For each option, figure out if we have it selected or not
                    for (var k = 0; k < toUpdate[i].children.length; ++k){
                        if (toUpdate[i].children[k].value == row[j].val){
                            toUpdate[i].children[k].selected = true; 
                            break;
                        }
                    }
                }
            } 
            toUpdate[i].disabled = "disabled"; 
        }

		document.getElementById("desc").value = '<?php echo $sql->queryValue("select txt from billetDescs where posn = '" . $billet . "';") ?>'; 
		document.getElementById("desc").disabled = "disabled";

        if (favorited != "0"){
            $("#fav").attr("checked", "checked");
        }

        $("#fav").bootstrapToggle({
            on: "<span style='font-size: 100%;'> &starf; </span>",
            off: ""
        });



    });



    </script>
<body>
<?php include '../banner.php'; ?>

<div class="col-md-3">  </div>

<div class = "col-md-5" > 

<br> <br> <br> 
<div class = "row" style = "margin-left: 10px;">
<h4> Billet #<?php echo $billet ?> </h4> 

Favorite this billet: 
<input type = 'checkbox' onchange='toggleFavorite(this)' id = "fav">


</div>


<fieldset>
<?php include "table.php"; ?>

</form>

</div>
</div>

</body>
</html>
