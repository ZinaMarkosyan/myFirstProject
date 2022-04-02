<?php
include_once '../../connectDB.php';
$db = new Config;
if(isset($_POST['examId'])){
  $examId = $_POST['examId'];

    $select = $db->select("SELECT * FROM question WHERE exam_id='$examId'")->fetch_all(true);
    $num=1;
    ?>
    <?php foreach($select  as $row):?>
        <li class="quest">
           <p class="questLink">Question <?=$num?><input value="<?=$row['id']?>" type="hidden" class="questId"></p>
        </li>
       <?php $num++;?>
  <?php endforeach?>
<?php }?>