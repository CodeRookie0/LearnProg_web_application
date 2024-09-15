<?php
$allCorrect = true;
echo '<div class="content">';
echo '<div class="card col-8 p-3 mt-5 mb-5 mx-auto">';
echo '<h2 class="m-2">Results:</h2>';

if (isset($_SESSION['lesson_id'])) {
    $lesson_id = $_SESSION['lesson_id'];

    include '../data-repositories/lesson-functions.php';
    $tasks = getLessonTasks($lesson_id);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $submittedAnswers = $_POST['answer'];
        $allTasksCompleted = true;

        foreach ($tasks as $task) {
            $taskId = $task['id'];
            if (!isset($submittedAnswers[$taskId])) {
                $allTasksCompleted = false;
                break;
            }
        }

        if (!$allTasksCompleted) {
            echo '<div class="alert alert-warning m-2">';
            echo 'Please complete all tasks before submitting.';
            echo '</div>';
            $allCorrect = false;
        }
        else{
            $counter=1;
            foreach ($submittedAnswers as $taskId => $submittedAnswer) {
                $task = findTaskById($tasks, $taskId);
                if ($task) {
                    $taskType = $task['type'];
                    $taskSolution = $task['solution'];

                    switch ($taskType) {
                        case 1: // Single choice (radio buttons)
                            if ($taskSolution == $submittedAnswer) {
                                echo '<div class="card m-2">';
                                echo '<div class="card-body">';
                                echo '<div class="card-text">';
                                echo '<h4>Task '.$counter.'</h4>';
                                echo '<p>Your answer:<br>' . $submittedAnswer . '</p>';
                                echo '<div class="alert alert-success mb-0">Correct answer</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                $counter++;
                            } else {
                                echo '<div class="card m-2">';
                                echo '<div class="card-body">';
                                echo '<div class="card-text">';
                                echo '<h4>Task '.$counter.'</h4>';
                                echo '<p>Your answer: <br>' . $submittedAnswer . '</p>';
                                echo '<div class="alert alert-danger mb-0">Wrong answer</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                $counter++;
                                $allCorrect = false;
                            }
                            break;
                        case 2: // True False
                            if (strtolower($taskSolution) == strtolower($submittedAnswer)) {
                                echo '<div class="card m-2">';
                                echo '<div class="card-body">';
                                echo '<div class="card-text">';
                                echo '<h4>Task '.$counter.'</h4>';
                                echo '<p>Your answer: <br>' . $submittedAnswer . '</p>';
                                echo '<div class="alert alert-success mb-0">Correct answer</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                $counter++;
                            } else {
                                echo '<div class="card m-2">';
                                echo '<div class="card-body">';
                                echo '<div class="card-text">';
                                echo '<h4>Task '.$counter.'</h4>';
                                echo '<p>Your answer: <br>' . $submittedAnswer . '</p>';
                                echo '<div class="alert alert-danger mb-0">Wrong answer</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                $counter++;
                                $allCorrect = false;
                            }
                            break;
                        case 3: // Calculations (radio buttons)
                            if ($taskSolution == $submittedAnswer) {
                                echo '<div class="card m-2">';
                                echo '<div class="card-body">';
                                echo '<div class="card-text">';
                                echo '<h4>Task '.$counter.'</h4>';
                                echo '<p>Your answer:<br>' . $submittedAnswer . '</p>';
                                echo '<div class="alert alert-success mb-0">Correct answer</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                $counter++;
                            } else {
                                echo '<div class="card m-2">';
                                echo '<div class="card-body">';
                                echo '<div class="card-text">';
                                echo '<h4>Task '.$counter.'</h4>';
                                echo '<p>Your answer: <br>' . $submittedAnswer . '</p>';
                                echo '<div class="alert alert-danger mb-0">Wrong answer</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                $counter++;
                                $allCorrect = false;
                            }
                            break;
                        case 4: // Multiple choice (checkboxes)
                            $selectedOptions = isset($submittedAnswer) ? $submittedAnswer : [];
                            sort($selectedOptions);
                            $correctOptions = explode(', ', $taskSolution);
                            sort($correctOptions);
                            if ($selectedOptions === $correctOptions) {
                                echo '<div class="card m-2">';
                                echo '<div class="card-body">';
                                echo '<div class="card-text">';
                                echo '<h4>Task '.$counter.'</h4>';
                                echo '<p>Your answer: <br>' . implode(', ', array_map('htmlspecialchars', $selectedOptions)) . '</p>';
                                echo '<div class="alert alert-success mb-0">Correct answer</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                            } else {
                                echo '<div class="card m-2">';
                                echo '<div class="card-body">';
                                echo '<div class="card-text">';
                                echo '<h4>Task '.$counter.'</h4>';
                                echo '<p>Your answer: <br>' . implode(', ', array_map('htmlspecialchars', $selectedOptions)) . '</p>';
                                echo '<div class="alert alert-danger mb-0">Wrong answer</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                $allCorrect = false;
                            }
                            $counter++;
                            break;
                        case 5: // Complete the sentence (textarea)
                            if (strtolower($taskSolution) == strtolower($submittedAnswer)) {
                                echo '<div class="card m-2">';
                                echo '<div class="card-body">';
                                echo '<div class="card-text">';
                                echo '<h4>Task '.$counter.'</h4>';
                                echo '<p>Your answer: <br>' . $submittedAnswer . '</p>';
                                echo '<div class="alert alert-success mb-0">Correct answer</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                $counter++;
                            } else {
                                echo '<div class="card m-2">';
                                echo '<div class="card-body">';
                                echo '<div class="card-text">';
                                echo '<h4>Task '.$counter.'</h4>';
                                echo '<p>Your answer: <br>' . $submittedAnswer . '</p>';
                                echo '<div class="alert alert-danger mb-0">Wrong answer</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                $counter++;
                                $allCorrect = false;
                            }
                            break;
                        case 6: // Match (radio buttons)
                            if ($taskSolution == $submittedAnswer) {
                                echo '<div class="card m-2">';
                                echo '<div class="card-body">';
                                echo '<div class="card-text">';
                                echo '<h4>Task '.$counter.'</h4>';
                                echo '<p>Your answer: <br>' . $submittedAnswer . '</p>';
                                echo '<div class="alert alert-success mb-0">Correct answer</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                $counter++;
                            } else {
                                echo '<div class="card m-2">';
                                echo '<div class="card-body">';
                                echo '<div class="card-text">';
                                echo '<h4>Task '.$counter.'</h4>';
                                echo '<p>Your answer: <br>' . $submittedAnswer . '</p>';
                                echo '<div class="alert alert-danger mb-0">Wrong answer</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                $counter++;
                                $allCorrect = false;
                            }
                            break;
                        case 7: // Write the code (textarea)
                            if (compareCode($submittedAnswer, $taskSolution)) {
                                echo '<div class="card m-2">';
                                echo '<div class="card-body">';
                                echo '<div class="card-text">';
                                echo '<h4>Task '.$counter.'</h4>';
                                echo '<p>Your answer: <br><pre><strong>' . htmlspecialchars($submittedAnswer) . '</strong></pre></p>';
                                echo '<div class="alert alert-success mb-0">Correct answer</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                $counter++;
                            } else {
                                echo '<div class="card m-2">';
                                echo '<div class="card-body">';
                                echo '<div class="card-text">';
                                echo '<h4>Task '.$counter.'</h4>';
                                echo '<p>Your answer: <br><pre>' . htmlspecialchars($submittedAnswer) . '</pre></p>';
                                echo '<div class="alert alert-danger mb-0">Wrong answer</div>';
                                echo '</div>';
                                echo '</div>';
                                echo '</div>';
                                $counter++;
                                $allCorrect = false;
                            }
                            break;
                        default:
                            break;
                    }
                } else {
                    echo '<div class="card m-2">';
                    echo '<div class="card-body">';
                    echo '<div class="card-text">';
                    echo '<p class="text-danger">Error: Task not found</p>';
                    echo '</div>';
                    echo '</div>';
                    echo '</div>';
                    $allCorrect = false;
                }
            }
        }

    if ($allCorrect) {
        $buttonText = "Finish Lesson!";
        $buttonHref="lesson-completion.php";
    } else {
        $buttonText = "Try Again!";
        $buttonHref="javascript:history.go(-1)";
    }
    
    echo '<div class="d-flex justify-content-center">';
    echo '<a href="'.$buttonHref.'" class="btn btn-primary m-2" style="min-width: 250px;">'.$buttonText.'</a>';
    echo '</div>';
    echo '</div>';
    echo '</div>';
    } else {
        echo "Invalid request";
        $allCorrect = false;
    }
    $conn->close();
} else {
    echo "lesson_id not set in session.";
    $allCorrect = false;
}

function findTaskById($tasks, $taskId) {
    foreach ($tasks as $task) {
        if ($task['id'] == $taskId) {
            return $task;
        }
    }
    return null;
}

function tokenizeCode($code) {
    $code = preg_replace('/\s+/', ' ', $code);
    $code = preg_replace('/\s*([{}()[\];,<>+\-*\/%&|^!=?])\s*/', '$1', $code);
    $tokens = preg_split('/([{}()[\];,<>+\-*\/%&|^!=?\s]+)/', $code, -1, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);
    
    $tokens = array_filter($tokens, function($token) {
        return trim($token) !== '';
    });

    return $tokens;
}

function compareCode($userInput, $expectedCode) {
    $userTokens = tokenizeCode($userInput);
    $expectedTokens = tokenizeCode($expectedCode);

    if (count($userTokens) !== count($expectedTokens)) {
        return false;
    }

    for ($i = 0; $i < count($userTokens); $i++) {
        if ($userTokens[$i] !== $expectedTokens[$i]) {
            return false;
        }
    }

    return true;
}
?>