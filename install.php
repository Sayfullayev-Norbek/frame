<?php

$connectionFile = "vendor/myframe/Connection.php";

if (file_exists($connectionFile)) {
    die("✅ Connection.php bor!\n");
}

echo "====================================\n";
echo "  Framework o'rnatish jarayoni\n";
echo "====================================\n";

$dbhost = readline("Ma'lumotlar bazasi serveri (localhost): ");
$dbport = readline("Port (3306): ");
$dbuser = readline("Foydalanuvchi nomi (root): ");
$dbpassword = readline("Parol: ");
$dbname = readline("Bazaning nomi: ");

$dbhost = $dbhost ?: "localhost";
$dbport = $dbport ?: 3306;
$dbuser = $dbuser ?: "root";
$dbpassword = $dbpassword ?: "";
$dbname = $dbname ?: "framework_db";

echo "\n📌 Ma'lumotlar bazasi sozlamalari saqlanmoqda...\n";

$connectionTemplate = <<<PHP
<?php

namespace vendor\myframe;

use PDO;
use PDOException;

class Connection
{
    private \$connection;

    public function __construct()
    {
        \$dbhost = "$dbhost";
        \$dbport = $dbport;
        \$dbuser = "$dbuser";
        \$dbpassword = "$dbpassword";
        \$dbname = "$dbname";

        try {
            \$dsn = "mysql:host=\$dbhost;port=\$dbport;dbname=\$dbname;charset=utf8";
            \$this->connection = new PDO(\$dsn, \$dbuser, \$dbpassword, [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]);
        } catch (PDOException \$e) {
            die("❌ Ma'lumotlar bazasiga ulanishda xatolik: " . \$e->getMessage());
        }
    }

    public function getConnection(): PDO
    {
        return \$this->connection;
    }
}
PHP;

$dir = "vendor/myframe";

if (!is_dir("vendor/myframe")) {
    mkdir("vendor/myframe", 0777, true);
}

$result = file_put_contents("$dir/Connection.php", $connectionTemplate);

if ($result === false) {
    die("❌ `Connection.php` faylini yaratishda xatolik yuz berdi!");
}

echo "✅ Connection.php yaratildi!\n";


try {
    $pdo = new PDO("mysql:host=$dbhost;port=$dbport", $dbuser, $dbpassword, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    $createDb = readline("Bazani yaratishni hohlaysizmi? (yes/no): ");
    if (strtolower($createDb) === "yes") {
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
        echo "✅ `$dbname` bazasi yaratildi!\n";
    }

//    $pdo->exec("USE `$dbname`");
//
//    $pdo->exec("
//        CREATE TABLE IF NOT EXISTS users (
//            id INT AUTO_INCREMENT PRIMARY KEY,
//            name VARCHAR(255) NOT NULL,
//            email VARCHAR(255) NOT NULL UNIQUE,
//            password VARCHAR(255) NOT NULL,
//            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
//        );
//    ");
//    echo "✅ `users` jadvali yaratildi!\n";

} catch (PDOException $e) {
    die("❌ Bazani yaratishda xatolik: " . $e->getMessage());
}

echo "\n🎉 O'rnatish jarayoni yakunlandi! Frameworkdan foydalanishingiz mumkin.\n";
