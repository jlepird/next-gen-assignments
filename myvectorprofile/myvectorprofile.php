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
    <p>As an officer on the VML, you are required to update your profile on MyVector. There you will be able to update your duty experience, skills, training, and education.  Having a detailed profile allows billet owners to have a better understanding of you as an officer as they search for the right person for their billet.  Follow the following tutorial on how to update your profile in MyVector.

    


<H3>Log into <a href="https://afvec.langley.af.mil/myvector/" target="_blank">MyVector</a>.</H3>

You will need to create an account if you do not already have one.<br>

<H3>Update your personal profile.</H3>

You should see the following screen after logging in.  <br><br>

<img src="splash.JPG" alt="Go to personal profile">

<br><br>
Update all the applicable fields in your personal profile. As an officer, your screen may look slightly different than what is shown.<br><br>

<img src="profile.JPG" alt="Update your personal profile">

<br><br>Click save when complete.

<H3>Update your assignment history and relevant work experience.</H3>


<img src="see my experience.JPG" alt="See My Experience"><br><br>

<p>Your duty distory should be automatically filled in.  The quick view table will display the following for each duty entry: Start date of the duty, Duty Title, AFSC, Component, Unit, Organization, Type, Location, MAJCOM, Rank, Career Field Experience Code (created by the CFM), Experience Description, and association request action.

<p>All duty entries are pulled from MilPDS if the information is incorrect, you must contact the local Military Personnel Section (MPS) to ensure the information is updated correctly within those systems. Note: The Rank associated with a duty is calculated from the Date of Rank held when you started the duty.

<p>You can click “Change Component” if your component is incorrect (options include the following: AF Component, Reserve, Air National Guard, and Civilian). Note: MyVECTOR is Total Force, therefore if your component is incorrect, it is important to correct. The Active Duty history of many reservists will initially display as Reserves due to the initial data source.


<br><br><img src="duty.JPG" alt="Review your Duty History"> <br> <br>

<p> The "Other-Self Reported Jobs" section allows you to add experience garnered throughout your career that cannot be identified any place else (i.e. jobs with other services, deployment experience, previous military or civilian experience). In addition, you will be able to associate a code with this duty using the dropdowns so it will appear on your experience summaries.  You can also edit existing entries in this section.


<br><br><img src="edit self report.JPG" alt="See My Experience">

<p>You will see the following screen when you create a new self-reported job.  Be sure to fill out all relevant information.

<br><br><img src="add self report.JPG" alt="See My Experience">

<p>Click "Save" when finished.

<H3>Update your education and training.</H3>

<p>This section allows you to view a summary of your education and training information. You will have the ability to view the following tables with associated information:
<UL>
<LI><b>Education:</b> Identifies the individuals’ degree information to include the Code, description, level (Ex. MA, BA, CCAF, etc.), school, and award date.
<LI><b>Professional Military Education (PME):</b> Identifies the individuals’ PME information to include the code, description, level (Ex. IDE, PDE, Course 14, etc.), residence status, and award date.
<LI><b>Acquisition Certification:</b> Identifies acquisition certifications held by the individual and includes the code, description, level of certification and the award date.
<LI><b>Training:</b> Identifies all training related courses updated in MilPDS/DCPDS for the individual and includes the code, description, level, school, and award date. Note: some sections on this table may be left blank if not applicable.
</UL>

You are also able to add additional education experience that is not automatically pulled from DCPDS, as shown below.

<br><br><img src="education.JPG" alt="See My Experience">


    </div>


    </div>

</div>


</body>
</html>