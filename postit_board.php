<?php session_start(); ?><!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Post whatever you want</title>


	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
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
	<div id="welcome-field" class="container sidebar">
		<h3>User status</h3>
			
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
	
	
	
	
			
<?php
	if(isset($_SESSION['uid'])){ ?>
	
	
	<div class="container sidebar">

		<h1>Post-it hvad man vil</h1>
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
				<button class="reset-button" name="reset" type="reset" value="reset">nullstil</button>

			</form>
							 
		</div>
	</div>
	
	
	
	<div class="container whiteboard">
		<!--		good code-->
		<?php
		require_once('dbcon.php');
    $sql = 'select postit.id AS pid, date(createdate), headertext, bodytext, cssclass, users.id AS uid, username, cssclass FROM postit, users, color 
WHERE users_id = users.id AND color_id=color.id;';
    $stmt = $link->prepare($sql);
		$stmt->execute();
	$stmt->bind_result($pid, $createdate, $htext, $btext, $cssclass, $uid, $username, $cssclass);
	while ($stmt->fetch()) { ?>

	<div class="draggable postit <?=$cssclass?>">

<form action="delete_postit.php" method="post" onsubmit="return confirm('ER DU SIKKER? vil du slette post-it?')" >
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
		echo '<p> You are not logged in and therefore can not see post-it system</p>';
	}
	
?>

				
	
	</body>
				

</html>