<?php
 require_once "connectDB.php";
$db = new Config;

$row2 = $db->select("SELECT id FROM question order by id desc LIMIT 1")->fetch_assoc();
//$sql2 = "SELECT id FROM question order by id desc LIMIT 1";
//$select2 = $mysqli->query($sql2);
//$row2 = $select2->fetch_assoc();
if(!empty($row2)){
    $firstId= $row2['id'];
}

// $sql_examId = "SELECT id FROM exam LIMIT 1";
// $selectExamId = $mysqli->query($sql_examId);
// $rowExamId = $selectExamId->fetch_assoc();
$rowExamId = $db->select("SELECT id FROM exam order by id desc LIMIT 1")->fetch_assoc();

if(!empty($rowExamId)){
    $firstIdExamId= $rowExamId['id'];
}
// $sql = "SELECT question.question AS question,answer.question_id AS question_id,answer.id AS answerId, answer.answer AS answer,answer.right_answer AS right_answer From question INNER JOIN
// answer  ON answer.question_id=question.id WHERE question_id= '$firstId'";
//         $data = $mysqli->query($sql);

$select_exam =$db->select("SELECT * FROM exam order by id desc")->fetch_all(true);
if(!empty($firstIdExamId)){
    $select =$db->select("SELECT * FROM question WHERE exam_id='$firstIdExamId'")->fetch_all(true);

}
$curquest = $select[0]['id'];
$data = [];
if(!empty($firstId)){
        $data = $db->select("SELECT question.question ,answer.question_id ,answer.id AS answerId, answer.answer ,answer.right_answer  From question INNER JOIN
        answer  ON answer.question_id=question.id WHERE question_id= '$curquest'" );
}

?>

<div class="main">
    <div class="container cont-block">
        <div id="questions">
          
           <?php if(empty($data)):?>
               Not Question
           <?php else: ?>
                <div class="quest-block">
                        <?php
                        $i = 0;
                        foreach($data as $dat):?>
                             <?php if($i == 0):?>
                                 <h2 class="quiz_text"><?=$dat['question']?></h2>
                                 <input type="hidden" class="hiddenQuestId" value="<?=$dat['question_id']?>">
                                
                                 <ul class="firstQuest">
                                 <?php $i++?>
                             <?php endif?>
                            
                            <li>
                            <p class="success<?=$dat['answerId']?>"><?=$dat['answer'] ?>
                                <input type="hidden" value="<?=$dat['right_answer']?>">
                            </p>
                            </li>
                        <?php endforeach?>
                    </ul>
                </div>
            <?php endif?>
        </div>
        <?php
        if(count($data)>0):?>
            <div class="next">
                <svg width="80" height="48">
                    <polyline class="nextline" points="21,27 57,27 47,17 57,27 47,37" />
                </svg>
            </div>
            <div class="prev">
                <svg width="80" height="48">
                    <polyline class="prevline" points="57,27 21,27 31,18 21,27 31,38" />
                </svg>
            </div>
            <span class="correct_answer">
            Check Answer
            </span>
        <?php endif?>
    </div>
    <div class="container sidebar">
        <div>
            <?php
            // $sql_exam = "SELECT * FROM exam";
            // $select_exam = $mysqli->query($sql_exam);
            ?>
            <h2>All Exams </h2>
            <ul>
                <?php
                $num=1;
                foreach($select_exam as $ex):?>
                    <li class="exam">
                        <p class="examLink <?=$num==1?'visited':''?>"><?=$num?><input value="<?=$ex['id']?>" type="hidden" class="examId">. &nbsp;&nbsp;<?=$ex['exam']?></p>
                    </li>
                <?php $num++;?>
                <?php endforeach?> 
            </ul>
        </div>
        <div>
            <h2>Questions </h2>
            <ul class="exam-quest">
                <?php
                // $sql = "SELECT * FROM question WHERE exam_id='$firstIdExamId'";
                // $select = $mysqli->query($sql);
                $num=1;?>
                <?php if(!empty($select)):?>
                    <?php foreach($select as $ex):?>
                   
                            <li class="quest">
                                <p class="questLink <?=$num==1?'visited':''?>">Question <?=$num?><input value="<?=$ex['id']?>" type="hidden" class="questId"></p>
                            </li>
                            <?php $num++;?>
                    <?php endforeach?>
                <?php endif?>
            </ul>
        </div>
    </div>
</div>