<html>
<head>
    <link rel="stylesheet" href="style.css">
    <link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet'>
    <!-- <script src="https://kit.fontawesome.com/e41fee6478.js" crossorigin="anonymous"></script> 
<td><i class='fa-solid fa-book fa-xl' style='color: #4682a9;'></i></td>
-->
</head>
<body>
<div class="container-mk">
<div class="form">
<?php
$link = mysqli_connect('localhost', 'root', 'dita1403', 'db_dita');

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM matakuliah";

if (isset($_POST['simpan'])) {
    $id = $_POST['idmatkul'];
    $nama = $_POST['namamatkul'];
    $sks = $_POST['sks'];
    if (!empty($id) && !empty($nama) && !empty($sks)) {
        mysqli_query($link, "INSERT INTO matakuliah (id_matkul, nama_matkul, SKS) VALUES ('$id', '$nama', '$sks')");
        echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
        exit();
    }
    
} else if (isset($_POST['edit'])) {
    $id = $_POST['idmatkul'];
    $nama = $_POST['namamatkul'];
    $sks = $_POST['sks'];
    mysqli_query($link, "UPDATE matakuliah SET nama_matkul = '$nama', SKS = '$sks' WHERE id_matkul = '$id'");
    echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
    exit();
} else if (isset($_GET['ubah'])) {
    $id = $_GET['kode'];
    $sql = "SELECT * FROM matakuliah WHERE id_matkul='$id'";
    $result = mysqli_query($link, $sql);
    $data = mysqli_fetch_assoc($result);

    echo "
    <form action='' method='POST'>
    <table>
    <tr><td><input type='text' name='idmatkul' placeholder='id matkul' value='{$data['id_matkul']}'><br><br></td></tr>
    <tr><td><input type='text' name='namamatkul' placeholder='nama matkul' value='{$data['nama_matkul']}'><br><br></td></tr>
    <tr><td><input type='text' name='sks' placeholder='jumlah sks' value='{$data['SKS']}'><br><br></td></tr>
    <tr><td><button name='edit' value='Simpan'>Simpan</button></td>
    </tr>
    </table>
    </form><br>";
} else if (isset($_GET['hapus'])) {
    $id = $_GET['kode'];
    mysqli_query($link, "DELETE FROM matakuliah WHERE id_matkul='$id'");
    echo "<meta http-equiv='refresh' content='0;URL=index.php'>";
    exit();
}
else {
    echo "
    <table>
<form action='' method='post'>
    <tr>
        <td><input type='text' placeholder='id matkul' name='idmatkul'><br><br></td>
    </tr>
    <tr>
        <td><input type='text' placeholder='nama matkul' name='namamatkul'><br><br></td>
    </tr>
    <tr>
        <td><input type='text' placeholder='jumlah sks' name='sks'><br><br></td>
    </tr>
    <tr>
        <td><button name='simpan' value='Simpan'>Simpan</button><br><br></td>
    </tr>
</form>
</table>
    ";
}
?>
</div>

<div class="data">
<?php
session_start();

$counter = 0;

if(isset($_SESSION['user'])){
    $user = isset($_SESSION['user']) ? $_SESSION['user'] : "user";
    if ($user === "Administrator"){
        echo "
        <table cellpadding='15'>
        <tr><td colspan=5>Data Matakuliah</td></tr>
        <tr><td>No</td><td>id matkul</td><td>nama matkul</td><td>jumlah sks</td><td></td></tr>";
        if ($result = mysqli_query($link, $sql)) {
            while ($data = mysqli_fetch_assoc($result)) {
                $counter ++;
                echo
                "<tr>
                <td>$counter</td>
                <td>{$data['id_matkul']}</td>
                <td>{$data['nama_matkul']}</td>
                <td>{$data['SKS']}</td> 
                <td>
                <a href='index.php?crud&ubah&kode={$data['id_matkul']}'>Edit</a>
                <a href='index.php?crud&hapus&kode={$data['id_matkul']}'>Hapus</a>
                </td>
                </tr>";
            }
        }
        "</table>";
    }
    else {
        echo "
        <table cellpadding='15'>
        <tr><td colspan=5>Data Matakuliah</td></tr>
        <tr><td>No</td><td>id matkul</td><td>nama matkul</td><td>jumlah sks</td></tr>";
        if ($result = mysqli_query($link, $sql)) {
            while ($data = mysqli_fetch_assoc($result)) {
                $counter ++;
                echo
                "<tr>
                <td>$counter</td>
                <td>{$data['id_matkul']}</td>
                <td>{$data['nama_matkul']}</td>
                <td>{$data['SKS']}</td>
                </tr>";
            }
        }
        "</table>";
    }
}

mysqli_close($link);
?>
</div>
</div>
</body>
</html>