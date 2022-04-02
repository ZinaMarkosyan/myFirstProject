<?php
include_once '../../connectDB.php';
$db = new Config;
if(isset($_POST['nextQuestionId'])) {


    $questionId = $_POST['nextQuestionId'];
    $ex = $db->select("SELECT exam_id FROM answer WHERE question_id = '$questionId' order by id asc LIMIT 1")->fetch_assoc();
    $countId = $db->select("SELECT id FROM question WHERE id > '$questionId' and  exam_id = '{$ex['exam_id']}' order by id asc LIMIT 1")->fetch_assoc();
    if(empty($countId)){
        $countId=$questionId;
    }
    else{
        $countId=$countId['id'];
    }

    $data = $db->select("SELECT question.question ,answer.question_id ,answer.id AS answerId, answer.answer ,answer.right_answer  FROM question INNER JOIN answer WHERE answer.question_id='$countId' AND question.id='$countId'")->fetch_all(true);
    ?>
    <div class="quest-block">
   <?php
    $i=0;?>
    <?php foreach($data as $row ):?>
  
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
    </ul></div>


<?php }?>
<?php
if(isset($_POST['prevQuestionId'])) {
    $questionId = $_POST['prevQuestionId'];
      $ex = $db->select("SELECT exam_id FROM answer WHERE question_id = '$questionId' order by id asc LIMIT 1")->fetch_assoc();
    $countId = $db->select("SELECT id FROM question WHERE id < '$questionId' and  exam_id = '{$ex['exam_id']}' order by id asc  LIMIT 1")->fetch_assoc();
   
    if(empty($countId)){
        $countId=$questionId;
    }
    else{
        $countId=$countId['id'];
    }
    $data = $db->select("SELECT question.question ,answer.question_id ,answer.id AS answerId, answer.answer ,answer.right_answer  FROM question INNER JOIN answer WHERE answer.question_id='$countId' AND question.id='$countId'");
   
    ?>
    <div class="quest-block">
    <?php $i=0;?>
   <?php foreach($data as $row):?>
       <?php if ($i == 0):?>
            <h2 class="quiz_text"><?=$row['question']?></h2>
            <input type="hidden" class="hiddenQuestId" value="<?=$row['question_id']?>"><ul>
        <?php endif?>

        <?php $i++;?>
        <li>
            <p class="success<?=$row['answerId']?> ans-item"  data-id = "<?=$dat['answerId']?>"><?=$row['answer']?>
                <input type="hidden" value="<?=$row['right_answer']?>">
            </p>
        </li>
    <?php endforeach?>
   </ul></div>


   <?php } ?>


