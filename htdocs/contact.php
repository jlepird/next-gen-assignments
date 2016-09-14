<?php session_start();
// If user hasn't logged in, have them do that now. 
if (!isset($_SESSION["uname"])) {
    header("Location: /login.php"); // comment this line to disable login (for debug) 
}
?>
<html>
    <head> 
    <head> 
    <?php include './head_common.php'; ?>
    </head>
    </head>
<body>
<?php include './banner.php'; ?>
<div class="col-md-3">  </div>
    <div class="col-md-5">
    <br> <br>
        <h2>Contact Information</h2>

        <h3> 1Lt Jack Lepird </h3>
        <p> not-my-real-email@email.net
        <p> 911 </p>

    </div>

</div>


</body>
</html>
