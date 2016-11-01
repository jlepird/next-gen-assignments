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

        <h4> A1 </h4>
        <p><b> Lt Col Julie Wiemer </b><br>
        <a href="mailto:julie.a.wiemer.mil@mail.mil">julie.a.wiemer.mil@mail.mil</a> <br>
        703-614-2317 (commercial) </p>

        <h4> A9 </h4>
        <p><b> 1Lt Jack Lepird </b><br>
        <a href="mailto:john.r.lepird.mil@mail.mil"> john.r.lepird.mil@mail.mil</a><br>
        571-256-7711 (commercial) </p>
        
        <p><b> Ms. Courtney Knoth </b><br>
        <a href="mailto:courtney.l.knoth.civ@mail.mil">courtney.l.knoth.civ@mail.mil </a><br>
        571-256-2041 (commercial) </p>
        
        <p><b> Mr. Jay Sanchez </b><br>
        <a href="mailto:jay.p.sanchez.civ@mail.mil" > jay.p.sanchez.civ@mail.mil</a><br>
        571-256-7734 (commercial) </p>

    </div>

</div>


</body>
</html>
