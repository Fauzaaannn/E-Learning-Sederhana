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

if ($op == "edit") { // untuk edit data
    $id = $_GET['id'];
    $sql = "select * from data_mahasiswa where id = '$id'";
    $q1 = mysqli_query($conn, $sql);
    $r1 = mysqli_fetch_array($q1);
    $nrp = $r1['nrp'];
    $nama = $r1['nama'];
    $nilai = $r1['nilai'];
    $matkul = $r1['matkul'];

    if ($nrp == '') {
        $error = "Data tidak ditemukan";
    }
}

if (isset($_POST['simpan'])) { // untuk create data
    $nilai = $_POST['nilai'];

    if($nrp && $nama && $nilai && $matkul){
        if ($op == 'edit') { // untuk edit data
            $sql = "UPDATE data_mahasiswa SET nilai = '$nilai' WHERE id = '$id'";
            $q1 = mysqli_query($conn, $sql);

            if ($q1) {
                $sukses = "Data berhasil di update";
            } else {
                $error = "Data gagal di update";
            }
        } else { // untuk insert 
            $sql = "insert into data_mahasiswa(nilai) values('$nilai')";
            $q1 = mysqli_query($conn, $sql);
            if ($q1) {
                $sukses = "berhasil memasukkan data";
            } else {
                $error = "Gagal memasukkan data";
            }
        }
    } else {
        $error = "Silahkan masukkan semua data";
    }
}

if (isset($_GET['download_id'])) {
    $download_id = $_GET['download_id'];
    $query = "SELECT paths content FROM data_mahasiswa WHERE id = '$download_id'";
    $result = mysqli_query($conn, $query) or die('Error, query failed');
    list($name, $type, $size, $content) = mysqli_fetch_array($result);
    header("Content-Disposition: attachment; filename=$name");
    header("Content-length: $size");
    header("Content-type: $type");
    echo $content;
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Mahasiswa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
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
                Beri Nilai
            </div>

            <div class="card-body">
                <?php
                if ($error) {
                ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo $error; ?>
                    </div>
                    
                <?php
                    header("refresh: 2;url=dosen.php");
                }
                ?>

                <?php
                if ($sukses) {
                ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo $sukses; ?>
                    </div>
                <?php
                    header("refresh: 2;url=dosen.php");
                }
                ?>
                
                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="nilai" class="form-label">Nilai</label>
                        <input type="text" class="form-control" id="nilai" name="nilai" value="<?php echo $nilai; ?>">
                    </div>
                    <div class="col-12">
                        <input type="submit" name="simpan" value="Simpan Data" class="btn btn-primary rounded-3"/>
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
                            $sql2 = "SELECT * FROM data_mahasiswa order by id desc";
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
                                    <td scope="row"><?php echo $nrp; ?></td>
                                    <td scope="row"><?php echo $nama; ?></td>
                                    <td scope="row"><?php echo $matkul; ?></td>
                                    <td scope="row">
                                        <a class="btn btn-primary btn-sm" href="dosen.php?download_id=<?php echo $id; ?>">Download</a>
                                    </td>
                                    <td scope="row"><?php echo $nilai; ?></td>

                                    <td scope="row">
                                        <a href="dosen.php?op=edit&id=<?php echo $id; ?>">
                                            <button type="button" class="btn btn-warning btn-sm">Nilai</button>
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