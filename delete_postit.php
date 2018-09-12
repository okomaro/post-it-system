<?php session_start(); ?>
<?php	
	if(isset($_SESSION['uid'])){ 
		$postitid = filter_input(INPUT_POST,'pid', FILTER_VALIDATE_INT) or die('MiSSing something');
		$userid = $_SESSION['uid'];
	
		require_once('dbcon.php');

		$sql = 'delete from postit where id=? and users_id=?';
	  	$stmt = $link->prepare($sql);
    	$stmt->bind_param('ii', $postitid, $userid);
		$stmt->execute();
		header('Location: index.php');
		exit();
	}
else {
	echo 'it is not your post';
}


