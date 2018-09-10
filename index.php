<?php session_start(); ?><!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
	<link href="https://fonts.googleapis.com/css?family=Shadows+Into+Light" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Coming+Soon" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	<script type="text/javascript" src="https://code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
	<!-- main style - stays the last because it overrides the themes of jquery -->
	<link rel="stylesheet" href="css/style.css">


	<title>User access</title>

</head>

<body>

<div class="container user-form">
<form action="user_add.php" method="post">
	<div>
		<legend>New user</legend>
		<input type="text" name="un" placeholder="Username" autocomplete="off" required >
		<input type="password" name="pw" placeholder="Password" autocomplete="off" required>
		<button  class="submit-button" type="submit">opret</button>
	</div>
</form>
</div>
<br/>
<div class="container user-form">
<form action="user_login.php" method="post">
	<div>
		<legend>Login in</legend>
		<input type="text" name="un" placeholder="Username" required autocomplete="off">
		<input type="password" name="pw" placeholder="Password" required autocomplete="off">
		<button class="submit-button" type="submit">login</button>
	</div>
</form>
	</div>
	
	<div>
		<h3>Status</h3>			
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
		
	</div>	


	
</body>
</html>
