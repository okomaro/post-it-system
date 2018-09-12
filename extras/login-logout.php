	<?php
		if(!isset($_SESSION['uid'])){ ?>

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

			<p> or </p>	

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



	<?php	}
		else { ?>

		<div><strong>Currently logged in as <?=$_SESSION['uname']?> with id=<?=$_SESSION['uid']?></strong></div>
			<form action="logout.php" method="post">
				<button class="second-button" type="submit">Logout</button>
			</form>
			<form action="privateposts.php" method="post">
				 <button class="second-button" type="submit">vis kun mine postits</button>
			</form>
				 
				

	<?php	}

	?>