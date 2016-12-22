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
    <br> <br> <br>
    <h3>Instructions</h3>
    <p>You will be able to search for experienced officers via the Air Force MyVector database. While searching through the website, it is recommended you take notes and create a prioritized list of preferred officers that you find suitable for each one of your billets. Please submit this prioritized list through the <a href="../prefs/input.php">My Preference List</a> by 3 March 2017.  Follow the following tutorial on how to find officers on MyVector.



<H3>Log into <a href="https://afvec.langley.af.mil/myvector/" target="_blank">MyVector</a>.</H3>

You will need to create an account if you do not already have one.<br>

<H3>Search for officers.</H3>

You should see the following screen after logging in. Then click your name on the top right and select "QUERIES." <br><br>

<img src="queries2.JPG" alt="Click queries to see officers profiles">

<br><br>

Click on "ICM Code Search" on the left, and select "Air Force Talent Marketplace" under "ICM Code" to see officers available.

<br><br>

<img src="ICM_code.JPG" alt="Select Air Force Talent Marketplace under ICM Code"><br><br>

<br><br>

The table will then populate with a list of available officers.  You can filter the list by clicking on the filter icon at the top of each 

column.  Click on the icon on left to see more detailed information about that specific officer.

<br><br><img src="search_table.JPG" alt="See My Experience">

<p>If you click on the details icon, you will see the following screen.  Here you can click on the menu on the left to see the following 

information:

<br><br><img src="details.JPG" alt="See My Experience">

    </div>


    </div>

</div>


</body>
</html>
