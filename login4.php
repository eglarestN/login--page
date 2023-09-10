<!DOCTYPE html>
<html>
<head>
    <title>Kablosuz Ağ Girişi</title>
</head>
<body>
    <h2>Kablosuz Ağ Girişi</h2>
    <form action="login4.php" method="post">
        Kullanici Adi: <input type="text" name="username" required><br>
        Şifre: <input type="password" name="password" required><br>
        <input type="submit" name="login" value="Giriş Yap">
    </form>
</body>
</html>

<?php
//bu kisimda bu git reposunda yardim aldim https://github.com/dapphp/radius
use Dapphp\Radius\Radius;

//bu kisimda indirdigim git reposuna ait PATH verdim
require_once '/var/www/html/radius/autoload.php';

$username = $_POST["username"];
$password = $_POST["password"];

$radiusServer = 'localhost';
$radiusSecret = 'testing123';

$client = new Radius();

$client->setServer($radiusServer)
       ->setSecret($radiusSecret);

// Kullanıcı kimlik doğrulaması için Access-Request gönderme işlemi
$authenticated = $client->accessRequest($username, $password);

if ($authenticated == true) {
    // Kullanıcı başarılı bir şekilde kimlik doğrulandı
    echo "Kullanici basarili bir sekilde kimlik dogruladi";
    // Başarılı giriş sonrasında yönlendirilecek URL
    $successUrl = 'http://localhost/login3.php';

    // RADIUS sunucusuna kullanıcıyı oturum sonlandırma bağlantısı için bağlantı parametresi oluşturur
    $mauth = $client->getAuthenticator();
    $logoutUrl = 'https://example.meraki.com/splash/logout/?mauth=' . $mauth;

    // Kullanıcıyı başarılı giriş sayfasına yönlendirir ve oturum sonlandırma bağlantısı ekler
    header("Location: $successUrl?logoutUrl" . urlencode($logoutUrl));
    exit;
} else {
    // Kimlik doğrulama başarısız oldu
    echo sprintf(
        "Kimlik doğrulama başarisiz oldu: %s\n",
        $client->getErrorMessage()
    );
}
?>
