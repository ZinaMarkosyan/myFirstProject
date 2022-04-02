<?php

include_once '../../connectDB.php';
$db = new Config;
if(isset($_POST['examId'])) {

    $id = $_POST['examId'];
    $row_exam = $db->select("SELECT * FROM exam WHERE id='$id'")->fetch_assoc();

    $data = $db->select("SELECT question.question ,answer.question_id ,answer.id AS answerId, answer.answer,answer.right_answer  From question INNER JOIN
    answer  ON answer.question_id=question.id WHERE question.exam_id='$id' GROUP BY answer.question_id")->fetch_all(true);
    ?>

   <div class="open-form">
        <div class="container">
            <input type="hidden" value = "<?=count($data)?>" class = "counter"> 
            <form action="/admin/action/saveUpdatedExam.php" method = "post" onsubmit = "return false">
                <h1>Edit
                    <input class="examName" name = "examName" value="<?=$row_exam['exam']?>">
                    <input class="updExamId" type="hidden" name = "examId" value="<?=$row_exam['id']?>">
                </h1>
                <div class=" quest-containerB">
                <?php
                $i = 0;
                foreach($data as $question): ?>
                    <div class="quest-blokB">
                        <label for="question"><b>Question</b></label>
                        <input type="text" placeholder="Enter question" name="question[<?=$i?>][]" class="questionB" value="<?=$question['question']?>" >
                         <input type="hidden" name = "questionid[<?=$i?>][]" value = "<?=$question['question_id']?>" class = "questionid"> 
                        <?php $qId = $question['question_id'];
                        $datas =  $db->select("SELECT question.question ,answer.question_id ,answer.id AS answerId, answer.answer,answer.right_answer From question INNER JOIN
                        answer  ON answer.question_id=question.id WHERE question.exam_id='$id' AND answer.question_id='$qId'")->fetch_all(true);
                            ?>
                        <div class="answers-containerB">
                            <?php
                            $k = 0;
                            foreach($datas as $ans):?>
                                <div class="answ-blockB" data-number ="">
                                    <label for="answer"><b>Answer <?=$k+1?></b></label>
                                    <textarea class="answerB" name = "answer[<?=$i?>][]"><?=$ans['answer']?></textarea>
                                 
                                    <input type="hidden" name = "ansid[<?=$i?>][]" class = "ansid" value = "<?=$ans['answerId']?>">
                                    <?php
                                    if ($ans['right_answer'] == '1'):?>
                                        <input  class="currectB" type="checkbox" checked >
                                        <input type="hidden" value = "1" name = "right[<?=$i?>][]" class = "rightor">
                                    <?php else:?>
                                        <input  class="currectB" type="checkbox" >
                                        <input type="hidden" value = "0" name = "right[<?=$i?>][]" class = "rightor">
                                    <?php endif?>
                                    <?php if ($k>0):?>
                                        <button class="btn btn-danger removeAnswerB">Remove</button>
                                    <?php endif?>
                                    <?php $k++?>
                                </div>
                            <?php endforeach?>
                        </div>
                        <p>
                            <button class="addAnswerB">Add answer</button>
                        </p>
                        <p style="text-align: right"> <button type="submit" name="remove-questionB" class="remove-questionB">Remove Question</button></p>
                    </div>
                    <?php $i++?>
                <?php endforeach?>
                </div>
                <div class="action container">
                    <div>
                        <button type="submit" name="add-questionB" class="add-questionB">Add Question</button>
                    </div>
                    <div>
                        <button type="submit" name="save-examB" class="save-examB">Save Exam</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
<?php }?>