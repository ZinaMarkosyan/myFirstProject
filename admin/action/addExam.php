<?php
require_once '../../connectDB.php';
$db = new Config;
if(isset($_POST['examName'])){
   
    $examName=$_POST['examName'];
  
    $a = $db->insert('exam',
        array(
            'exam' => $examName,
        )
    );
 
    $exam_id = $db->mysqli->insert_id;
    echo trim($exam_id);
}

