<?php session_start(); ?><!DOCTYPE html>
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

<?php
	if(!isset($_SESSION['uid'])){ ?>
	
	
<form id="new-user" action="" method="post">
	<div class="container user-form">
		<legend>New user</legend>
		<input type="text" name="un" placeholder="Username" autocomplete="off" required >
		<input type="password" name="pw" placeholder="Password" autocomplete="off" required>
		<button  class="submit-button" type="submit">opret</button>
	</div>
	<?php 

	$un = filter_input(INPUT_POST, 'un') or die ('Missing USERNAME parameters');
	$pw = filter_input(INPUT_POST, 'pw') or die ('Missing PASSWORD parameters');
	$pwhash = password_hash($pw, PASSWORD_DEFAULT);

	require_once('dbcon.php');

    $sql = 'INSERT INTO users (username, pwhash) VALUES (?, ?)';
    $stmt = $link->prepare($sql);
    $stmt->bind_param('ss', $un, $pwhash);
		$stmt->execute();

		if($stmt->affected_rows > 0) {
		echo 'USER '.$un.' IS CREATED'.PHP_EOL;  
		} 
				 
		else {
		echo 'Can not create user '.$un.'. It already exists. Please use another name'.PHP_EOL;
		 }
		?>
</form>

	<p> or </p>	
			
<form id="login" action="" method="post">
	
	<div class="container user-form">
		<legend>Login</legend>
		<input type="text" name="un" placeholder="Username" required autocomplete="off">
		<input type="password" name="pw" placeholder="Password" required autocomplete="off">
		<button class="submit-button" type="submit">login</button>
	</div>
	
<?php
	$un = filter_input(INPUT_POST, 'un') or die ('Missing USER NAME parameters');
	$pw = filter_input(INPUT_POST, 'pw') or die ('Missing PASSWORD parameters');

	require_once('dbcon.php');

    $sql = 'select id, pwhash from users where username=?;';
    $stmt = $link->prepare($sql);
    $stmt->bind_param('s', $un);
		$stmt->execute();

		$stmt->bind_result($id, $pwhash);

		while($stmt->fetch()){}
	
			if (password_verify($pw, $pwhash)){ 
	
			echo '<strong>WELCOME user '.$un.' with id:</strong>'.$id.PHP_EOL;
			$_SESSION['uid']=$id;
			$_SESSION['uname']=$un;	
			
			}
		

			else { 
			echo 'ILLEGAL passord for USER '.$un.''.PHP_EOL;
			}
?>

</form>
	
	
		
<?php	}
	else { ?>
	
	<strong>Currently logged in as <?=$_SESSION['uname']?> with id=<?=$_SESSION['uid']?></strong>
		<form action="logout.php" method="post">
			<button class="second-button" type="submit">Logout</button>
		</form>

<?php	}
	
?>
		
	
</div> <!--		end of welcome-field	-->
	
	
	
<!-- if user is logged in, show the postit system -->
<?php
	if(isset($_SESSION['uid'])){ ?>
	
	
	<div class=" container sidebar">

		<h2>Post-it hvad man vil</h2>
		<div>
			<form action="new_post_it.php" method="post">
				<h3>Overskrift:</h3>
				<input class="textfield-small" type="text" name="headertext"  placeholder="Overskrift" autocomplete="off" required><br/>
				<h3>Huskenote:</h3>
				<textarea class="textfield-large" type="" name="bodytext" placeholder="Hvad skal man huske?" autocomplete="off" required></textarea>
			
				<h3>Post-it farve:</h3>
				
				<?php
		  require_once('dbcon.php');
		    $sql = 'select id, colorname from color';
		    $stmt = $link->prepare($sql);
		    $stmt->execute();
		    $stmt->bind_result($colorid, $colorname);
		    while($stmt->fetch()){
					echo '<input type="radio" name="colorid" value="'.$colorid.'">'.$colorname.PHP_EOL;
		    }
		  ?>

				<br/>
				<button class="submit-button" name="submit" type="submit" value="submit-true"> Post it!</button>
				<button class="second-button" name="reset" type="reset" value="reset">nullstil</button>

			</form>
							 
		</div>
	</div>
	
	
	
	<div class="container whiteboard">
		<!--		good code-->
		<?php
		require_once('dbcon.php');
    $sql = 'select postit.id AS pid, date(createdate), headertext, bodytext, cssclass, users.id AS uid, username, cssclass 
	FROM postit, users, color 
WHERE users_id = users.id AND color_id=color.id;';
		
    $stmt = $link->prepare($sql);
		$stmt->execute();
	$stmt->bind_result($pid, $createdate, $htext, $btext, $cssclass, $uid, $username, $cssclass);
	while ($stmt->fetch()) { ?>

	<div class="draggable postit <?=$cssclass?>">

<form action="delete_postit.php" method="post" onsubmit="return confirm('ER DU SIKKER? vil du slette post-it?')">
	<button type="submit" name="pid" value="<?=$pid?>"><i class="far fa-trash-alt fa-fa-lg" ></i></button>
</form>

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