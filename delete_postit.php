<?php
  $postitid = filter_input(INPUT_POST,'pid', FILTER_VALIDATE_INT)
		or die('MiSSing something');
  require_once('dbcon.php');

  $sql = 'delete from postit where id=?';
	  $stmt = $link->prepare($sql);
    $stmt->bind_param('i', $postitid);
		$stmt->execute();
	header('HTTP/1.1 303 See other');
	header('Location: postit_board.php');
	exit();