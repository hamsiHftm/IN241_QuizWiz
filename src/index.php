<?php
include 'config.php';
include 'app/models/Category.php';
include 'app/models/Difficulty.php';
require_once 'app/services/QuizWizDB.php';
require_once 'app/services/OpenTriviaAPI.php';

// Database connection parameters
$host = $GLOBALS['DB_HOST'];
$port = $GLOBALS['DB_PORT'];
$dbname = $GLOBALS['DB_NAME'];
$user = $GLOBALS['DB_USERNAME'];
$password = $GLOBALS['DB_PASSWORD'];

$api_base_url = $GLOBALS['API_BASE_URL'];

$database = new QuizWizDB($host, $port, $dbname, $user, $password);
$pdo = $database->getConnection();

$triviaAPI = new OpenTriviaAPI($api_base_url, null);
$category_list = $triviaAPI->getCategories();

$quiz = $triviaAPI->getQuestions(10, new Category(24, "Politics"), Difficulty::EASY->value);
foreach ($quiz->getQuestions() as $question) {
    echo "jeei";
    echo $question->getQuestionText();
}

//
//// Retrieve data from the "user" table
//try {
//    $stmt = $pdo->query("SELECT * FROM \"player\"");
//    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
//} catch (PDOException $e) {
//    die("Error retrieving data from table: " . $e->getMessage());
//}
//
//// Display the data
//echo "<h1>User List</h1>";
//echo "<table>";
//echo "<tr><th>Name</th><th>Last Name</th></tr>";
//
//foreach ($users as $user) {
//    echo "<tr>";
//    echo "<td>" . $user['name'] . "</td>";
//    echo "<td>" . $user['last_name'] . "</td>";
//    echo "</tr>";
//}
//
//echo "</table>";

?>
