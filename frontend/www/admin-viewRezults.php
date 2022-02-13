<form action="" method="post" name="myForm">
	<input type="text" name="username" placeholder="username" />
	<input type="text" name="task" placeholder="task Name" />
	<button>View Rezults</button>
</form>

<?php
if (isset($_POST['username']) && isset($_POST['task'])) {
	$_GET['username'] = $_POST['username'];
	$_GET['task'] = $_POST['task'];
	include 'showRezults.php';
}
?>