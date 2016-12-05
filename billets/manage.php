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
    <?php 
    if ($_SESSION['isOwner']){
        if (isset($_GET["billet"])){
            $billet = $_GET["billet"]; 
        } else { 
            $billet = $sql->queryValue("select posn from billetOwners where username = '" . $_SESSION["uname"] . "' limit 1;");
            $billet = str_replace("\"", "", $billet);
            header("Location: /billets/manage.php?billet=" . $billet); 
        }

        $data = $sql->queryJSON("select billetOwners.posn, tkey, val from billetData " . 
                        "left outer join billetOwners on billetData.posn = billetOwners.posn" . 
                        " where username = '" . $_SESSION["uname"] . "' and billetData.posn = '" . $billet . "';");
        $descs = $sql->queryJSON("select billetOwners.posn, txt from billetDescs " . 
                        "left outer join billetOwners on billetDescs.posn = billetOwners.posn" . 
                        " where username = '" . $_SESSION["uname"] . "' and billetDescs.posn = '" . $billet . "';");
    }
    ?>
    
    <script type = "text/javascript">
        $(function() {
            $(".col-md-5").fadeIn(1000);
        });
        <?php
            if (isset($_SESSION["uploaded"])) {
                echo '$(function(){swal("Success!", "Billet data successfully saved.", "success");});';
                unset($_SESSION["uploaded"]);
            }
        ?>
    </script>

    </head>
<body>
<?php include '../banner.php'; ?>

<div class="col-md-2" >  </div>

    <div class="col-md-5" hidden>

    <br> <br> <br>
    <p>As part of this test, you are requested to submit detailed information on each of your billets.  This information will be searchable and read by potential officers on the VML to inform their assignment preference list.


    <br> <br> <br>
    <?php 
    if (!$_SESSION['isOwner']) {
    	echo "<p> You currently have no billets assigned to you. If you think this is in error, please <a href = \"/help/contact.php\"> contact us. </a> </p>";
    } else {

    	$_SESSION["included"] = true;
    	include "./yesbillets.php";
    }

    ?>
    </div>

</div>

<div id = "footer"> For Official Use Only (FOUO) </div>
</body>
</html>
