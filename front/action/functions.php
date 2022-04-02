<?php

require_once "../../connectDB.php";
$db = new Config;
//setcookie('exam', '', time() + (86400 * 30), "/");
    // if(isset($_POST['first'])){
    //     $ex= 'first';
    //     setcookie('exam', $ex, time() + (86400 * 30), "/");
    //     header("Location:/exam.php");
    // }
    //   if(isset($_POST['second'])){
    //     $ex= 'second';
    //     setcookie('exam', $ex, time() + (86400 * 30), "/");
    //      header("Location:/exam.php");
    // }
    
    if(isset($_POST['ansid'])){
        $ans = $_POST['ansid'];
        $ques = $_POST['quesid'];
        $examid = $_POST['examid'];
       
        if(empty($_COOKIE['answers'])){
           
            $ansvers =[];
            $ansvers[$ques] = [];
            $ansvers[$ques][] = $ans;
            setcookie('answers', json_encode($ansvers,true), time() + (86400 * 30), "/");
           
      
        }else{
            // $ans = $_POST['ansid'];
            // $ques = $_POST['quesid'];
            $ansvers = json_decode($_COOKIE['answers'],true);
            if(!empty($ansvers[$ques])){
                $ansvers[$ques][] = $ans;
            }else{
                $ansvers[$ques] = [];
                $ansvers[$ques][] = $ans;
            }
           // var_dump($ansvers);
            setcookie('answers', json_encode($ansvers,true), time() + (86400 * 30), "/");
            //echo json_encode($ansvers,true);
            
            
        }
        echo 'ok';
       // $r = $db->select("SELECT question_id FROM  answer WHERE exam_id = '$examid' and question_id > '$ques' order by id asc limit 1")->fetch_assoc();
        

    }
    if(isset($_POST['exam'])){
        $quest = $_POST['questt'];
        $exam = $_POST['exam'];
        $arr = [];
        $r = $db->select("SELECT question_id FROM  answer WHERE exam_id = '$exam' and question_id > '$quest' order by id asc limit 1")->fetch_assoc();
       
        $row = $db->select("SELECT answer.*,question.question FROM  answer left join question on answer.question_id = question.id WHERE answer.question_id = '{$r['question_id']}' ")->fetch_all(true);
       
        if(count($row)){
             $arr['ex'] = $exam;
             $arr['q'] = $r['question_id'];
             setcookie('curent', json_encode($arr,true), time() + (86400 * 30), "/");
            echo json_encode($row,true);
        }else{
            echo json_encode(['all'=>'completed'],true);
        }
        
    }
?>