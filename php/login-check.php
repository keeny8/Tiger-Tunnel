<?php
	//display php errors
	ini_set('display_errors', 1);

	require 'DBCredentials.php';

	$mysqli = new mysqli(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_DATABASE);

	if (mysqli_connect_error()) {
		die('Connect Error ('.mysqli_connect_errno().') '.mysqli_connect_error());
	}
	//echo 'Connected successfully.';
	//Creating table if doesnt exist
	$sql = "CREATE TABLE IF NOT EXISTS users (
	userID integer not null primary key auto_increment,
	username varchar(128) not null unique,
	salt CHAR(128) not null,
	password varchar(256) not null,
	createdDate timestamp
	)";
	$result = $mysqli->query($sql);
	
	$ok = true;
	$messages = array();
	
	//Retrieve post variables
	$username = isset($_POST['username']) ? $mysqli->real_escape_string($_POST['username']) : '';
	$password = isset($_POST['password']) ? $mysqli->real_escape_string($_POST['password']) : '';
	$password2 = isset($_POST['password2']) ? $_POST['password2'] : '';
	$registerFlag = isset($_POST['registerFlag']) ? $_POST['registerFlag'] : '';
		
	if(!isset($username) || empty($username)){
		$ok = false;
		$messages[] = 'Username cannot be empty!';
	}
	
	if(!isset($password) || empty($password)){
		$ok = false;
		$messages[] = 'Password cannot be empty';
	}
	
	if($registerFlag == 'true' && $ok){
		if(!isset($password2) || ($password != $password2)){
			$ok = false;
			$messages[] = 'Passwords must match';
		}else{
			$salt = bin2hex(random_bytes(64));
			$salted = $salt.$password;
			$hashed = hash('sha512',$salted);
			
			//Insert into Array
			$sql = "INSERT INTO users (username, salt, password) VALUES ('$username', '$salt', '$hashed')";
			$result = $mysqli->query($sql);	
			$ok = $result;
			if($result==false){
				$messages[] = 'Username is already taken';
			}else{
				$messages[] = 'Registration Successful';
			}
		}
	}
	
	if($registerFlag == 'false' && $ok){
		//Search db for username and then match the password
		$sql = "SELECT * FROM `users` WHERE `username` = '".$username."'";
		$result = $mysqli->query($sql);
		//$messages[] = $mysqli->real_escape_string($username);
		//$messages[] = $sql;
		//$messages[] = $result;
		
		$ok = false;
		if($result){
			foreach($result as $user){
				//need to salt and hash password to compare
				$salt = $user['salt'];
				$salted = $salt.$password;
				$hashed = hash('sha512',$salted);
				
				if($hashed === $user['password']){
					$ok = true;
					$messages[] = 'Successful login!';
				}
			}
		}
		if($ok === false){
			$messages[] = 'Incorrect username/password combination!';
		}
		
	}
	
	echo json_encode(
		array(
			'ok' => $ok,
			'messages' => $messages,
			'username' => $username
		)
	);
?>