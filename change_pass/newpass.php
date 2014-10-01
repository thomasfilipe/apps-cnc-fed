<?php 
	session_start();
        if ( !isset($_SESSION['login'])) {
                session_destroy();
                unset ($_SESSION['login']);
                header('location:index.php');
        }

?>


<html>

<head>
        <h2>Change your password!</h2>
	
	<script>
	
		function checkAlphaNumeric(){
	      		if(preg_match('/^[0-9]+$/', document.cpform.newpass.value) || preg_match('/^[0-9]+$/', document.cpform.renewpass.value))
		   		alert ("Alpha-Numeric caracters only!");
			else if(preg_match('/^[a-zA-Z]+$/', document.cpform.newpass.value) || preg_match('/^[a-zA-Z]+$/', document.cpform.renewpass.value))
		   		alert ("Alpha-Numeric caracters only!");
		 	else
		   		 return true;
		}
	</script>

</head>

<body>
<div id ="user"> <?php echo "User: ".$_SESSION['login'];
			echo "  <a href='logout.php'>Sign out</a>";
		 ?> </div><br><br>
	<h4>Preferably, use an alphanumeric string for your new password.</h4>
        <form method="POST" name = "cpform" action="updatepass.php" OnSubmit="javascript:checkAlphaNumeric();">

		<label>Old Password:</label>
		<input type="password" name="oldpass" id="oldpass"><br>
                <label>New Password:</label>
                <input type="password" name="newpass" id="newpass"><br>
                <label>Retype New Password:</label>
                <input type="password" name="renewpass" id="renewpass"><br>
                <input type="submit" value="Change Password" id="changepass" name="changepass">
        </form>

</body>
</html>

