<?php
	session_start();

	$un = filter_input(INPUT_POST, 'un') or die ('Missing author parameters');
	$pw = filter_input(INPUT_POST, 'pw') or die ('Missing headertext parameters');
	

	require_once('dbcon.php');

    $sql = 'select id, pwhash from users where username=?;';
    $stmt = $link->prepare($sql);
    $stmt->bind_param('s', $un);
		$stmt->execute();

		$stmt->bind_result($id, $pwhash);

		while($stmt->fetch()){}
	
			if (password_verify($pw, $pwhash)){
			echo 'Login granted for USER '.$un.' with id:'.$id.PHP_EOL;
			echo '<a href="index.php">Continue</a>'.PHP_EOL;
			$_SESSION['uid']=$id;
			$_SESSION['uname']=$un;	
			}

			else { 
			echo 'ILLEGAL passord for USER '.$un.''.PHP_EOL;
			}

