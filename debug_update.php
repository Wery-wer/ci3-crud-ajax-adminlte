<?php
require_once('system/core/CodeIgniter.php');

echo "<h2>Debug Update User Test</h2>";

try {
    $pdo = new PDO('mysql:host=localhost;dbname=crud_ajax', 'root', '');
    echo "<p style='color: green;'>✓ Database connection: OK</p>";
    
    $stmt = $pdo->query("DESCRIBE users");
    $columns = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "<p>✓ Table 'users' columns: " . implode(', ', $columns) . "</p>";
    
    // Test select user
    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = 1");
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        echo "<p>✓ User found: " . $user['name'] . " (" . $user['username'] . ")</p>";
        
        // Test update
        $stmt = $pdo->prepare("UPDATE users SET name = ?, updated_at = NOW() WHERE id = ?");
        $result = $stmt->execute(['Test Update ' . date('H:i:s'), 1]);
        
        if ($result) {
            echo "<p style='color: green;'>✓ Update test: SUCCESS</p>";
        } else {
            echo "<p style='color: red;'>✗ Update test: FAILED</p>";
            echo "<p>Error: " . print_r($stmt->errorInfo(), true) . "</p>";
        }
    } else {
        echo "<p style='color: red;'>✗ No user found with ID 1</p>";
    }
    
} catch(PDOException $e) {
    echo "<p style='color: red;'>✗ Database error: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<p><strong>Langkah Debug:</strong></p>";
echo "<ol>";
echo "<li>Pastikan database 'crud_ajax' ada dan bisa diakses</li>";
echo "<li>Pastikan tabel 'users' memiliki kolom yang benar</li>";
echo "<li>Cek log CI di application/logs/ setelah test update user</li>";
echo "<li>Cek console browser untuk error JavaScript</li>";
echo "</ol>";
?>
