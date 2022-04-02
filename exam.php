<?php
 require_once "connectDB.php";
$db = new Config;
//setcookie('answers', '', time() + (86400 * 30), "/");
//setcookie('curent', '', time() + (86400 * 30), "/");
//var_dump($_COOKIE['curent']);
if(!empty($_COOKIE['curent'])){
    $curent = json_decode($_COOKIE['curent'],true);
    $exid = $curent['ex'];
    $qid =  $curent['q'];
    $row2 = $db->select("SELECT id,exam_id FROM question WHERE id = '$qid'   LIMIT 1")->fetch_assoc();
}else{
    $examid = base64_decode($_GET['exam']);
    $row2 = $db->select("SELECT id,exam_id FROM question WHERE exam_id = '$examid' order by id asc LIMIT 1")->fetch_assoc();
}
//$row2 = $db->select("SELECT id FROM question order by id desc LIMIT 1")->fetch_assoc();

if(!empty($row2)){
    $firstId= $row2['id'];
}


$rowExamId = $db->select("SELECT id,exam FROM exam WHERE id = '{$row2['exam_id']}' ")->fetch_assoc();

if(!empty($rowExamId)){
    $firstIdExamId= $rowExamId['id'];
}

//$select_exam =$db->select("SELECT * FROM exam order by id desc")->fetch_all(true);
if(!empty($firstIdExamId)){
    $select =$db->select("SELECT * FROM question WHERE exam_id='$firstIdExamId'")->fetch_all(true);

}
$curquest = $row2['id'];
$data = [];
if(!empty($firstId)){
        $data = $db->select("SELECT question.question ,answer.question_id ,answer.id AS answerId, answer.answer ,answer.right_answer  From question INNER JOIN
        answer  ON answer.question_id=question.id WHERE question_id= '$curquest'" );
}

if(!empty($_COOKIE['answers'])){
     $ansvers = json_decode($_COOKIE['answers'],true);
}
?>
<?php include_once 'header.php'?>
<div class="main-exam d-fl j-c-c">
    <?php ?>
    
  
     <div class = "btn-wrap">
              <h2><?=$rowExamId['exam']?></h2>
     </div>   
    <div class="choosen">
        <div id="questions">
          
           <?php if(empty($data)):?>
               Not Question
           <?php else: ?>
                <div class="quest-block">
                        <?php
                        $i = 0;$k = 0;
                        foreach($data as $dat):?>
                             <?php if($i == 0):?>
                                 <h2 class="quiz_text text-center"><?=$dat['question']?></h2>
                                 <input type="hidden" class="hiddenQuestId" value="<?=$dat['question_id']?>">
                                 <input type = "hidden" class = "examm-id" value = "<?=$firstIdExamId?>"/>  
                                 <ul class="firstQuest ">
                                 <?php $i++?>
                             <?php endif?>
                            
                            <li>
                                <p class="success<?=$dat['answerId']?> ans-item"  data-id = "<?=$dat['answerId']?>">
                                    <?php
                                        $disabled = '';
                                       
                                        if(!empty(!empty($ansvers[$dat['question_id']]))){
                                            for($m = 0;$m<count($ansvers[$dat['question_id']]);$m++){
                                                if($ansvers[$dat['question_id']][$m] == $dat['answerId']){
                                                    $disabled = 'selectedans';$k++;
                                                }
                                            }
                                        }
                                    ?>
                                    <span class = "firstex <?=$disabled?>" ><?=$dat['answer'] ?></span>
                                    <input type="hidden" value="<?=$dat['right_answer']?>">
                                </p>
                            </li>
                        <?php endforeach?>
                    </ul>
                </div>
            <?php endif?>
        </div>
        <?php ?>
   
    </div>
     <div class = "btn-wrap">
        <button class = "nextansw nextquest" <?=!empty($k>0)?'':'disabled'?>>Next</button>
     </div>    
    <?php //endif?>
</div>
<?php include_once 'footer.php'?>