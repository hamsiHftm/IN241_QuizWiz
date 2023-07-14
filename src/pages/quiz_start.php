<?php
    include '../config.php';
    require_once '../app/models/Difficulty.php';
    require_once '../app/models/QuestionType.php';
    require_once '../app/services/OpenTriviaAPI.php';

$api_base_url = $GLOBALS['API_BASE_URL'];
$triviaAPI = new OpenTriviaAPI($api_base_url, null); # TODO make instanz Varaible
?>

<!DOCTYPE html>
<html>
<head>
    <title>QuizWiz</title>
    <link rel="icon" href="../app/assets/img/logo_icon.svg">
    <!-- Adding bootstrap library -->
    <link rel="stylesheet" href="../app/assets/bootstrap/css/bootstrap.css">
    <script src="../app/assets/bootstrap/js/bootstrap.js"></script>
    <!-- Custom stylesheet -->
    <link rel="stylesheet" href="../app/assets/css/quizWiz.css">
    <!-- added google fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@100;200;300;400;500&family=Roboto:wght@100;300;400&display=swap" rel="stylesheet">
</head>
<body>
    <?php include '../app/components/header.php'; ?>
    <div class="container-sm">
        <div class="qw-content">
        <h1>Create Quiz</h1>
        <br/>
        <form method="POST">
            <div class="mb-3">
                <div class="qw-label">Category</div>
            <?php
            $categories = $triviaAPI->getCategories(); // Assuming $api is an instance of the OpenTriviaAPI class

            if (!empty($categories)) {
                ?>
                <select name="categorySel" id="categorySel" class="form-select qw-form-select">
                    <?php foreach ($categories as $category) { ?>
                        <option value="<?php echo $category['id']; ?>">
                            <?php echo $category['name']; ?>
                        </option>
                    <?php } ?>
                </select>
            <?php } else { ?>
                <p>No categories found.</p>
            <?php } ?>
            </div>

            <div class="mb-3">
            <div class="qw-label">Difficulty</div>
            <?php
                $difficultyValues = array_values(Difficulty::values());
                $firstDifficulty = reset($difficultyValues);
                foreach ($difficultyValues as $value) { ?>
                <label class="form-check-label">
                    <input class="qw-form-check form-check-input" type="radio" name="difficulty" value="<?php echo $value->value; ?>" <?php if ($value === $firstDifficulty) echo 'checked'; ?>>
                    <?php echo ucfirst($value->name); ?>
                </label>
                <br>
            <?php } ?>
            </div>
            <div class="mb-3">
            <div class="qw-label">Question Type</div>
            <?php
                $questionTypes = array_values(QuestionType::values());
                $firstQuestionType = reset($questionTypes);
                foreach ($questionTypes as $value) { ?>
                <label class="form-check-label">
                    <input class="qw-form-check form-check-input" type="radio" name="type" value="<?php echo $value->value; ?>" <?php if ($value === $firstQuestionType) echo 'checked'; ?>>
                    <?php echo ucfirst($value->name); ?>
                </label>
                <br>
            <?php } ?>
            </div>
            <br>
            <input type="submit" name="submit" value="Start" class="qw-red-button">
        </form>
        </div>
    </div>
    <?php include '../app/components/footer.php'; ?>
</body>
</html>
<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        # TODO loader
        $selectedCategory = $_POST['categorySel'];
        $selectedDifficulty = $_POST['difficulty'];
        $selectedType = $_POST['type'];

        $quiz = $triviaAPI->getQuestions($GLOBALS['NR_OF_QUESTIONS'], $selectedCategory, $selectedDifficulty, $selectedType);
        if ($quiz) {
            error_log((string)$quiz->getQuestions());
        }

        // Perform further processing or redirect as needed
    }
}

