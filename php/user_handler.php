<?php
	require('dbconn.php');

	$db = new DBConnection();
	$conn = $db->GetConnection();
	$conn->beginTransaction();

	if($conn) {
		echo "\nConnected to database";
	} else  {
		echo "\nNot connected";
	}

	if(isset($_GET['id']) && isset($_GET['firstName']) && isset($_GET['lastName']) && isset($_GET['email'])) {
		$user = $_GET['id'];
		$FirstName = $_GET['firstName'];
		$LastName = $_GET['lastName'];
		$email = $_GET['email'];
	}

	$check = $conn->prepare("SELECT * FROM users WHERE FBID = :user");
	$check->bindParam(':user', $user, PDO::PARAM_INT);
	$check->execute();

	$result = $check->fetchAll();
	$check->closeCursor();

	if(count($result) > 0) {
		echo "\nUser exists.";
	} else {
		//$conn->exec($ins);
		echo "\nAdding '$user' to database.";
		$sql = "INSERT INTO users (FirstName, LastName, FBID, Email) VALUES (:FirstName, :LastName, :usr, :eml)";
		$ins = $conn->prepare($sql);
		$ins->bindParam(":FirstName", $FirstName, PDO::PARAM_STR);
		$ins->bindParam(":LastName", $LastName, PDO::PARAM_STR);
		$ins->bindParam(":usr", $user, PDO::PARAM_INT);
		$ins->bindParam(":eml", $email, PDO::PARAM_STR);
		if (!$ins) {
		    echo "\nPDO::errorInfo():\n";
    		print_r($conn->errorInfo());
		}
		$ins->execute();
		$ins->closeCursor();
		$conn->commit();
	}

	$conn = null;
	echo "\n***End user_handler***";
?>


