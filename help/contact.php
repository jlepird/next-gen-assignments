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
        <h5> Lt Col Julie Wiemer</h5>
        <p> <a href="mailto:julie.a.wiemer.mil@mail.mil">julie.a.wiemer.mil@mail.mil</a> </p>
        <p> 703-614-2317 (commercial) </p>

        <h4> A9 </h4>
        <h5> 1Lt Jack Lepird </h5>
        <p> <a href="mailto:john.r.lepird.mil@mail.mil"> john.r.lepird.mil@mail.mil</a></p>
        <p> 571-256-7711 (commercial) </p>
        
        <h5> Ms. Courtney Knoth</h5>
        <p> <a href="mailto:courtney.l.knoth.civ@mail.mil">courtney.l.knoth.civ@mail.mil </a></p>
        <p> 571-256-2041 (commercial) </p>
        
        <h5> Mr. Jay Sanchez</h5>
        <p> <a href="mailto:jay.p.sanchez.civ@mail.mil" > jay.p.sanchez.civ@mail.mil</a></p>
        <p> 571-256-7734 (commercial) </p>

    </div>

</div>


</body>
</html>
