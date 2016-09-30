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
    <p>As part of this test, you are requested to submit detailed information on each of your billets.  This information will be searchable and read by potential officers on the VML to inform their assignment preference list.

<p></p><a href="https://afvec.langley.af.mil/myvector/">Proceed to MyVECTOR</a>
    </div>

</div>


</body>
</html>
