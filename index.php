<?php
session_start();

$link = mysqli_connect('localhost', 'root', 'dita1403', 'db_dita');
?>

<html>

<head>
<link rel="stylesheet" href="style.css">
<link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet'>
<title>Mata Kuliah</title>
</head>

<body>
    <?php
    if (isset($_GET['logout'])) {
        unset($_SESSION['user']);
        header("Location: index.php");
    } elseif (isset($_SESSION['user'])) {
        echo "
        <div class='Navbar'>
        <a href='index.php'>Home</a> 
        <a href='index.php?mhs'>Data Mahasiswa</a> 
        <a href='index.php?logout'>Logout</a>
        </div>";
        echo "<p>Selamat datang, " . $_SESSION['user'];
        echo "</p>";
        if (isset($_GET['mhs'])) {
            include "mhs.php";
        } else {
            include "crud.php";
        }
    } else {
        include "login.php";
    }
    ?>
    
</body>

</html>
