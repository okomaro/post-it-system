<?php session_start(); 
require_once('util.php');

$cmd = $_POST['cmd'] ?? null;
	
	switch ($cmd){
		case 'createuser':
			$un = filter_input(INPUT_POST, 'un') or die('Missing or illegal un parameter');	
			$pw = filter_input(INPUT_POST, 'pw') or die('Missing or illegal pw parameter');	
			if (createUser($un, $pw) > 0){
				loginUser($un, $pw);
			}
			else {
				echo '<div class="container notice"><p>Unable to create user - username already exists<p></div>';
			}
			break;
		case 'login':
//			echo 'checklogin';
			$un = filter_input(INPUT_POST, 'un') or die('Missing or illegal un parameter');	
			$pw = filter_input(INPUT_POST, 'pw') or die('Missing or illegal pw parameter');	
			loginUser($un, $pw);
			break;
			
		case 'logout':
			logoutUser();
			break;
		
		case 'create_postit':
			create_postit();
			break;
			
		case 'delete_postit':
			delete_postit();
			break;
			
		case 'choose_color':
			choose_color();
			break;
			
		default:
			// ignore
			echo 'unknown cmd='.$cmd;
			
	}
	


?><!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Post whatever you want</title>


<!--	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">-->
	
	<link href="https://fonts.googleapis.com/css?family=Shadows+Into+Light" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Coming+Soon" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
	
	<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
	
	<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
	
	<script type="text/javascript" src="https://code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
	
	<!-- main style - stays the last because it overrides the themes of jquery -->
	<link rel="stylesheet" href="css/style.css">


	<script>
	$( function() {
		$( ".draggable" ).draggable();
	} );
	</script>

</head>

<body>
	

<div class="container welcome-field">
	
	<h1>User status</h1>
	
		
<form action="<?=$_SERVER['PHP_SELF']?>" method="post">	
	<div>
<?php
	if (isset($_SESSION['uid'])){ ?>	
		<h2>Logged in as <?=$_SESSION['uname']?></h2>
		<button class="submit-button" type="submit" name="cmd" value="logout">Logout</button>
<?php } else { ?>
		<h2>Login</h2>
		<input type="text" name="un" placeholder="Username" required>
		<input type="password" name="pw" placeholder="Password" required>
		<button class="submit-button" type="submit" name="cmd" value="login">Login</button>
		<button class="submit-button" type="submit" name="cmd" value="createuser">Create</button>
<?php } ?>
	</div>	
</form>

		
	
</div> <!--		end of welcome-field	-->
	
	
	
<!-- if user is logged in, show the postit system -->
<?php
	if(isset($_SESSION['uid'])){ ?>
	
	
	<div class=" container sidebar">

		<h2>Post-it hvad man vil</h2>

			<form action="new_post_it.php" method="post">
				<h3>Overskrift:</h3>
				<input class="textfield-small" type="text" name="headertext"  placeholder="Overskrift" autocomplete="off" required><br/>
				<h3>Huskenote:</h3>
				<textarea class="textfield-large" type="text" name="bodytext" placeholder="Hvad skal man huske?" autocomplete="off" required></textarea>
			
				<h3>Post-it farve:</h3>
			

				<?php
		  require('dbcon.php');
		    $sql = 'select id, colorname from color';
		    $stmt = $link->prepare($sql);
		    $stmt->execute();
		    $stmt->bind_result($colorid, $colorname);
		    while($stmt->fetch()){
					echo '<input type="radio" name="colorid" value="'.$colorid.'">'.$colorname.PHP_EOL;
		    }
		  ?>

				<br/>
				<button class="submit-button" name="cmd" type="submit" value="submit-true"> Post it!</button>
				<button class="second-button" name="reset" type="reset" value="reset">nullstil</button>

			</form>
						 
	
	</div>
	
	
<!--WHAT TO DO HERE?-->
	
	<div class="container whiteboard">
		
		<!--		good code-->
	<?php
		require('dbcon.php');
    $sql = 'select postit.id AS pid, date(createdate), headertext, bodytext, users.id AS uid, username, cssclass 
	FROM postit, users, color 
WHERE users_id = users.id AND color_id=color.id;';
		
    $stmt = $link->prepare($sql);
		$stmt->execute();
	$stmt->bind_result($pid, $createdate, $htext, $btext, $uid, $username, $cssclass);
	while ($stmt->fetch()) { ?>

	<div class="draggable postit <?=$cssclass?>">

<?php if($_SESSION['uid']==$uid) { ?>
		
	<form action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="return confirm('ER DU SIKKER? vil du slette post-it?')">
		
	<input type="hidden" name="pid" value="<?=$pid?>">
		
	<button type="submit" name="cmd" value="delete_postit"><i class="far fa-trash-alt fa-fa-lg" ></i></button>

	</form>
		
	<?php }	
	 
	?>	

		<h2><?=$htext?></h2>
		<p><?=$btext?></p>
		<p class="name"><?=$username?></p>
		<time datetime="Y-M-D" ><?=$createdate?></time>
	</div>

<?php } ?>

		
<!--		end of good code-->

		</div>
		
<?php	}
	else {
		echo '<strong> You are not logged in and therefore can not see post-it system</strong>';
	}
	
?>
<!-- end of block: if user is loged in show the postit system -->

				
	
	</body>
				

</html>