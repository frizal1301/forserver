<?php 
session_start();
require_once __DIR__.'/config/database.php';

$id = $_SESSION['id'];

$db = Database::getDatabase();
$stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);

$row = $stmt->fetch();

if($_SERVER['REQUEST_METHOD'] == "POST") {
	$oldPassword = $_POST['oldPassword'];
	$newPassword = $_POST['newPassword'];
	$cnewPassword = $_POST['cnewPassword'];


	if(!password_verify($oldPassword, $row['password'])) {
		echo "<script>
			alert('Password salah');
			window.location.href='change_password.php';
		</script>";	
	}

	if($cnewPassword !== $newPassword) {
		echo "<script>
			alert('Konfirmasi password tidak sesuai');
			window.location.href='change_password.php';
		</script>";	
	}

	if(trim($cnewPassword) == "" || trim($oldPassword) == "" || trim($newPassword) == "") {
		echo "<script>
			alert('Old Password, New Password dan Konfirmasi Password tidak boleh kosong');
			window.location.href='change_password.php';
		</script>";	
	}

	$hashPassword = password_hash($newPassword, PASSWORD_BCRYPT);

	$sql = "UPDATE users SET password = ? WHERE id = ?";
	$stmt = $db->prepare($sql);

	if($stmt->execute([$hashPassword, $id])) {
		echo "<script>
			alert('Password berhasil diubah');
			window.location.href='dashboard.php';
		</script>";	
	}


}


?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="author" content="Kodinger">
	<meta name="viewport" content="width=device-width,initial-scale=1">
	<title>My Login Page &mdash; Bootstrap 4 Login Page Snippet</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
	<link rel="stylesheet" type="text/css" href="css/my-login.css">
</head>
<body class="my-login-page">
	<section class="h-100">
		<div class="container h-100">
			<div class="row justify-content-md-center align-items-center h-100">
				<div class="card-wrapper">
					<div class="brand">
						<h3>Login Management System</h3>
					</div>
					<div class="card fat">
						<div class="card-body">
							<h4 class="card-title">Change Password</h4>
							<form method="POST" class="my-login-validation" novalidate="">
								<div class="form-group">
									<label for="oldPassword">Old Password</label>
									<input id="oldPassword" type="password" class="form-control" name="oldPassword" value="" required autofocus>
								</div>
								<div class="form-group">
									<label for="newPassword">New Password</label>
									<input id="newPassword" type="password" class="form-control" name="newPassword" value="" required autofocus>
								</div>
								<div class="form-group">
									<label for="cnewPassword">Retype New Password</label>
									<input id="cnewPassword" type="password" class="form-control" name="cnewPassword" value="" required autofocus>
								</div>

								<div class="form-group m-0">
									<button type="submit" class="btn btn-primary btn-block">
										Change Password
									</button>
								</div>
							</form>
						</div>
					</div>
					<div class="footer">
						Copyright &copy; 2021 &mdash; Fahru Rizal 
					</div>
				</div>
			</div>
		</div>
	</section>

	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
</body>
</html>