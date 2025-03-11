<?php

echo "====================================\n";
echo "  Framework o'rnatish jarayoni\n";
echo "====================================\n";

// 1. Foydalanuvchidan bazaga ulanish ma'lumotlarini so‘rash
$dbhost = readline("Ma'lumotlar bazasi serveri (localhost): ");
$dbport = readline("Port (3306): ");
$dbuser = readline("Foydalanuvchi nomi (root): ");
$dbpassword = readline("Parol: ");
$dbname = readline("Bazaning nomi: ");

// Agar foydalanuvchi kiritmasa, standart qiymatlarni qo‘llash
$dbhost = $dbhost ?: "localhost";
$dbport = $dbport ?: 3306;
$dbuser = $dbuser ?: "root";
$dbpassword = $dbpassword ?: "";
$dbname = $dbname ?: "framework_db";

echo "\n📌 Ma'lumotlar bazasi sozlamalari saqlanmoqda...\n";

// 2. Connection.php yaratish
$connectionTemplate = <<<PHP
<?php

use PDO;

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

    public function getConnection()
    {
        return \$this->connection;
    }
}
PHP;

// Connection.php faylini yaratish
file_put_contents("Connection.php", $connectionTemplate);
echo "✅ Connection.php yaratildi!\n";

// 3. Ma'lumotlar bazasini yaratish
try {
    $pdo = new PDO("mysql:host=$dbhost;port=$dbport", $dbuser, $dbpassword, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);

    // Foydalanuvchidan bazani yaratish kerak yoki yo‘qligini so‘rash
    $createDb = readline("Bazani yaratishni hohlaysizmi? (yes/no): ");
    if (strtolower($createDb) === "yes") {
        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
        echo "✅ `$dbname` bazasi yaratildi!\n";
    }

    // Bazaga ulanib, migratsiyalarni bajarish
    $pdo->exec("USE `$dbname`");

    // 4. Jadval yaratish (misol uchun)
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            password VARCHAR(255) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        );
    ");
    echo "✅ `users` jadvali yaratildi!\n";

} catch (PDOException $e) {
    die("❌ Bazani yaratishda xatolik: " . $e->getMessage());
}

echo "\n🎉 O'rnatish jarayoni yakunlandi! Frameworkdan foydalanishingiz mumkin.\n";
