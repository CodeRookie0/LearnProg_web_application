<section class="mb-5 mt-4">
    <form id="answerForm" method="post" action="../pages/check-answer.php">
    <?php
        $counter = 1;
        foreach ($tasks as $task) {
            echo '<div class="card mt-4">';
            echo '<div class="card-body">';
            echo '<div class="card-text">';
            echo '<h4 class="card-title mb-3">'. $task['description'] .'</h4>';

            switch ($task['type']){
                case 1: // Single choice (np. checkbox)
                    $options = explode(';', $task['options']);
                    foreach ($options as $index => $option) {
                        $trimmed_option = trim($option);
                        if (!empty($trimmed_option)) {
                            echo '<div class="form-check mb-3">';
                            echo '<input class="form-check-input" type="radio" name="answer['.$task['id'].']" id="option_' . $counter . '" value="' . $trimmed_option . '"> ';
                            echo '<label class="form-check-label" for="option_' . $counter . '">';
                            echo $trimmed_option;
                            echo '</label>';
                            echo '</div>';
                            $counter++;
                        }
                    }
                    break;
                case 2: // True False
                    echo '<input type="text" maxlength="5" name="answer['.$task['id'].']"></input>';
                    break;
                case 3: // Calculations (np. checkbox)
                    $options = explode(';', $task['options']);
                    foreach ($options as $index => $option) {
                        $trimmed_option = trim($option);
                        if (!empty($trimmed_option)) {
                            echo '<div class="form-check mb-3">';
                            echo '<input class="form-check-input" type="radio" name="answer['.$task['id'].']" id="option_' . $counter . '" value="' . $trimmed_option . '"> ';
                            echo '<label class="form-check-label" for="option_' . $counter . '">';
                            echo $trimmed_option;
                            echo '</label>';
                            echo '</div>';
                            $counter++;
                        }
                    }
                    break;
                case 4: // Multiply
                    echo '<div class="form-group">';
                    $options = explode(';', $task['options']);
                    foreach ($options as $index => $option) {
                        $trimmed_option = trim($option);
                        if (!empty($trimmed_option)) {
                            echo '<div class="form-check mb-3">';
                            echo '<input class="form-check-input" type="checkbox" name="answer['.$task['id'].'][]" id="option_' . $counter . '" value="' . $trimmed_option . '">';
                            echo '<label class="form-check-label" for="option_' . $counter . '">';
                            echo $trimmed_option;
                            echo '</label>';
                            echo '</div>';
                            $counter++;
                        }
                    }
                    echo '</div>';
                    break;
                case 5: // Complete the sentence
                    echo '<textarea maxlength="300" name="answer['.$task['id'].']" class="code-editor" style="resize: none;height: auto;"  rows="7" placeholder="Enter your C++ code here..."></textarea>';
                    break;
                case 6: // Match
                    $options = explode(';', $task['options']);

                    foreach ($options as $index => $option) {
                        $trimmed_option = trim($option);
                        if (!empty($trimmed_option)) {
                            echo '<div class="form-check mb-3">';
                            echo '<input class="form-check-input" type="radio" name="answer['.$task['id'].']" id="option_' . $counter . '" value="' . $trimmed_option . '">';
                            echo '<label class="form-check-label" for="option_' . $counter . '">';
                            echo $trimmed_option;
                            echo '</label>';
                            echo '</div>';
                            $counter++;
                        }
                    }
                    break;
                case 7: // Write the code
                    echo '<textarea maxlength="300" name="answer['.$task['id'].']" class="code-editor" style="resize: none;height: auto;"  rows="7" placeholder="Enter your C++ code here..."></textarea>';
                    break;
                default:
                    break;
            }
            
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
    ?>
    <div class="d-flex justify-content-center">
        <button type="submit" name="submit" form="answerForm" class="btn btn-primary mt-3" style="min-width: 250px;">Submit</button>
    </div>
    </form>
</section>
</div>