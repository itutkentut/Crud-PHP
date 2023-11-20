<html>
<head>
    <link rel="stylesheet" href="style.css">
    <link href='https://fonts.googleapis.com/css?family=Ubuntu' rel='stylesheet'>
</head>
<body>
<div class="div-lg">
<table>
<tr>
<td class="td-img"></td>
<td class="container-lg">
<?php
session_start();

$link = mysqli_connect("localhost", "root", "dita1403", "db_dita");

if (isset($_POST['login'])) {
    $_usr = trim($_POST['user']);
    $_pas = trim($_POST['pass']);

    if ($_usr == '' or $_pas == '') {
        echo "Data tidak boleh kosong";
    } else if ($_usr == 'admin' and $_pas == 'admin') {
        $_SESSION['user'] = "Administrator";
        echo "Login berhasil <br><br>";
        header("Location: index.php");
        exit();
    }
    else{
        $sql = "SELECT count(*) FROM mahasiswa WHERE nama='$_usr' AND nim='$_pas'";
        $result = mysqli_query($link, $sql);
        $data = mysqli_fetch_row($result);
    
        if ($data[0] == 1) {
            $_SESSION['user'] = $_usr;
            echo "Login Berhasil";
            header("Location: index.php");
            exit();
        } else {
            echo "Username atau Password salah";
        }
    }
} 

if (!isset($_SESSION['user'])) {
    echo "
    <h2>Login Session</h2>
    <br>
    <form method='POST' action=''>
    <input type='text' name='user' placeholder='Username'><br><br>
    <input type='password' name='pass' placeholder='Password'><br><br>
    <button name='login' value='Login' id='submit'>Login</button>
</form>";
} 
else {
    echo "<a href='index.php?logout'>Logout</a>";
}
?>
</td>
    </tr>
</table>
</div>
</body>
</html>