<html>
<head>
<link rel="stylesheet" href="style.css">
<link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet'>
</head>
<body>
<div class="container-mk">
<div class="form">
<?php
$link = mysqli_connect('localhost', 'root', 'dita1403', 'db_dita');

if (!$link) {
    die("Connection failed: " . mysqli_connect_error());
}

$sql = "SELECT * FROM mahasiswa";

if (isset($_POST['simpan'])) {
    $id = $_POST['nim'];
    $nama = $_POST['nama'];
    if (!empty($id) && !empty($nama)) {
        mysqli_query($link, "INSERT INTO mahasiswa (nim, nama) VALUES ('$id', '$nama')");
        echo "<meta http-equiv='refresh' content='0;URL=index.php?mhs'>";
        exit();
    }
} else if (isset($_POST['edit'])) {
    $id = $_POST['nim'];
    $nama = $_POST['nama'];
    mysqli_query($link, "UPDATE mahasiswa SET nama = '$nama' WHERE nim = '$id'");
    echo "<meta http-equiv='refresh' content='0;URL=index.php?mhs'>";
    exit();
} else if (isset($_GET['ubah'])) {
    $id = $_GET['kode'];
    $sql = "SELECT * FROM mahasiswa WHERE nim='$id'";
    $result = mysqli_query($link, $sql);
    $data = mysqli_fetch_assoc($result);

    echo "
    <form action='' method='POST'>
    <table>
    <tr><td>NIM:</td><td><input type='text' name='nim' placeholder='NIM' value='{$data['nim']}'></td></tr>
    <tr><td>Nama Mahasiswa:</td><td><input type='text' name='nama' placeholder='Nama Mahasiswa' value='{$data['nama']}'></td></tr>
    <tr><td><input type='submit' name='edit' value='Simpan'></td></tr>
    <tr><td><button name='edit' value='Simpan'>Simpan</button</td></tr>
    </table> 
    </form><br>";
} else if (isset($_GET['hapus'])) {
    $id = $_GET['kode'];
    mysqli_query($link, "DELETE FROM mahasiswa WHERE nim='$id'");
    echo "<meta http-equiv='refresh' content='0;URL=index.php?mhs'>";
    exit();
}
else {
    echo "
    <table>
<form action='' method='post'>
    <tr>
        <td><input type='text' name='nim' placeholder='NIM'></td>
    </tr>
    <tr>
        <td><input type='text' name='nama' placeholder='Nama Mahasiswa'></td>
    </tr>
    <tr>
        <td><button name='simpan' value='Simpan'>simpan</button><br><br></td>
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
        <tr><td colspan=4>Data Mahasiswa</td></tr>
        <tr><td>No</td><td>NIM</td><td>Nama Mahasiswa</td><td></td></tr>";
        if ($result = mysqli_query($link, $sql)) {
            while ($data = mysqli_fetch_assoc($result)) {
                $counter++;
                echo
                "<tr>
                <td>$counter</td>
                <td>{$data['nim']}</td>
                <td>{$data['nama']}</td>
                <td>
                <a href='index.php?mhs&ubah&kode={$data['nim']}'>Edit</a>
                <a href='index.php?mhs&hapus&kode={$data['nim']}'>Hapus</a>
                </td>
                </tr>";
            }
        }
        "</table>";
    }
    else {
        echo "
        <table cellpadding='15'>
        <tr><td colspan='3  '>Data Mahasiswa</td></tr>
        <tr><td>No</td><td>NIM</td><td>Nama Mahasiswa</td></tr>";
        if ($result = mysqli_query($link, $sql)) {
            while ($data = mysqli_fetch_assoc($result)) {
                $counter++;
                echo
                "<tr>
                <td>$counter</td>
                <td>{$data['nim']}</td>
                <td>{$data['nama']}</td>
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