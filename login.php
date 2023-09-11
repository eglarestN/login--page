<!DOCTYPE html>
<html>
<head>
    <title>Kablosuz Ağ Girişi</title>
</head>
<body>
    <h2>Kablosuz Ağ Girişi</h2>
    <form action="login6.php" method="post">
        Kullanici Adi: <input type="text" name="username" required><br>
        Şifre: <input type="password" name="password" required><br>
        <input type="submit" name="login" value="Giriş Yap">
    </form>
</body>
</html>

<?php
use Dapphp\Radius\Radius;

require_once '/var/www/html/radius/autoload.php';

$username = $_POST["username"];
$password = $_POST["password"];

// URL'den gelen get parametrelerini al
$logoutParam = $_GET["logoutUrl"];

// Meraki'den gelen get parametresini kontrol et
if (!empty($logoutParam)) {
    // Get parametresi mevcutsa, oturumu sonlandırma bağlantısını kullan
    echo "Meraki'den gelen get parametresi: $logoutParam";
    // Burada yapılacak işlemi ekleyebilirsiniz, örneğin oturumu sonlandırma veya başka bir işlem.
} else {
    $radiusServer = 'localhost';
    $radiusSecret = 'testing123';

    $client = new Radius();

    $client->setServer($radiusServer)
           ->setSecret($radiusSecret);

    // Kullanıcı kimlik doğrulaması için Access-Request gönderme işlemi
    $authenticated = $client->accessRequest($username, $password);

    if ($authenticated == true) {
        // Kullanıcı başarılı bir şekilde kimlik doğrulandı
        echo "Kullanici başarili bir şekilde kimlik doğruladi";
        // Meraki'den gelen get parametresini handle etmek için burada ek işlemleri yapabilirsiniz.
    } else {
        // Kimlik doğrulama başarısız oldu
        echo sprintf(
            "Kimlik doğrulama başarisiz oldu: %s\n",
            $client->getErrorMessage()
        );
    }
}
?>