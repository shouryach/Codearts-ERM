<?php
	session_start();
	$baseURL = 'http://codeartssolution.com/ERM/';
	date_default_timezone_set('Asia/Kolkata');
	$con = mysqli_connect("107.180.58.68","codearts_pms","2Z6!ON!n_{aU","codearts_pms");

	$user_info = $_GET['user_info'];
	$token = md5(rand());
	$sql1 = "SELECT * FROM capms_admin_users WHERE user_email = '".$user_info."' OR user_contact = '".$user_info."' OR user_empid = '".$user_info."' ";
	$result1 = mysqli_query($con, $sql1);
	if($result1->num_rows > 0)
	{
		while($row1 = mysqli_fetch_assoc($result1))
		{
			echo json_encode(
				array(
					"status" => 'success',
					"action" => "<p class='user-info-success text-success'><span class='validation-success'><i class='fas fa-tick'></i></span>A Password Reset Link has been sento the registered email address. Please check.".$row1['user_email']."-".$token."</p>"
				)
			);
		}
	}
	else
	{
		echo json_encode(
			array(
				"status" => 'error',
				"action" => "<p class='user-info-error text-danger'><span class='validation-alert'><i class='fas fa-exclamation'></i></span>This Email ID does not exists. Either register or try some other Email ID.</p>"
			)
		);
	}