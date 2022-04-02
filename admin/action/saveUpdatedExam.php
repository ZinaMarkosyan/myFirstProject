<?php
include_once '../../connectDB.php';
$db = new Config;
if(isset($_POST['save-examB'])){

    $exam_id = $_POST['examId'];
    $examName = $_POST['examName'];
        $a = $db->update('exam',
            array(
                'exam' => $examName,
            ),
            " id = '$exam_id' "
        );
        if(empty($_POST['question'])){
            header("Location:/admin/admin.php");

        }
        $allans = $db->select("SELECT * FROM answer WHERE exam_id = '$exam_id' ")->fetch_all(true);
        $allq = [];
        $alla = [];
        for($i = 0;$i<count($_POST['question']);$i++){
           
            $q = $_POST['question'][$i][0];  
            $qid = $_POST['questionid'][$i][0];
            $allq[] =  $qid;
         
            if(!empty($qid)){
                $a = $db->update('question',
                array( 
                    'question' => $q,
                  
                ),
                "   id ='".$qid."'"
            );
            }else{
                $db->insert('question',
                    array(
                        'exam_id' => $exam_id,
                        'question' => $q,
                    )
                );
                $qid = $db->mysqli->insert_id;
            }
       
              for($j = 0;$j<count($_POST['answer'][$i]);$j++){
                    $ans = $_POST['answer'][$i][$j];
                    $ansid = $_POST['ansid'][$i][$j];

                
                    $r = (int)$_POST['right'][$i][$j];
                 
                 
                    $alla[] = $ansid ;
                
                
                    if(!empty($ansid)){
                        $a = $db->update('answer',
                            array( 
                                'answer' => $ans,
                                'right_answer' => $r,
                            ),
                            "   id ='".$ansid."'"
                        );
                    }else{
                       
                        $a = $db->insert('answer',
                            array(
                                'exam_id' => $exam_id,
                                'question_id' => $qid,
                                'answer' => $ans,
                                'right_answer' => $r,
                            )
                        );
                    }
                   
              }
             
        }
        $arr1 = [];
        $arr2 = [];
     
        foreach($allans as $ans){
             if(!in_array($ans['id'],$alla)){
                    $db->delete($ans['id'], 'answer', 'id');
            }
            if(!in_array($ans['question_id'],$allq)){
                $db->delete($ans['question_id'], 'answer', 'question_id');
                $db->delete($ans['question_id'], 'question', 'id');
            }
        }

        header("Location:/admin/admin.php");

}
