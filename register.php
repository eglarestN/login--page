<!DOCTYPE html>
<html>
<head>
    <title>Kullanici Kayit Olma Ekrani</title>
</head>
<body>
    <h2>Kullanici Kayit</h2>
    <form action="register.php" method="post">
        Kullanici Adi: <input type="text" name="username" required><br>
        Parola: <input type="password" name="password" required><br>
        <input type="submit" name="register" value="KAYIT OL">
    </form>
</body>
</html>

<?php

$servername = "localhost";
$username = "mysql_user";
$password = "mysql_password";
$dbname = "radius";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $username = $_POST["username"];
    $password = $_POST["password"]; 

    $sql = "INSERT INTO radcheck (username, attribute, op, password, value) VALUES ('$username', 'Cleartext-Password', ':=', '$password', '$password')";

    if ($conn->query($sql) === true) {
        echo "Kullanici kaydedildi.";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();

?>
