<?php
require_once 'db_connect.php';
function get_quiz_from_db()
{
    global $conn;
    $questions = [];

    try {
        $stmt = $conn->query("SELECT id, question, options, answer, question_type FROM quiz_questions ORDER BY id ASC");
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as $row) {

            $options = [];
            $options_lines = explode("\n", str_replace(["\r\n", "\r"], "\n", $row['options']));

            foreach ($options_lines as $line) {
                $line = trim($line);
                if (empty($line)) continue;

                if (preg_match('/^([A-Z]\.)\s*(.*)/', $line, $matches)) {
                    $key = trim($matches[1]);
                    $text = trim($matches[2]);
                    if (!empty($key) && !empty($text)) {
                        $options[$key] = $text;
                    }
                }
            }

            $correct_answers_str = trim(str_replace(' ', '', $row['answer']));
            $correct_answers_arr = explode(',', $correct_answers_str);

            $type = ($row['question_type'] === 'multiple') ? 'checkbox' : 'radio';

            if (!empty($options) && !empty($correct_answers_arr) && !empty($row['question'])) {
                $questions[] = [
                    'question' => trim($row['question']),
                    'options' => $options,
                    'correct_answers' => $correct_answers_arr,
                    'type' => $type
                ];
            }
        }
    } catch (PDOException $e) {
        die("<div class='alert alert-danger'>Lỗi kết nối hoặc truy vấn CSDL: " . $e->getMessage() . "</div>");
    }

    return $questions;
}

$questions = get_quiz_from_db();
$total_questions = count($questions);
$score = 0;
$show_results = false;
$user_answers = [];
$error_message = '';

if ($total_questions === 0) {
    $error_message = "Không tìm thấy câu hỏi nào trong CSDL. Vui lòng kiểm tra bảng 'quiz_questions' và dữ liệu chèn.";
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_quiz'])) {
    if ($total_questions > 0) {
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
    } else {
        $error_message = "Không có câu hỏi nào để chấm điểm.";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bài Thi Trắc Nghiệm - CSE485</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
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
            cursor: pointer;
        }

        .form-check-input:disabled {
            opacity: 1;
        }
    </style>
</head>

<body>
    <div class="container quiz-container">
        <header class="text-center mb-4">
            <h1 class="display-5 text-primary">Bài Thi Trắc Nghiệm - CSE485</h1>
            <p class="lead">Tổng cộng: <?php echo $total_questions; ?> câu hỏi</p>
            <hr>
        </header>

        <?php if ($error_message): ?>
            <div class="alert alert-danger text-center shadow p-3 mb-5 rounded" role="alert">
                <i class="bi bi-exclamation-triangle-fill"></i> LỖI DỮ LIỆU:
                <?php echo htmlspecialchars($error_message); ?>
            </div>
        <?php endif; ?>

        <?php if ($show_results): ?>
            <div class="alert alert-success text-center shadow p-3 mb-5 bg-white rounded" role="alert">
                <h2>Kết quả của bạn</h2>
                <h1 class="display-3 text-success"><?php echo $score; ?>/<?php echo $total_questions; ?></h1>
                <p class="lead">Bạn đã trả lời đúng <?php echo $score; ?> câu hỏi.</p>
                <a href="javascript:void(0)" onclick="window.location.href = 'bai2_index.php';"
                    class="btn btn-primary mt-3">Làm lại</a>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <?php foreach ($questions as $index => $q): ?>
                <?php
                $q_number = $index + 1;
                $input_name = "q_" . $index;

                $card_class = 'question-card shadow-sm';
                if ($show_results) {
                    $user_selection = isset($user_answers[$index]) ? $user_answers[$index] : [];
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
                                <span class="fw-semibold me-2"><?php echo htmlspecialchars($key); ?></span>
                                <?php echo htmlspecialchars($option_text); ?>
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

            <?php if (!$show_results && $total_questions > 0): ?>
                <div class="text-center my-4">
                    <button type="submit" name="submit_quiz" class="btn btn-success btn-lg shadow">
                        <i class="bi bi-check-circle"></i> Nộp bài và xem kết quả
                    </button>
                </div>
            <?php endif; ?>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>