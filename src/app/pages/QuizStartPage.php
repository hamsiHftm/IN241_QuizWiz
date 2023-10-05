<?php
require_once '../controllers/APIController.php';
require_once '../models/Difficulty.php';
require_once '../models/QuestionType.php';

// Start the session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// initiation ApiController class
$apiController = new APIController();

// getting categories
$categories = $apiController->getCategories();
if (empty($categories)) {
    echo "<script>window.location.href = 'ErrorPage.php';</script>";
}

// quiz start button action
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['submit'])) {
        $selectedCategoryValue = explode('-', $_POST['categorySel']);
        $selectedCategoryID = (int)$selectedCategoryValue[0];
        $selectedCategoryName = trim($selectedCategoryValue[1]);
        $selectedDifficulty = $_POST['difficulty'];
        $selectedType = $_POST['type'];

        $isGenerated = $apiController->generateQuizAndQuestions($selectedCategoryID, $selectedCategoryName, $selectedDifficulty, $selectedType);
        if ($isGenerated) {
            header("Location: QuizQuestionPage.php?nr=1&score=0");
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
        <h1 class="text-center">Create Quiz</h1>
        <hr class="my-4">
        <div class="text-center alert alert-secondary" style="font-size:small">
            <p>
                Select Your Game Settings: Choose Your Topic, Select Difficulty Level, Pick Question Type
            </p>
            <p>
                Note: Some categories may have limited questions and may not be available. Default is 10 questions per
                game. In the future, you will be able to choose the number of questions
            </p>
        </div>
        <br/>
        <div class="d-flex justify-content-center">
            <div class="qw-quiz-start-form-layout">
                <form method="POST">
                    <div class="mb-3">
                        <div class="qw-label">Category</div>
                        <?php
                        if (!empty($categories)) {
                            ?>
                            <select name="categorySel" id="categorySel" class="form-select qw-form-select">
                                <?php foreach ($categories as $category) { ?>
                                    <option value="<?php echo $category->getId() . '-' . $category->getName(); ?>">
                                        <?php echo $category->getName(); ?>
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
                                <input class="qw-form-check form-check-input" type="radio" name="difficulty"
                                       value="<?php echo $value->value; ?>" <?php if ($value === $firstDifficulty) echo 'checked'; ?>>
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
                                <input class="qw-form-check form-check-input" type="radio" name="type"
                                       value="<?php echo $value->value; ?>" <?php if ($value === $firstQuestionType) echo 'checked'; ?>>
                                <?php echo ucfirst($value->name); ?>
                            </label>
                            <br>
                        <?php } ?>
                    </div>
                    <br>
                    <div class="d-flex justify-content-center">
                        <input type="submit" name="submit" value="Start" class="qw-red-button">
                    </div>
                </form>
            </div>
        </div>
        <br>

    </div>
</div>
<?php require_once '../components/FooterComponent.php'; ?>
</body>
</html>
