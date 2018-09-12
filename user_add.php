
<?php
	$un = filter_input(INPUT_POST, 'un') or die ('Missing author parameters');
	$pw = filter_input(INPUT_POST, 'pw') or die ('Missing headertext parameters');
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
			

	