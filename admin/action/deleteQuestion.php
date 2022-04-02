<?php

include_once '../../connectDB.php';
$db = new Config;
if(isset($_POST['exid'])){
    $id = $_POST['exid'];
    $db->delete($id, 'answer', 'exam_id');
    $db->delete($id, 'question', 'exam_id');
    $db->delete($id, 'exam', 'id');
    echo 'ok';
}

?>