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

    <div class="col-md-5">
        <h1>Getting Started</h1>

<p>As an active participant on the FY17 Summer VML cycle, you have been chosen to help shape the future Air Force assignment system. You are part of an initial pilot program to help test proposed ideas and processes that have the goal of improving the current system by making it more decentralized, transparent, and user friendly. This effort is in response to the SecDef's Force of the Future initiative to implement a web-based talent management system. Please keep in mind that is only a test and will have no bearing on your actual VML cycle, as the FY17 Summer VML has already closed. Keeping that in mind, we ask that you participate as if this new assignment system is part has already been implemented.  The more accurate and quantifiable data we can collect, the better we can make recommendations to Air Force leadership. </p>

        <h3>If you are a billet owner on the FY17 Summer VML</h3>

        <ul>
            <li>Your first step will be to provide assignment information</li>
        </ul>
            
        <h3>If you are an officer on the FY17 Summer VML</h3>    
            
        <ul>
            <li>Your first step is to input your work experience, skills, and other relevant information in MyVector. This information will be seen by billet owners as they search for officers that are most suitable for their positions.  The more information you provide, the better the billet owners will be able to make an assessment on choosing specific officers. Please provide this information by 30 January 2017.</li>
            <li>Your next step will allow you to better "shop around" for assignments that best suit your professional and personal requirements. The "Find a Billet" link above will send you to a searchable database where you can filter results. The database will also include more detailed information on each billet than you would typically see in AMS.</li>
            <li>Finally, after finding assignments that you want, you will create a prioritized list of assignments that you prefer to have.  You will then upload this 1-to-n list in the "My Preference List" link.</li>
        </ul>
        </p>
            
            <?php 


            echo $sql->queryValue("select 'test';");


            // Another debug: print the username that the user had at the beginning. 
            echo "Uname = " . $_SESSION['uname'];
            ?>
        

            <p class="text-right">
                <a href="https://www.google.com">Sample Link</a>
            </p>

    </div>


</body>
</html>
