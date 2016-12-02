<!DOCTYPE html> 
<html>
    <head> 
    <?php include './include/head_common.php'; ?>
    <script type="text/javascript">
    	function myAlert(){
    		swal({
    			title: "Forgot your Password?", 
    			text: "<a href='mailto:john.r.lepird.mil@mail.mil'>Contact us </a> to recieve a new password. ", 
    			html: true
    		});
    	}

    <?php
    session_start();
        if (isset($_SESSION["updatedpw"])){
            echo '$(function(){swal("Success!", "Your password was successfully updated.",  "success");});';
            unset($_SESSION["updatedpw"]); 
        }
        if (isset($_SESSION["incorrect"])){
            echo '$(function(){swal("Login Error", "Your username/password combination did not match our records.",  "error");});';
            unset($_SESSION["incorrect"]); 
        }
    ?>
    </script>
    </head>
<body>
<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
<div class="container">
<div class="navbar-header">

                <p>Air Force Talent Marketplace
                <em style="font-size: 10pt;"> An Assignment Matching Test </em></p> 

</div>
</div>
</nav>

<!-- Lazy way to shift right --> 
 <div class="col-md-3">  </div>

<div class="col-md-5">

<h4> Notice and Consent Statement </h4>

You are accessing a U.S. Government (USG) Information System (IS) that is provided for USG-authorized use only.

By using this IS (which includes any device attached to this IS), you consent to the following conditions:

<ol>
    <li> The USG routinely intercepts and monitors communications on this IS for purposes including, but not limited to, penetration testing, COMSEC monitoring, network operations and defense, personnel misconduct (PM), law enforcement (LE), and counterintelligence (CI) investigations.
    </li><li> At any time, the USG may inspect and seize data stored on this IS.
    </li><li>Communications using, or data stored on, this IS are not private, are subject to routine monitoring, interception, and search, and may be disclosed or used for any USG authorized purpose.
    </li><li>This IS includes security measures (e.g., authentication and access controls) to protect USG interests--not for your personal benefit or privacy.
    </li><li>Notwithstanding the above, using this IS does not constitute consent to PM, LE or CI investigative searching or monitoring of the content of privileged communications, or work product, related to personal representation or services by attorneys, psychotherapists, or clergy, and their assistants. Such communications and work product are private and confidential. 
	</li>
</ol>


<center>
<form action=verify.php method="post"> 
<fieldset style="display: inline-block;">
	By logging in, you agree to these terms.
	<table>
	<tr> 
		<td align="right">  Username: </td>
		<td><input type = "text" name = "uname" required/> </td> 
	</tr>
	<tr>
		<td align="right"> Password: </td>
		<td><input type = "password" name = "password" required/> </td>
	</tr>
	<tr>
	<td colspan="2" align="center"> <center><button type="submit" class = "btn btn-primary">Submit</button> </center></td> 
	<td> 
	<tr>
	<td> <a style="font-size: 8pt; color: silver;" href="javascript:myAlert();")> Forgot Password? </a> </td>
	<td align = "right"> <a style="font-size: 8pt; color: silver;" href="changepassword.php"> Change Password </a> </td>
	</tr>
	</td>
	</tr>
	</table>
</fieldset>
</form>
</center>
</div>
</body>
</html>