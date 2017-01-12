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
    <p>As an officer on the VML, you are required to update your profile on MyVector by 3 Feb 17. There you will be able to update your duty experience, skills, training, and education.  Having a detailed profile allows billet owners to have a better understanding of you as an officer as they search for the right person for their billet.  Follow the following tutorial on how to update your profile in MyVector.

    


<H3>Log into <a href="https://afvec.langley.af.mil/myvector/" target="_blank">MyVector</a>.</H3>

You will need to create an account if you do not already have one.<br>





<!--<H3>Update your personal profile.</H3>

You should see the following screen after logging in.  <br><br>

<img src="splash.JPG" alt="Go to personal profile"  style="padding:2px;border:thin solid black;">

<br><br>
Update all the applicable fields in your personal profile. As an officer, your screen may look slightly different than what is shown.<br><br>

<img src="profile.JPG" alt="Update your personal profile"  style="padding:2px;border:thin solid black;">

<br><br>Click save when complete.-->





<H3>Update your assignment history and relevant work experience.</H3>

You should see the following screen after logging in.  Click on "See My Experience" to get started.  <br><br>

<img src="see my experience.JPG" alt="See My Experience"  style="padding:2px;border:thin solid black;"><br><br>

<p>Under the "Duty History" tab, your AF duty distory should be automatically filled in.  The quick view table will display the following for each duty entry: Start date of the duty, Duty Title, AFSC, Component, Unit, Organization, Type, Location, MAJCOM, Rank, Career Field Experience Code (created by the CFM), Experience Description, and association request action.

<br><br><img src="duty.JPG" alt="Review your Duty History"  style="padding:2px;border:thin solid black;"> <br><br>

<p>All duty entries are pulled from MilPDS if the information is incorrect, you must contact the local Military Personnel Section (MPS) to ensure the information is updated correctly within those systems. Note: The Rank associated with a duty is calculated from the Date of Rank held when you started the duty.

<p>You can click “Change Component” if your component is incorrect (options include the following: AF Component, Reserve, Air National Guard, and Civilian).  Note: MyVector is Total Force, therefore if your component is incorrect, it is important to correct. The Active Duty history of many reservists will initially display as Reserves due to the initial data source.



<!--<br><br><img src="edit self report.JPG" alt="See My Experience"  style="padding:2px;border:thin solid black;"> -->



<p> The most important area you should pay attention to is the "Other-Self Reported" tab which allows you to add experience garnered throughout your career that cannot be identified any place else (i.e. jobs with other services, deployment experience, previous military or civilian experience, volunteer work, etc).  Click on the "Other-Self Reported" tab to get started.  You can click "Add Additional Experience" or edit existing records.

<br><br><img src="self-report.JPG" alt="SELF-REPORT"  style="padding:2px;border:thin solid black;">

<br><br><img src="self_reported_deployment.JPG" alt="Self reported deployment"  style="padding:2px;border:thin solid black;">



<p>From the way MyVector is set up at this time, you are unable to add your accomplishments and skills to specific assignments.  As such, this is also a good place to list any awards, accomplishments, and skill sets that billet owners should know about.  This could include organizational awards, programming experience, foreign languages, hobbies, supervisory skills, etc.  You can do this by creating adding Additional Experience sections.  For example you can create entries titled "SELF REPORTED SKILLS," "VOLUNTEER WORK," "AWARDS," and listing descriptions in the free-text box as shown in the following screenshot.

<br><br><img src="self_reported_skills.JPG" alt="SELF-REPORTED SKILLS"  style="padding:2px;border:thin solid black;">



<!--<p>You will see the following screen when you create a new self-reported job.  Be sure to fill out all relevant information, especially the free-text Description box where you should provide as much detail as possible.



<br><br><img src="add self report.JPG" alt="See My Experience"  style="padding:2px;border:thin solid black;">

<p>Click "Save" when finished. -->





<H3>Update your education and training.</H3>

<p>This section allows you to view a summary of your education and training information. You will have the ability to view the following tables with 

associated information:
<UL>
<LI><b>Education:</b> Identifies the individuals’ degree information to include the Code, description, level (Ex. MA, BA, CCAF, etc.), school, and award 

date.
<LI><b>Professional Military Education (PME):</b> Identifies the individuals’ PME information to include the code, description, level (Ex. IDE, PDE, Course 

14, etc.), residence status, and award date.
<LI><b>Acquisition Certification:</b> Identifies acquisition certifications held by the individual and includes the code, description, level of certification 

and the award date.
<LI><b>Training:</b> Identifies all training related courses updated in MilPDS/DCPDS for the individual and includes the code, description, level, school, 

and award date. Note: some sections on this table may be left blank if not applicable.
</UL>

You are also able to add additional education experience that is not automatically pulled from DCPDS, as shown below.

<br><br><img src="education.JPG" alt="See My Experience"  style="padding:2px;border:thin solid black;">





<H3>Update your Development Plan.</H3>

<p>This section allows you to update your job preferences, update your desire for training and education, and update your career goals. Just click 

"Development Plan" in the MyVector Dashboard.  Be sure to click the "Save" button in each tab after making changes.

<br><br><img src="development plan.JPG" alt="Development Plan"  style="padding:2px;border:thin solid black;">


<p>The "Job Preferences" tab displays your job preferences to be considered by the Development Teams during the vectoring process.

<br><br><img src="job pref.bmp" alt="Job Preferences"  style="padding:2px;border:thin solid black;">

<p>The "Developmental Education" tab allows you to update your desire for training and/or Professional Military Education programs. You can enter your developmental education goals 

as well as recommended text for your Senior Rater to use in their endorsement comments when you meet a board. You will also be able to update your desired 

PME course. You can also view your current and historical Developmental Education boards by selecting “Click Here”. NOTE: If you are a Captain or Major you 

will also be able to update you Advanced Studies Group intent on this tab.

<br><br><img src="dev edu.bmp" alt="Development Education"  style="padding:2px;border:thin solid black;">

<p>The "Intent & Comments" tab allows you to outline any relevant details concerning your career plans, goals, answering developmental team group intent questions, and any other information you would like leadership to know about.

<br><br><img src="intent.bmp" alt="Intent and Comments"  style="padding:2px;border:thin solid black;">


    </div>


    </div>

</div>


</body>
</html>
