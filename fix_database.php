<!DOCTYPE html>
<html>
<head>
    <title>Fix Database - Add updated_at Column</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 40px; }
        .success { color: green; }
        .error { color: red; }
        .sql { background: #f5f5f5; padding: 10px; border-left: 4px solid #ccc; }
    </style>
</head>
<body>
    <h2>🔧 Fix Database - Add updated_at Column</h2>
    
    <?php
    try {
        $pdo = new PDO('mysql:host=localhost;dbname=crud_ajax', 'root', '');
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        echo "<p class='success'>✓ Database connection: OK</p>";
        
        $stmt = $pdo->query("SHOW COLUMNS FROM users LIKE 'updated_at'");
        $column_exists = $stmt->rowCount() > 0;
        
        if (!$column_exists) {
            echo "<p>❌ Kolom 'updated_at' tidak ditemukan. Menambahkan...</p>";
            
            $sql = "ALTER TABLE users ADD COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP";
            $pdo->exec($sql);
            
            echo "<p class='success'>✅ Kolom 'updated_at' berhasil ditambahkan!</p>";
            
            $sql2 = "UPDATE users SET updated_at = CURRENT_TIMESTAMP WHERE updated_at IS NULL";
            $pdo->exec($sql2);
            
            echo "<p class='success'>✅ Data existing records berhasil diupdate!</p>";
        } else {
            echo "<p class='success'>✅ Kolom 'updated_at' sudah ada!</p>";
        }
        
        echo "<h3>📋 Struktur Tabel Users Saat Ini:</h3>";
        $stmt = $pdo->query("DESCRIBE users");
        echo "<table border='1' cellpadding='5' style='border-collapse: collapse;'>";
        echo "<tr><th>Field</th><th>Type</th><th>Null</th><th>Key</th><th>Default</th><th>Extra</th></tr>";
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['Field']}</td>";
            echo "<td>{$row['Type']}</td>";
            echo "<td>{$row['Null']}</td>";
            echo "<td>{$row['Key']}</td>";
            echo "<td>{$row['Default']}</td>";
            echo "<td>{$row['Extra']}</td>";
            echo "</tr>";
        }
        echo "</table>";
        
        echo "<hr>";
        echo "<h3>🎯 Test Update User Sekarang</h3>";
        echo "<p>Kembali ke halaman User Registration dan coba update user lagi!</p>";
        echo "<p><a href='user_registration' target='_blank'>➡️ Buka User Registration</a></p>";
        
    } catch(PDOException $e) {
        echo "<p class='error'>❌ Database error: " . $e->getMessage() . "</p>";
    }
    ?>
</body>
</html>
