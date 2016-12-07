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
<body>
<?php include '../banner.php'; ?>


<div class="col-md-3">  </div>
    <div class="col-md-5">
    <br> <br> <br><br><br><br>
    <h3>Instructions</h3>
    <p>You will be able to search for experienced officers via the Air Force MyVector database. While searching through the website, it is recommended you take notes and create a prioritized list of preferred officers that you find suitable for each one of your billets. Please submit this prioritized list through the <a href="../prefs/input.php">My Preference List</a> by 3 March 2017.  Follow the following tutorial on how to find officers on MyVector.



<H3>Log into <a href="https://afvec.langley.af.mil/myvector/" target="_blank">MyVector</a>.</H3>

You will need to create an account if you do not already have one.<br>


<h4><i>Tutorial on how to search for officers on MyVector is forthcoming once the capability is implemented in MyVector.</i</h4>
    </div>


    </div>

</div>


</body>
</html>
