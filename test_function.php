<?php
define('BASEPATH', TRUE);
define('ENVIRONMENT', 'development');

$_SESSION = array(
    'name' => 'Test User',
    'username' => 'testuser',
    'role' => 'admin',
    'is_logged_in' => true
);

include 'application/helpers/auth_helper.php';

if (!function_exists('get_instance')) {
    function &get_instance() {
        static $CI;
        if (!isset($CI)) {
            $CI = new stdClass();
            $CI->session = new MockSession();
        }
        return $CI;
    }
}

class MockSession {
    public function userdata($key) {
        $data = array(
            'name' => 'Test User',
            'username' => 'testuser', 
            'role' => 'admin',
            'is_logged_in' => true
        );
        return isset($data[$key]) ? $data[$key] : null;
    }
}

echo "<h2>🧪 Test Auth Helper Functions</h2>";

try {
    echo "<p>✅ get_user_name(): " . get_user_name() . "</p>";
    echo "<p>✅ get_username(): " . get_username() . "</p>";
    echo "<p>✅ get_user_role(): " . get_user_role() . "</p>";
    echo "<p>✅ Functions working correctly!</p>";
} catch (Exception $e) {
    echo "<p>❌ Error: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<p><strong>If this works, the problem is elsewhere!</strong></p>";
?>
