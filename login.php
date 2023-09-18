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

//merakiden gelen get parametrelerini ekrana yazdirma.
$baseGrantUrl = $_GET["base_grant_url"];
$userContinueUrl = $_GET["user_continue_url"];
$gatewayId = $_GET["gateway_id"];
$clientIp = $_GET["client_ip"];
$clientMac = $_GET["client_mac"];

echo "base_grant_url: " . urldecode($baseGrantUrl) . "<br>";
echo "user_continue_url: " . urldecode($userContinueUrl) . "<br>";
echo "gateway_id: " . $gatewayId . "<br>";
echo "client_ip: " . $clientIp . "<br>";
echo "client_mac: " . $clientMac . "<br>";

// burada indirdigim git reposunu kullandim
use Dapphp\Radius\Radius;

// bu kisimda indirdiğim git reposuna ait PATH verdim
require_once '/var/www/html/radius/autoload.php';

$username = $_POST["username"];
$password = $_POST["password"];

// URL'den gelen get parametrelerini alan degisken
$logoutParam = $_GET["logoutUrl"];

// Meraki'den gelen get parametresini kontrol etme blogu
if (!empty($logoutParam)) {
    // Get parametresi mevcutsa, oturumu sonlandırma bağlantısını kullan
    echo "Meraki'den gelen get parametresi: $logoutParam";
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
    } else {
        // Kimlik doğrulama başarısız oldu
        echo sprintf(
            "Kimlik doğrulama başarisiz oldu: %s\n",
            $client->getErrorMessage()
        );
    }
}
?>
