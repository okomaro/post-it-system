<!DOCTYPE html>
<html lang="en">

<head>

	<title>User login</title>

</head>

<body>
	
<?php
	
	if(isset($_SESSION['uid'])){ ?>
		Currently logged in as <?=$_SESSION['uname']?> with id=<?=$_SESSION['uid']?>
		<form action="logout.php" method="post">
			<button type="submit">Logout</button>
		</form>
		
<?php	}
	else {
		echo 'Not logged in';
	}
	
?>

	

</body>
</html>