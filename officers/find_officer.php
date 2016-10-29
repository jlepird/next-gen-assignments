<?php session_start();
// If user hasn't logged in, have them do that now. 
if (!isset($_SESSION["uname"])) {
    header("Location: ../login.php"); // comment this line to disable login (for debug) 
}
?>
<html>
    <head> 
    <?php include '../include/head_common.php'; ?>
    </head>
<body>
<?php include '../banner.php'; ?>
<div class="col-md-3">  </div>
    <div class="col-md-5">
    <br> <br> <br>
    <p>You will be able to search for experienced officers via the Air Force MyVECTOR database. While searching through the website, it is recommended you take notes and create a prioritized list of preferred officers that you find suitable for each one of your billets. Please submit this prioritized list through the "My Preference List" link above by 28 February 2017.

<p><a href="https://afvec.langley.af.mil/myvector/" target="_blank">Proceed to MyVECTOR</a>
    </div>


    </div>

</div>


</body>
</html>
