<html>
    <head> 
    <?php include './include/head_common.php'; ?>
    </head>
<body>
<nav class="navbar navbar-custom navbar-fixed-top" role="navigation">
<div class="container">
<div class="navbar-header">

        <h4>Air Force Next-Gen Assignments System</h4>

</div>
</div>
</nav>

<!-- Lazy way to shift right --> 
 <div class="col-md-3">  </div>

<div class="col-md-5">

<h3> Login </h3>

<form action=verify.php method="post"> 
	<table>
	<tr> 
		<td> Username: </td>
		<td><input type = "text" name = "uname" required/> </td> 
	</tr>
	<tr>
		<td> Password: </td>
		<td><input type = "password" name = "password" required/> </td>
	</tr>
	<tr>
	<td> <button type="submit" class = "btn btn-primary">Submit</button> </td>
	</tr>
	</table>
</form>
</div>
</body>
</html>