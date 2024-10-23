<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project_akhir";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}
// echo "Koneksi Berhasil<br/>";

$nama = "";
$email = "";
$passwrd = "";
$roles = "";
$error = "";
$sukses = "";

if(isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
    
}

if (isset($_POST['simpan'])) { // untuk create data
    $nama = $_POST['nama'];
    $email = $_POST['email'];
    $passwrd = $_POST['passwrd'];
    $roles = $_POST['roles'];

    if($nama && $email && $passwrd && $roles) { // untuk insert 
        $sql = "INSERT into users(nama,email,passwrd,roles) values('$nama','$email','$passwrd','$roles')";
        $q1 = mysqli_query($conn, $sql);
        if ($q1) {
            $sukses = "berhasil memasukkan data";
        } else {
            $error = "Gagal memasukkan data";
        }
    } else {
        $error = "Silahkan masukkan semua data";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        body {font-family:Product Sans; background-color: #1751a5}
    </style>
</head>
<body>

    <div>
        <div class="card position-absolute top-50 start-50 translate-middle rounded-4 shadow border-0 overflow-hidden" style="width: 600px">

            <div class="card-title fw-bold fs-2 m-3 text-center" style="font-size:20px; background-color: white;">
                Register
            </div>

            <div class="card-body mx-2 pt-0 pb-0">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                    
                <?php
                    header("refresh: 2;url=register.php");
                }
                ?>

                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses; ?>
                    </div>
                <?php
                    header("refresh: 2;url=index.php"); // homepage
                }
                ?>
                
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">E-mail</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?php echo $email; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="passwrd" class="form-label">Password</label>
                        <input type="password" class="form-control" id="passwrd" name="passwrd" value="<?php echo $passwrd; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="roles" class="form-label">Status Anggota</label>
                        <select class="form-control" name="roles" id="roles">
                            <option value=""> - Pilih Status Anggota - </option>
                            <option value="Dosen" <?php if($roles == 'dosen') echo 'selected'?>>Dosen</option>
                            <option value="Mahasiswa" <?php if($roles == 'mahasiswa') echo 'selected'?>>Mahasiswa</option>
                        </select>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary rounded-3"/>
                    </div>
                </form>
            </div>

            <div class="card-footer mx-2 border-0 bg-white overflow-hidden">
                <div class="row">
                    <div class="col">
                        <p>Already have an account?</p>
                    </div>
                    <div class="col">
                        <a href="index.php" class="card-link float-end text-decoration-none">Log In</a>
                    </div>
                </div>
            </div>

        </div>
    </div>

</body>
</html>