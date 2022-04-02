<?php
require_once '../../connectDB.php';
$db = new Config;

if(isset($_POST)){
 
    $question=$_POST['question'];
    $answer=$_POST['answer'];
    $exam_id=trim($_POST['examId']);
  
    if(!empty($question)){
      
        
        $db->insert('question',
            array(
                'exam_id' => $exam_id,
                'question' => $question,
            
            )
        );
        
        $question_id = $db->mysqli->insert_id;
        foreach ($answer as $item) {
            $answer = $item['answer'];
            $right_answer = $item['right_answer'];

            $ins = $db->insert('answer',
                array(
                    'exam_id' => $exam_id,
                    'question_id' => $question_id,
                    'answer' => $answer,
                    'right_answer' => $right_answer,
                
                )
            );
            echo $ins;
        
        }

    }
}


?>