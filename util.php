<?php

function createUser($un, $pw){
	$pwhash = password_hash($pw, PASSWORD_DEFAULT);
	require('dbcon.php');

	$sql = 'INSERT INTO users (username, pwhash) VALUES (?, ?)';
	$stmt = $link->prepare($sql);
	$stmt->bind_param('ss', $un, $pwhash);
	$stmt->execute();

	return $stmt->affected_rows;
}


function loginUser($un, $pw){
	require('dbcon.php');

	$sql = 'SELECT id, pwhash FROM users WHERE username=?';
	$stmt = $link->prepare($sql);
	$stmt->bind_param('s', $un);
	$stmt->execute();
	$stmt->bind_result($id, $pwhash);

	while ($stmt->fetch()){	}

	$loginValid = password_verify($pw,$pwhash);
	if ($loginValid){
		$_SESSION['uid'] = $id;
		$_SESSION['uname'] = $un;
	}
	return $loginValid;
}


function logoutUser(){
	$_SESSION = array();
	if (ini_get("session.use_cookies")) {
		$params = session_get_cookie_params();
		setcookie(session_name(), '', time() - 42000,
			$params["path"], $params["domain"],
			$params["secure"], $params["httponly"]
		);
	}
	session_destroy();
}


function create_postit(){
	require_once('dbcon.php');
    $sql = 'select postit.id AS pid, date(createdate), headertext, bodytext, cssclass, users.id AS uid, username, cssclass 
	FROM postit, users, color 
WHERE users_id = users.id AND color_id=color.id;';
		
    $stmt = $link->prepare($sql);
	$stmt->execute();
	$stmt->bind_result($pid, $createdate, $htext, $btext, $cssclass, $uid, $username, $cssclass);
	while ($stmt->fetch()); 
}


function delete_postit(){
		 
		$postitid = filter_input(INPUT_POST,'pid', FILTER_VALIDATE_INT) or die('MiSSing something');
		$userid = $_SESSION['uid'];
	
		require_once('dbcon.php');

		$sql = 'delete from postit where id=? and users_id=?';
	  	$stmt = $link->prepare($sql);
    	$stmt->bind_param('ii', $postitid, $userid);
		$stmt->execute();

	}


function choose_color(){
	require_once('dbcon.php');
		    $sql = 'select id, colorname from color';
		    $stmt = $link->prepare($sql);
		    $stmt->execute();
		    $stmt->bind_result($colorid, $colorname);
		    while($stmt->fetch()){
					echo '<input type="radio" name="colorid" value="'.$colorid.'">'.$colorname.PHP_EOL;
		    }
}



