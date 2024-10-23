<?php
session_start();
$errorMessage = '';
$roles = '';

if (isset($_POST['txtUserId']) && isset($_POST['txtPassword']) && isset($_POST['roles'])) {

    $dbhost = 'localhost';
    $dbuser = 'root';
    $dbpass = '';
    $dbname = 'project_akhir';

    $conn = mysqli_connect($dbhost, $dbuser, $dbpass, $dbname) or die('Error connecting to mysql');
    
    $userId = $_POST['txtUserId'];
    $password = $_POST['txtPassword'];
    $roles = $_POST['roles']; // Capture the roles field

    $sql = "SELECT email FROM users WHERE email = '$userId' AND passwrd ='$password' AND roles = '$roles'";
    
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) == 1) {

        $_SESSION['user_is_logged_in'] = true;

        if ($roles == 'Dosen') {
            header('Location: dosen.php'); // Redirect to dosen page
        } else if ($roles == 'Mahasiswa') {
            header('Location: mahasiswa.php'); // Redirect to mahasiswa page
        }
        exit;
    } else {
        $errorMessage = 'Sorry, wrong user id / password';
    }
    mysqli_close($conn);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {
            font-family: Product Sans; 
            background-color: #1751a5;
        }
    </style>
</head>
<body>
    <div class="card position-absolute top-50 start-50 translate-middle border-0 shadow rounded-4 overflow-hidden" style="width: 410px; height: 500px;">
        <div class="card-body d-flex justify-content-center align-items-center">
            <div>
                <h5 class="card-title fw-bold fs-2 m-3 text-center">Login</h5>
                <form style="width: 300px;" method="POST" name="frmLogin" id="frmLogin">
                    <div class="mb-3 mt-4">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" name="txtUserId" id="txtUserId">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input name="txtPassword" type="password" id="txtPassword" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="roles" class="form-label">Login Sebagai</label>
                        <select class="form-control" name="roles" id="roles">
                            <option value=""> - Pilih - </option>
                            <option value="Dosen" <?php if($roles == 'Dosen') echo 'selected'; ?>>Dosen</option>
                            <option value="Mahasiswa" <?php if($roles == 'Mahasiswa') echo 'selected'; ?>>Mahasiswa</option>
                        </select>
                    </div>

                    <?php
                    if ($errorMessage != '') {
                        ?>
                            <p align="center"><strong><font color="#990000"><?php echo $errorMessage; ?></font></strong></p>
                        <?php
                    }
                    ?>

                    <button class="btn btn-primary mb-2" name="btnLogin" type="submit" id="btnLogin" value="Login">Submit</button>
                </form>
            </div>
        </div>

        <div class="card-footer border-0 bg-white overflow-hidden">
            <div class="row mx-1">
                <div class="col" style="width: 100px">
                    <p>Don't have an account?</p>
                </div>
                <div class="col">
                    <a href="register.php" class="card-link float-end text-decoration-none">Sign up</a>
                </div>
            </div>
        </div>

    </div>
</body>
</html>