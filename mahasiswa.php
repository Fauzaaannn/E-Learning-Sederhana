<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "project_akhir";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Koneksi Gagal: " . mysqli_connect_error());
}

$nrp = "";
$nama = "";
$matkul = "";
$nilai = "";
$sukses = "";
$error = "";

if(isset($_GET['op'])) {
    $op = $_GET['op'];
} else {
    $op = "";
}

if ($op == "delete") { // untuk delete data
    $id = $_GET['id'];
    $sql = "delete from data_mahasiswa where id = '$id'";
    $q1 = mysqli_query($conn, $sql);
    
    if ($q1) {
        $sukses = "Berhasil hapus data";
    } else {
        $error = "Gagal melakukan delete data";
    }
}

$uploadDir = './file/';
if (isset($_POST['submit'])) {
    $nrp = $_POST['nrp'];
    $nama = $_POST['nama'];
    $matkul = $_POST['matkul'];

    if (isset($_FILES['userfile']) && $_FILES['userfile']['error'] === UPLOAD_ERR_OK) {
        $fileName = $_FILES['userfile']['name'];
        $tmpName = $_FILES['userfile']['tmp_name'];
        $fileSize = $_FILES['userfile']['size'];
        $fileType = $_FILES['userfile']['type'];
        $filePath = $uploadDir . $fileName;
        $result = move_uploaded_file($tmpName, $filePath);

        if ($result) {
            $filePath = addslashes($filePath);
            $query = "INSERT INTO data_mahasiswa (nrp, nama, matkul, paths) VALUES ('$nrp','$nama','$matkul','$filePath')";
            $q1 = mysqli_query($conn, $query);
            if ($q1) {
                $sukses = "Data dan file berhasil diunggah";
            } else {
                $error = "Gagal menyimpan data";
            }
        } else {
            $error = "Error uploading file";
        }
    } else {
        $sql = "INSERT INTO data_mahasiswa (nrp, nama, nilai, matkul) VALUES ('$nrp','$nama','$matkul')";
        $q1 = mysqli_query($conn, $sql);
        if ($q1) {
            $sukses = "Data berhasil disimpan";
        } else {
            $error = "Gagal menyimpan data" . mysqli_error($conn);
        }
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
        body {font-family:Product Sans; background-color: #f7f7f7}
    </style>
</head>
<body>
    <nav class="navbar shadow rounded-bottom-3" style="background-color: #1751a5">
        <div class="container-fluid">
            <a class="navbar-brand text-white mt-1" href="#" style="font-size: 25px">
                <img src="Logo_PENS_putih.png" alt="Logo" width="50" height="50" class="d-inline-block align-text-middle ms-5 me-2">
                E-Learning PENS
            </a>

            <a href="logout2.php" class="me-4">
                <button type="button" class="btn btn-danger rounded-5 shadow">Log out</button>
            </a>
        </div>
    </nav>

    <div>
        <div class="card float-end mx-5 mt-5 rounded-3 shadow border-0 overflow-hidden" style="width: 350px">
            <div class="card-header" style="font-size:20px; background-color: #f3c903;">
                Upload Tugas
            </div>

            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                <?php
                    header("refresh: 2;url=mahasiswa.php");
                }
                ?>
                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses; ?>
                    </div>
                <?php
                    header("refresh: 2;url=mahasiswa.php");
                }
                ?>
                
                <form action="" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="<?php echo $nama; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="nrp" class="form-label">NRP</label>
                        <input type="text" class="form-control" id="nrp" name="nrp" value="<?php echo $nrp; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="matkul" class="form-label">Matakuliah</label>
                        <select class="form-control" name="matkul" id="matkul">
                            <option value=""> - Pilih Matakuliah - </option>
                            <option value="ASD" <?php if($matkul == 'Algoritma Struktur Data') echo 'selected'?>>Algoritma Stuktur Data</option>
                            <option value="WPW" <?php if($matkul == 'Workshop Pemrograman Web') echo 'selected'?>>Workshop Pemrograman Web</option>
                            <option value="PKN" <?php if($matkul == 'Kewarganegaraan') echo 'selected'?>>Kewarganegaraan</option>
                            <option value="OS" <?php if($matkul == 'Sistem Operasi') echo 'selected'?>>Sistem Operasi</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <div class="mb-3">
                            <input type="hidden" name="MAX_FILE_SIZE" value="2000000"/>
                            <label for="userfile" class="form-label">Upload File</label>
                            <input type="file" class="form-control" id="userfile" name="userfile">
                        </div>
                    </div>
                    <div class="col-12">
                        <input type="submit" name="submit" value="Simpan Data" class="btn btn-primary rounded-3"/>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div>
        <div class="card ms-5 mt-5 rounded-3 overflow-hidden shadow border-0">
            <div class="card-header text-white" style="background-color: #1751a5; font-size: 20px">
                Data Tugas Mahasiswa
            </div>
            <div class="card-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">NRP</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Matakuliah</th>
                            <th scope="col">Tugas</th>
                            <th scope="col">Nilai</th>
                            <th scope="col">Option</th>
                        </tr>
                        <tbody>
                            <?php
                            $sql2 = "SELECT * FROM data_mahasiswa ORDER BY id DESC";
                            $q2 = mysqli_query($conn, $sql2);
                            $urut = 1;
                            while($r2 = mysqli_fetch_array($q2)) {
                                $id = $r2['id'];
                                $nrp = $r2['nrp'];
                                $nama = $r2['nama'];
                                $matkul = $r2['matkul'];
                                $nilai = $r2['nilai'];
                                $paths = $r2['paths'];

                                ?>
                                <tr>
                                    <th scope="row"><?php echo $urut++; ?></th>
                                    <td><?php echo $nrp; ?></td>
                                    <td><?php echo $nama; ?></td>
                                    <td><?php echo $matkul; ?></td>
                                    <td><?php echo $paths; ?></td>
                                    <td><?php echo $nilai = isset($_POST['nilai']) ? $_POST['nilai'] : 0;?></td>
                                    <td>
                                        <a href="mahasiswa.php?op=delete&id=<?php echo $id; ?>" onclick="return confirm('Yakin mau delete data?')">
                                            <button type="button" class="btn btn-danger btn-sm">Delete</button>
                                        </a>
                                    </td>
                                </tr>
                                <?php
                            }
                            ?>
                        </tbody>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</body>
</html>
