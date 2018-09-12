
		<?php if($_SESSION['uid']==$uid) { ?>
		
	<form action="<?=$_SERVER['PHP_SELF']?>" method="post" onsubmit="you want to see only your postits">
		
	<input hidden type="submit" name="cmd" value="my_postits">
		
	<button class="submit-button" type="submit" name="pid" value="<?=$pid?>">vis kun min<i class="far fa-trash-alt fa-fa-lg" ></i></button>

	</form>
		
	<?php }	
	 
	?>		