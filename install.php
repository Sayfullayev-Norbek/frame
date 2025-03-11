<?php

if (file_exists("config.php")) {
    die("⚠️ Install allaqachon bajarilgan!");
}

echo "🚀 Framework o‘rnatish boshlandi...\n";

// 1. Konfiguratsiya faylini yaratish
$configContent = <<<EOL
<?php
return [
    'dbhost' => 'localhost',
    'dbport' => 3306,
    'dbuser' => 'root',
    'dbpassword' => '',
    'dbname' => 'test_database',
];
EOL;

file_put_contents("config.php", $configContent);
echo "✅ `config.php` yaratildi!\n";

// 2. Ma'lumotlar bazasiga ulanishni tekshirish
require_once "vendor/myframe/Connection.php";
$connection = new Connection();

try {
    $db = $connection->getConnection();
    echo "✅ Ma'lumotlar bazasiga muvaffaqiyatli ulandi!\n";
} catch (Exception $e) {
    die("❌ Xatolik: " . $e->getMessage());
}

// 3. Test jadval yaratish
$tableSQL = "CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;";

$db->exec($tableSQL);
echo "✅ `users` jadvali yaratildi!\n";

// 4. Install statusini saqlash
file_put_contents("installed.lock", "installed");
echo "✅ O‘rnatish muvaffaqiyatli yakunlandi!\n";

// O‘rnatish tugadi
