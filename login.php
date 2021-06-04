<?php
session_start();

include 'database.php';

if (isset($_POST['submit'])) {
	$email = $_POST['email'];
	$password = $_POST['password'];

	$login = $db->query("select * from mahasiswa where email='$email' and pass='$password'");
	$cek = mysqli_num_rows($login);

	if ($cek > 0) {
		$data = mysqli_fetch_array($login);

		if ($data['tipe'] == 1) {

			$_SESSION['id'] = $data['mahasiswa_id'];
			$_SESSION['nim'] = $data['nim'];
			$_SESSION['nama'] = $data['nama'];
			$_SESSION['tipe'] = $data['tipe'];

			header("Location: _welcomeadmin.php");
		}

		if ($data['tipe'] == 2) {
			$_SESSION['id'] = $data['mahasiswa_id'];
			$_SESSION['nim'] = $data['nim'];
			$_SESSION['nama'] = $data['nama'];
			$_SESSION['tipe'] = $data['tipe'];

			header("Location: _welcomemhs.php");
		}
	} else {
		header("Location: login.php?pesan=gagal");
	}
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
	<link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/sign-in/">
	<link href="login.css" rel="stylesheet">
	<title>Login</title>
</head>

<body class="text-center">
	<main class="form-signin">
		<form method="post" action="">
			<h1 class="h3 mb-5 fw-normal">Login Sistem Informasi Rekapitulasi Absensi</h1>

			<div class="form-floating">
				<input type="email" class="form-control" name="email" id="email" placeholder="name@example.com" required>
				<label for="email">Email</label>
			</div>
			<div class="form-floating">
				<input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
				<label for="password">Password</label>
			</div>

			<button class="w-100 btn btn-lg btn-primary" name="submit" type="submit">Login</button>
		</form>
	</main>
</body>

</html>