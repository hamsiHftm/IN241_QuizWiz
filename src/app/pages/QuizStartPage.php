<?php
    session_start(); // Add this line to enable session usage
    require_once '../../config.php';
    require_once '../models/Difficulty.php';
    require_once '../models/QuestionType.php';
    require_once '../services/OpenTriviaAPIService.php';

$api_base_url = $GLOBALS['API_BASE_URL'];
$triviaAPI = new OpenTriviaAPIService($api_base_url, null); # TODO make instanz Varaible


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        $selectedCategory = $_POST['categorySel'];
        $selectedDifficulty = $_POST['difficulty'];
        $selectedType = $_POST['type'];

        $quiz = $triviaAPI->getQuestions($GLOBALS['NR_OF_QUESTIONS'], $selectedCategory, $selectedDifficulty, $selectedType);
        if ($quiz) {
            $_SESSION['quiz'] = $quiz;
            header("Location: QuizQuestionPage.php?nr=1");
        }
        exit;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <?php require_once '../components/HeadComponent.php' ?>
    <link rel="stylesheet" href="../../assets/css/QuizQuestionsFormsSytle.css">

</head>
<body>
    <?php require_once '../components/HeaderComponent.php'; ?>

    <div class="container-sm">
        <div class="qw-content">
        <h1>Create Quiz</h1>
        <br/>
        <form method="POST">
            <div class="mb-3">
                <div class="qw-label">Category</div>
            <?php
            $categories = null;
            if (isset($_SESSION['categories'])) {
                $categories = $_SESSION['categories'];
            } else {
                $categories = $triviaAPI->getCategories();
                $_SESSION['categories'] = $categories;
            }
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
    <?php require_once '../components/FooterComponent.php'; ?>
</body>
</html>
