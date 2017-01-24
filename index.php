<?php session_start();
// If user hasn't logged in, have them do that now. 
if (!isset($_SESSION["uname"])) {
    header("Location: /login.php"); // comment this line to disable login (for debug) 
}

?>
<!DOCTYPE html> 
<html>
    <head> 
    <?php include './include/head_common.php'; ?>
    </head>
<body>

<?php include './banner.php'; ?>


<div class="container">

    <br>
    <br>
    <br>
    <br>

    </div>

    <div class="col-md-2">  </div>

    <div class="col-md-8">

<h1 style="text-align: center;"> <strong> Welcome to the Air Force Talent Marketplace </strong> </h1>
<p> Congratulations! As an active participant on the FY17 Summer VML cycle, you have been chosen to help shape the future Air Force assignment system. You are part of an initial pilot program to measure the effectiveness of a more decentralized, transparent, and user-friendly assignment process. If you are interested in more technical details about this test program, see the <a target = "_blank" href="/help/about.php"> About</a> section.</p>


<h2> What we need you to do </h2>
<br> 
        <div class = "col-md-6">
        <div class = "colorstrip-1"></div>
        <h3><strong> Officers on the VML </strong></h3>    

        <ul>
            <li> <p> <strong> Advertise yourself to Billet Owners.</strong> You're more than what's on your SURF. Your first step is to input your work experience, skills, and other relevant information in <a href="https://afvec.langley.af.mil/myvector/" target="_blank">MyVector</a>. We've provided a guide for you <a href="/myvectorprofile/myvectorprofile.php"> here</a>. This information will be seen by billet owners as they search for officers that are most suitable for their positions. </p>

            <ul> <li> <p> Tip: The more information you provide, the better the billet owners will be able to make an assessment on choosing specific officers. </p> </li> </ul>
               <p> Please provide this information by 31 January 2017 so that gaining commanders have enough time to search.</li> </p>
            <li> <p> <strong> Find jobs you're interested in.</strong> The <a href="/billets/find.php">Find a Billet</a> tool lets you quickly filter down to billets you'd like to fill. Thanks to the participation by billet owners, you'll see a lot more data then you would in AMS. <ul> <li> <p> Feel free to reach out to billet POCs who have made their contact information public! </li> </ul></li> </p>
            <li> <p> <strong> Tell us where you'd like to go.</strong> Once you've found assignments that you want, fill out your <a href="/prefs/input.php">dream sheet </a> by 3 March 2017.</li> </p>
        </ul>
        </div>
        <div class="col-md-6">
        <div class = "colorstrip-2"></div>
        <h3> <strong> Billet Owners </strong></h3>

        <ul>
            <li> <p> <strong> Advertise your Billet to Airmen. </strong> There's a lot of cool work in the Air Force, so what makes your billet unique? We've uploaded the billet requisitions you submitted to AFPC for a starting point, but you can now expand on your submission using the <a href="/billets/manage.php">Manage Billets</a> tool.  Information you provide here will be visible to Airman they search for assignments.  <br> Please provide this information by 31 January 2017 so that Airman have enough time to look through billets.</li> </p>
            <li> <p> <strong> Search for qualified candidates. </strong> We've given each of you search privileges on <a href="https://afvec.langley.af.mil/myvector/" target="_blank">MyVector</a>. See our detailed instructions under <a href="/officers/find_officer.php">Find an Officer</a>. MyVector will provide you a better picture of the candidates based on their reported skills and experiences&mdash;you'll see a lot more than what's on a SURF. And this is just a starting point: you're always allowed reach out and make personal contact with candidates! </p>
            <li> <p> <strong> Tell us who you want in your unit.</strong> Once you've got an idea of who you'd like, give us your 1-<em>n</em> list with the <a href="/prefs/input.php">My Preference List</a> tool. Our deadline for this step is 3 March 2017.</li> </p>
        </ul>
        </div>


    </div>
    
    <div class = "col-md-5"></div> 


</body>
</html>
