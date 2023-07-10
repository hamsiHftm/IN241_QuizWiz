<?php
include 'config.php';
require_once 'app/classes/QuizWizDB.php';
require_once 'app/classes/OpenTriviaAPI.php';

// Database connection parameters
$host = $GLOBALS['DB_HOST'];
$port = $GLOBALS['DB_PORT'];
$dbname = $GLOBALS['DB_NAME'];
$user = $GLOBALS['DB_USERNAME'];
$password = $GLOBALS['DB_PASSWORD'];

$api_base_url = $GLOBALS['API_BASE_URL'];

$database = new QuizWizDB($host, $port, $dbname, $user, $password);
$pdo = $database->getConnection();

$triviaAPI = new OpenTriviaAPI($api_base_url);
$category_list = $triviaAPI->getCategories();
foreach ($category_list as $c) {
    echo "<tr>";
    echo "<td>" . $c["id"] . "</td>";
    echo "<td>" . $c["name"] . "</td>";
    echo "</tr>";
}

echo $category_list;


// Retrieve data from the "user" table
try {
    $stmt = $pdo->query("SELECT * FROM \"player\"");
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error retrieving data from table: " . $e->getMessage());
}

// Display the data
echo "<h1>User List</h1>";
echo "<table>";
echo "<tr><th>Name</th><th>Last Name</th></tr>";

foreach ($users as $user) {
    echo "<tr>";
    echo "<td>" . $user['name'] . "</td>";
    echo "<td>" . $user['last_name'] . "</td>";
    echo "</tr>";
}

echo "</table>";

?>
