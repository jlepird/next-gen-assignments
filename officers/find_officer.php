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
    <div class="col-md-6">
    <br> <br> <br>
    <h3>Instructions</h3>
    <p>You will be able to search for experienced officers via the Air Force MyVector database. While searching through the website, it is recommended you take notes and create a prioritized list of preferred officers that you find suitable for each one of your billets. Please submit this prioritized list through the <a href="../prefs/input.php">My Preference List</a> by 3 March 2017.  Follow the following tutorial on how to find officers on MyVector.



<H3>Log into <a href="https://afvec.langley.af.mil/myvector/" target="_blank">MyVector</a>.</H3>

<p> 
You will need to create an account if you do not already have one.</p><br>


<H3>Search for officers.</H3>
<p> 
You should see the following screen after logging in. Then click your name on the top right and select "QUERIES."
</p>
<ul>
    <li> <p> Don't see "Queries"? Then <a href="/help/contact.php">contact us </a> and we'll set up your privileges. </p> </li>
</ul>

<br>

<img src="queries2.JPG" alt="Click queries to see officers profiles" style="padding:2px;border:thin solid black;">

<br><br>
<p> 
Click on "ICM Code Search" on the left, and select "Air Force Talent Marketplace" under "ICM Code" to see officers available.
</p>
<br><br>

<img src="ICM_code.JPG" alt="Select Air Force Talent Marketplace under ICM Code"  style="padding:2px;border:thin solid black;"><br><br>

<br><br>
<p> 
The table will then populate with a list of available officers that you can match to your billets.  You can filter the list by clicking on the filter icon at the top of each 

column.  Click on the icon on left to see more detailed information about that specific officer.
</p>

<br><br><img src="search_table.JPG" alt="See My Experience"  style="padding:2px;border:thin solid black;">

<br><br><p>If you click on the details icon next to a particular officer, you will see the following window open up.  Here you can click on each item in the left menu to see more information related to their  career and development plan.

information: </p>

<br><img src="details.JPG" alt="See My Experience"  style="padding:2px;border:thin solid black;">

    </div>


    </div>

</div>


</body>
</html>
