<?php
include_once '../../connectDB.php';
$db = new Config;
if(isset($_POST['questionId'])) {
    $questionId = $_POST['questionId'];
  
    $data = $db->select("SELECT question.question AS question,answer.question_id AS question_id,answer.id AS answerId, answer.answer AS answer,answer.right_answer AS right_answer From question INNER JOIN
     answer  ON answer.question_id=question.id WHERE question.id='$questionId'")->fetch_all(true);?>
        <div class="quest-block">
            <?php
                $i=0;
                foreach($data as $row):?>
                
                    <?php if ($i == 0):?>
                        <h2 class="quiz_text"><?=$row['question']?></h2><input type="hidden" class="hiddenQuestId" value="<?=$row['question_id']?>"><ul>
                    <?php endif?>
                    <?php $i++;?>
                    
                        
                        <li>
                            <p class="success<?=$row['answerId']?> ans-item"  data-id = "<?=$dat['answerId']?>"><?=$row['answer']?>
                            <input type="hidden" value="<?=$row['right_answer']?>">
                            </p>
                        </li>
                <?php endforeach?>
                </ul>
            </div>
<?php }?>
<?php
if(isset($_POST['correct_answer'])){

    $questionId = $_POST['correct_answer'];
  
    $data = $db->select("SELECT question.question,answer.question_id ,answer.id AS answerId, answer.answer,answer.right_answer  From question INNER JOIN
    answer  ON answer.question_id=question.id WHERE question.id='$questionId'")->fetch_all(true);?>
    <div class="quest-block">
  <?php
    $i=0;
    foreach($data as $row):?>
        <?php if ($i == 0) :?>
            <h2 class="quiz_text"><?=$row['question']?></h2><input type="hidden" class="hiddenQuestId" value="<?= $row['question_id']?>">
            <ul>
        <?php endif?>
        <?php $i++;?>
        <?php if ($row['right_answer']==1) :?>
       
                            
            <li>
                <p class="currectAnswer"><?= $row['answer']?>
                <input type="hidden" value="<?=$row['right_answer']?>">
                </p>
            </li>
         <?php else:?>
                  
            <li>
                <p><?= $row['answer']?>
                <input type="hidden" value="<?=$row['right_answer']?>">
                </p>
            </li>
            <?php endif?>
    <?php endforeach?>
   </ul>
</div>


<?php } ?>