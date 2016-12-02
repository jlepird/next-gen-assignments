<!DOCTYPE html> 
<html>
    <head> 
    <?php include './include/head_common.php'; 
    session_start();
    ?>
    <script type="text/javascript">
        <?php
            if (isset($_SESSION["nomatch"])){
                echo '$(function(){swal("Oops...", "Your proposed passwords did not match.",  "error");});';
                unset($_SESSION["nomatch"]); 
            }
            if (isset($_SESSION["tooshort"])){
                echo '$(function(){swal("Oops...", "Your password is too short. Please ensure it is at least 10 characters, and contains at least one number and letter.",  "error");});';
                unset($_SESSION["tooshort"]); 
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

<form action=changepw.php method="post"> 
<fieldset style="display: inline-block;">
    <strong> Use the following form to change your password: </strong>
    <table>
    <tr> 
        <td align="right">  Username: </td>
        <td><input type = "text" name = "uname" required/> </td> 
    </tr>
    <tr>
        <td align="right"> Old Password: </td>
        <td><input type = "password" name = "password" required/> </td>
    </tr>
    <tr>
        <td align="right"> New Password: </td>
        <td><input type = "password" name = "password1" required/> </td>
    </tr>
    <tr>
        <td align="right"> New Password Again: </td>
        <td><input type = "password" name = "password2" required/> </td>
    </tr>
    <tr>
    <td colspan="2" align="center"> <center><button type="submit" class = "btn btn-primary">Submit</button> </center></td> 
    <td> 
    </td>
    </tr>
    </table>
</fieldset>
</form>

</div>
</body>
</html>