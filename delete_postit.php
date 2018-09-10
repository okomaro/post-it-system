<?php	
	if(isset($_SESSION['uid'])){ 

		$postitid = filter_input(INPUT_POST,'pid', FILTER_VALIDATE_INT) or die('MiSSing something');
		$userid = $_SESSION['uid'] or die('you should log in first');
	
		require_once('dbcon.php');

		$sql = 'delete from postit where id=? and users_id=?';
	  	$stmt = $link->prepare($sql);
    	$stmt->bind_param('ii', $postitid, $userid);
		$stmt->execute();
//		echo "deleted!";
		header('HTTP/1.1 303 See other');
		header('Location: postit_board.php');
		exit();


		}
		
	else {
		echo 'You can not delete other peoples post-its';
	}
//				