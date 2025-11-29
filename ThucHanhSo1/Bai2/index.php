<?php
$quiz_file = 'Quiz.txt';

function parse_quiz($filename)
{
    $questions = [];
    if (!file_exists($filename)) {
        return $questions;
    }
    $content = file_get_contents($filename);
    $content = str_replace(["\r\n", "\r"], "\n", $content);

    $current_question_text = '';
    $current_options = [];
    $current_correct_answers = [];

    $lines = explode("\n", $content);

    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line)) continue;

        $line = preg_replace('//', '', $line);
        $line = trim($line);
        if (empty($line)) continue;

        if (strpos($line, 'ANSWER:') === 0) {
            $answer_line = $line;

            preg_match('/[A-Z,\s]+$/', $answer_line, $answer_matches);
            $correct_answer = isset($answer_matches[0]) ? trim($answer_matches[0]) : '';
            $current_correct_answers = explode(',', str_replace(' ', '', $correct_answer));

            if (!empty($current_question_text) && !empty($current_options) && !empty($current_correct_answers)) {
                $questions[] = [
                    'question' => trim($current_question_text),
                    'options' => $current_options,
                    'correct_answers' => $current_correct_answers,
                    'type' => (count($current_correct_answers) > 1) ? 'checkbox' : 'radio'
                ];
            }

            $current_question_text = '';
            $current_options = [];
            $current_correct_answers = [];
            continue;
        }

        if (preg_match('/^([A-Z]\.)\s*(.*)/', $line, $matches)) {
            $current_options[$matches[1]] = $matches[2];
            continue;
        }

        if (empty($current_options)) {
            $current_question_text .= $line . ' ';
        }
    }

    return $questions;
}

$questions = parse_quiz($quiz_file);
$total_questions = count($questions);
$score = 0;
$show_results = false;
$user_answers = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_quiz'])) {
    $show_results = true;
    foreach ($questions as $index => $q) {
        $name = "q_" . $index;
        $user_selection = [];

        if ($q['type'] === 'radio') {
            if (isset($_POST[$name])) {
                $user_selection[] = $_POST[$name];
            }
        } else {
            if (isset($_POST[$name]) && is_array($_POST[$name])) {
                $user_selection = $_POST[$name];
            }
        }

        $user_answers[$index] = $user_selection;

        $user_letters = array_map(function ($key) {
            return rtrim($key, '.');
        }, $user_selection);

        $is_correct = (count($user_letters) === count($q['correct_answers'])) && (empty(array_diff($user_letters, $q['correct_answers'])));

        if ($is_correct) {
            $score++;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài Thi Trắc Nghiệm - CSE485</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .quiz-container {
            max-width: 900px;
            margin-top: 20px;
        }

        .question-card {
            margin-bottom: 20px;
            border: 1px solid #dee2e6;
            border-radius: 0.375rem;
            padding: 20px;
        }

        .correct-answer {
            background-color: #d4edda !important;
            border-color: #c3e6cb !important;
            color: #155724 !important;
        }

        .incorrect-answer {
            background-color: #f8d7da !important;
            border-color: #f5c6cb !important;
            color: #721c24 !important;
        }

        .form-check-label {
            display: block;
        }
    </style>
</head>

<body>
    <div class="container quiz-container">
        <header class="text-center mb-4">
            <h1 class="display-5">Bài Thi Trắc Nghiệm - CSE485</h1>
            <p class="lead">Tổng cộng: <?php echo $total_questions; ?> câu hỏi</p>
            <hr>
        </header>

        <?php if ($show_results): ?>
            <div class="alert alert-success text-center shadow p-3 mb-5 bg-white rounded" role="alert">
                <h2>Kết quả của bạn</h2>
                <h1 class="display-3 text-success"><?php echo $score; ?>/<?php echo $total_questions; ?></h1>
                <p class="lead">Bạn đã trả lời đúng <?php echo $score; ?> câu hỏi.</p>
                <a href="javascript:void(0)" onclick="window.location.reload();" class="btn btn-primary mt-3">Làm lại</a>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <?php foreach ($questions as $index => $q): ?>
                <?php
                $q_number = $index + 1;
                $input_name = "q_" . $index;
                $is_answered = $show_results && isset($user_answers[$index]);

                $card_class = 'question-card shadow-sm';
                if ($show_results) {
                    $user_selection = $user_answers[$index];
                    $user_letters = array_map(function ($key) {
                        return rtrim($key, '.');
                    }, $user_selection);
                    $is_correct_overall = (count($user_letters) === count($q['correct_answers'])) && (empty(array_diff($user_letters, $q['correct_answers'])));
                    $card_class .= $is_correct_overall ? ' border-success' : ' border-danger';
                }
                ?>
                <div class="<?php echo $card_class; ?>">
                    <p class="fw-bold">
                        Câu <?php echo $q_number; ?>: <?php echo htmlspecialchars($q['question']); ?>
                        <?php if ($q['type'] === 'checkbox'): ?>
                            <span class="badge bg-warning text-dark ms-2">Chọn nhiều đáp án</span>
                        <?php endif; ?>
                    </p>

                    <?php foreach ($q['options'] as $key => $option_text): ?>
                        <?php
                        $id = $input_name . "_" . str_replace('.', '', $key);
                        $type = $q['type'];
                        $value = $key;
                        $checked = '';
                        $label_class = 'form-check-label p-2 mb-1 rounded';
                        $letter = rtrim($key, '.');

                        if ($show_results) {
                            $is_correct_option = in_array($letter, $q['correct_answers']);
                            $is_user_selected = in_array($value, $user_answers[$index]);

                            if ($is_correct_option) {
                                $label_class .= ' correct-answer';
                            } elseif ($is_user_selected && !$is_correct_option) {
                                $label_class .= ' incorrect-answer';
                            }

                            $checked = $is_user_selected ? 'checked' : '';
                        }
                        ?>
                        <div class="form-check">
                            <input class="form-check-input" type="<?php echo $type; ?>"
                                name="<?php echo $input_name; ?><?php echo ($type === 'checkbox' ? '[]' : ''); ?>"
                                id="<?php echo $id; ?>" value="<?php echo htmlspecialchars($value); ?>" <?php echo $checked; ?>
                                <?php echo $show_results ? 'disabled' : ''; ?>>
                            <label class="<?php echo $label_class; ?>" for="<?php echo $id; ?>">
                                <?php echo htmlspecialchars($key); ?> <?php echo htmlspecialchars($option_text); ?>
                            </label>
                        </div>
                    <?php endforeach; ?>

                    <?php if ($show_results): ?>
                        <div class="mt-3 p-2 border-top">
                            <span class="fw-bold text-success">Đáp án đúng:</span>
                            <?php echo implode(', ', $q['correct_answers']); ?>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>

            <?php if (!$show_results): ?>
                <div class="text-center my-4">
                    <button type="submit" name="submit_quiz" class="btn btn-success btn-lg shadow">
                        Nộp bài và xem kết quả
                    </button>
                </div>
            <?php endif; ?>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>