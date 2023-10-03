<!DOCTYPE html>
<html>
<head>
    <title>QuizWiz</title>
    <link rel="icon" href="assets/img/logo_icon.svg">
    <!-- Adding bootstrap library -->
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.css">
    <script src="assets/bootstrap/js/bootstrap.js"></script>
    <!-- Custom stylesheet -->
    <link rel="stylesheet" href="assets/css/quizWiz.css">
    <!-- added google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500&family=Roboto:wght@100;300;400&display=swap" rel="stylesheet">
</head>
<body>


<?php
include 'config.php';

$showLandingPage = $GLOBALS['SHOW_LANDING_PAGE'];
if ($showLandingPage) {
    echo '';
} else {
    include 'app/models/Category.php';
    include 'app/models/Difficulty.php';
    require_once 'app/services/QuizWizDBService.php';
    require_once 'app/services/OpenTriviaAPIService.php';

    // Database connection parameters
    $host = $GLOBALS['DB_HOST'];
    $port = $GLOBALS['DB_PORT'];
    $dbname = $GLOBALS['DB_NAME'];
    $user = $GLOBALS['DB_USERNAME'];
    $password = $GLOBALS['DB_PASSWORD'];

    $api_base_url = $GLOBALS['API_BASE_URL'];

    $database = new QuizWizDBService($host, $port, $dbname, $user, $password);
    $pdo = $database->getConnection();

    $triviaAPI = new OpenTriviaAPIService($api_base_url, null);
    $category_list = $triviaAPI->getCategories();

    $quiz = $triviaAPI->getQuestions(10, new Category(24, "Politics"), Difficulty::Easy->value);
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
}


?>
</body>
</html>