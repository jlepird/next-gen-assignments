<?php session_start();
// If user hasn't logged in, have them do that now. 
if (!isset($_SESSION["uname"])) {
    header("Location: /login.php"); // comment this line to disable login (for debug) 
}

?>
<html>
    <head> 
    <?php include './include/head_common.php'; ?>

    </head>
<body>

<?php include './banner.php'; ?>


<div class="container">

    <br>
    <br>
    

    </div>

    <div class="col-md-3">  </div>

    <div class="col-md-6">
        <h1>Getting Started</h1>

<p>As an active participant on the FY17 Summer VML cycle, you have been chosen to help shape the future Air Force assignment system. You are part of an initial pilot program to help test proposed ideas and processes that have the goal of improving the current system by making it more decentralized, transparent, and user friendly. If you are interested in more technical details about this test program, see the <a href="/help/about.php"> About</a> section.</p>

        <h3>If you were a billet owner on the FY17 Summer VML...</h3>

        <ul>
            <li>Your first step is to provide detailed information on the assignments that you owned during the past VML cycle.  Enter the data in the <a href="/billets/manage.php">Manage Billets</a> link.  This will provide officers more information as they search for assignments.  You will be asked to provide more detailed information that you would typically provide.  Please provide this information by 3 February 2017.</li>
            <li>Your next step will involve searching through <a href="https://afvec.langley.af.mil/myvector/" target="_blank">MyVector</a> for potential officers that are most suitable for your assignment.  The database will provide you a better picture of the candidates based on the skills and experiences that they provided.
            <li>After searching through <a href="https://afvec.langley.af.mil/myvector/" target="_blank">MyVector</a>, you will create a prioritized list of preferred officers that you believe are the best match for each one of your assignments. Please submit this prioritized list through the <a href="/prefs/input.php">My Preference List</a> link above by 3 March 2017.</li>
        </ul>
            
        <h3>If you were an officer on the FY17 Summer VML...</h3>    
            
        <ul>
            <li>Your first step is to input your work experience, skills, and other relevant information in <a href="https://afvec.langley.af.mil/myvector/" target="_blank">MyVector</a>. This information will be seen by billet owners as they search for officers that are most suitable for their positions.  The more information you provide, the better the billet owners will be able to make an assessment on choosing specific officers. Please provide this information by 3 February 2017.</li>
            <li>Your next step will allow you to better "shop around" for assignments that best suit your professional and personal requirements. The <a href="/billets/find.php">Find a Billet</a> link above will send you to a searchable database where you can filter results. The database will also include more detailed information on each billet than you would typically see in AMS.</li>
            <li>Finally, after finding assignments that you want, you will create a prioritized list of assignments that you prefer to have.  You will then upload this 1-to-n list in the <a href="/prefs/input.php">My Preference List</a> section by 3 March 2017.</li>
        </ul>
        </p>


    </div>
    
    <div class = "col-md-5"></div> 


</body>
</html>
