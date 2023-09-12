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
$dbhost = 'localhost';
$dbname = 'radius';
$dbuser = 'postgres_user';
$dbpass = 'postgres_password';


$conn = pg_connect("host=$dbhost dbname=$dbname user=$dbuser password=$dbpass");

if (!$conn) {
    die("Veritabanına bağlanırken hata oluştu.");
}

$username = $_POST['username'];
$password = $_POST['password'];

$query = "INSERT INTO radcheck (username,attribute, op, password, value) VALUES ('$username', 'Cleartext-Password', ':=', '$password', '$password')";

$result = pg_query($conn, $query);

if ($result) {
    echo "Kayıt başarıyla tamamlandı.";
} else {
    echo "Kayıt işlemi başarısız: " . pg_last_error($conn);
}

pg_close($conn);
?>
