<?php session_start(); ?>
<?php
	$headertext = filter_input(INPUT_POST, 'headertext') or die ('insert headertext parameters');
	$bodytext = filter_input(INPUT_POST, 'bodytext') or die ('Insert bodytext parameters');
	$colorid = filter_input(INPUT_POST, 'colorid') or die ('Insert colorid parameters');
	$userid = $_SESSION['uid'];

	require_once('dbcon.php');

  $sql = 'INSERT INTO postit (headertext, bodytext, color_id, users_id) VALUES ( ?, ?, ?, ?)';
  $stmt = $link->prepare($sql);
  $stmt->bind_param('ssii', $headertext, $bodytext, $colorid, $userid);
	$stmt->execute();

//	header('HTTP/1.1 303 See other');
	header('Location: postit_board.php');
	exit();
