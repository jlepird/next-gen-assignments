<?php session_start();
// If user hasn't logged in, have them do that now. 
if (!isset($_SESSION["uname"])) {
    header("Location: /login.php"); // comment this line to disable login (for debug) 
}
?>
<!DOCTYPE html> 
<html>
    <head> 
    <head> 
    <?php include '../include/head_common.php'; ?>
    </head>
    </head>
<body>
<?php include '../banner.php'; ?>
<div class="col-md-3">  </div>
    <div class="col-md-5">
    <br> <br><br>
        <h2>Contact Information</h2>

        <p><b> Capt Jack Lepird </b><br>
        <a href="mailto:john.r.lepird.mil@mail.mil"> john.r.lepird.mil@mail.mil</a><br>
        571-256-7711 (commercial) </p>
        

    </div>

</div>


</body>
</html>
