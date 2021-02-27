<?php
session_start(); // Starting Session
$error=''; // Variable To Store Error Message
if (isset($_POST['submit'])) 
{
	if(empty($_POST['login_type']))
	{
		$error = "Please Select Login Type";
	}
	else if(empty($_POST['department']))
	{
		$error = "Please Select Department";
	}
	else if(empty($_POST['username']))
	{
		$error = "Please Enter Username";
	}
	else if(empty($_POST['password']))
	{
		$error = "Please Enter Password";
	}
	else if (empty($_POST['username']) && empty($_POST['password']))
	{
		$error = "Please Enter Username And Password";
	}
	else	
	{
		// Define $username and $password
		$username=$_POST['username'];
		$password=$_POST['password'];
		$department=$_POST['department'];
		$login_type=$_POST['login_type'];
		// Establishing Connection with Server by passing server_name, user_id and password as a parameter
		$connection = mysqli_connect("localhost", "root", "");
		// To protect MySQL injection for Security purpose
		$username = stripslashes($username);
		$password = stripslashes($password);
		$username = mysqli_real_escape_string($connection,$username);
		$password = mysqli_real_escape_string($connection, $password);
		// Selecting Database
		$db = mysqli_select_db($connection, "registration");
		// SQL query to fetch information of registerd users and finds user match.
		$query = mysqli_query($connection, "select * from user where PASSWORD='$password' AND USERNAME='$username' AND DEPARTMENT='$department' AND USER_TYPE='$login_type'");
		$rows = mysqli_num_rows($query);
		if ($rows>0) 
		{
			if($login_type=='Student')
			{
				$_SESSION['login_user']=$username; // Initializing Session
				$_SESSION['user_type']=$login_type;
				/*$myfile = fopen("E:\DSLR pgotos\login_history.txt", "a");
				$date_time=date();
				$login_msg="Login Date & Time ";//: ".$date_time. "Login as ".$username;*/
				 $log  = "User: ".$_SERVER['REMOTE_ADDR'].' - '.date("F j, Y, g:i a").PHP_EOL.
            "Attempt: ".($result[0]['success']=='1'?'Success':'Failed').PHP_EOL.
            "User: ".$username.PHP_EOL.
            "-------------------------".PHP_EOL;
    //-
    file_put_contents('./log_'.date("j.n.Y").'.txt', $log, FILE_APPEND);
				fwrite($myfile,$login_msg);
				header("location:student/index.php"); // Redirecting To Other Page
			}
			else if($login_type=='Faculty')
			{
				$_SESSION['login_user']=$username; // Initializing Session
				$_SESSION['user_type']=$login_type;
				//header("location:faculty/index.php"); // Redirecting To Other Page
			}
			else
			{
				$_SESSION['login_user']=$username; // Initializing Session
				$_SESSION['user_type']=$login_type;
				//header("location:admin/index.php"); // Redirecting To Other Page
			}
		} 
		else 
		{
			$error = "Username or Password is invalid";
		}
		mysqli_close($connection); // Closing Connection
	}
}
?>
