<?php session_start();
// If user hasn't logged in, have them do that now. 
if (!isset($_SESSION["uname"])) {
    header("Location: /login.php"); // comment this line to disable login (for debug) 
}
?>
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
    <br> <br>
        <h2>Contact Information</h2>

        <h3> 1Lt Jack Lepird </h3>
        <p> john.r.lepird.mil@mail.mil
        <p> 571-256-7711 (commercial) </p>
        
        <h3> Ms. Courtney Knoth</h3>
        <p> courtney.l.knoth.civ@mail.mil</p>
        <p> 571-256-2041 (commercial) </p>

    </div>

</div>


</body>
</html>
