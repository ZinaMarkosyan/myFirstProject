<?php
 include_once '../connectDB.php';
 $db = new Config;

 
 if(empty($_SESSION['user']['id'])) {
    header("Location:/admin/");
}
 $lastexam = $db->select("SELECT * FROM exam order by id desc limit 1")->fetch_assoc();
 if(!empty($lastexam)){
     $exid = $lastexam['id'];
 }else{
    $exid = 1;
 }

$select_exam = $db->select("SELECT * FROM exam order by id desc")->fetch_all(true);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Dashboard - SB Admin</title>
    <link href="css/styles.css" rel="stylesheet" />
    <link href="css/add-question-style.css" rel="stylesheet" />
</head>
<body class="sb-nav-fixed">
<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
    <!-- Navbar Brand-->
    <a class="navbar-brand ps-3" href="/questions/">Front page</a>
    <!-- Sidebar Toggle-->
</nav>
<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    <button class="nav-link" id="all_exam">All exam</button>
                    <button class="nav-link" id="add_exam">Add exam</button>
                </div>
            </div>
        </nav>
    </div>
    <div id="layoutSidenav_content">
        <main id="main_container">
            <h1 style="text-align: center">Dashboard</h1>
            <div id="open-form" >
                <div>
                    <div class="container quest-container">
                        <div class="quest-header">
                            <h1 style="display: inline-block">Add Question</h1>
                            <h3 class="exam_form">
                                <p class="exam_add">
                                    <label for="add_exam">Exam Name</label>
                                    <input placeholder="Exam Name" id="examA" class="add_exam"  />
                                </p>
                            </h3>
                            <div>
                                <p id="addedSuccess">Question added successfully</p>
                                <p id="fillFields"></p>
                            </div>
                        </div>
                        <div class="quest-blok">

                            <label for="question"><b>Question</b></label>
                            <input type="text" placeholder="Enter question" name="question" class="questionA" id="questionA" >
                            <div class="answers-containerA">
                                <div class="answ-blockA">
                                    <label for="answer"><b>Answer 1</b></label>
                                    <textarea class="answerA" name="" id="" ></textarea>
                                    Right answer <input  class="currectA" type="checkbox">
                                </div>
                            </div>
                            <p>
                                <button class="addAnswer">Add answer</button>
                            </p>
                        </div>
                    </div>
                    <div class="action container">
                        <div>
                            <button type="submit" name="add-question" class="add-question">Add Question</button>
                        </div>
                        <div>
                            <button type="submit" name="save-exam" class="save-exam">Save Exam</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class = "rescontent">
                <div id="allExams">
                    
                    <table class = "allexam text-center">
                        <tr>
                            <th>#</th>
                            <th>Exam Name</th>
                            <th>Action</th>
                        </tr>
                        <?php
                        $num=1;
                        if(!empty($select_exam)):?>
                            <?php foreach($select_exam as $ex):?>
                      
                                <tr class="exams">
                                    <td><strong><?=$num?></strong></td>
                                    <td>
                                        <p > <?=$ex['exam']?></p>
                                    </td>
                                    <td>
                                        <img src="data:image/png;base64,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" alt="" width = "25" class = "deleteexam" >
                                        <img src="https://www.freeiconspng.com/thumbs/edit-icon-png/edit-new-icon-22.png" alt="" width = "25" class="examUpdate">
                                        <input type = "hidden" value="<?=$ex['id']?>" type="hidden" class="examid">
                                    </td>
                                </tr>
                                <?php
                                $num++;
                            endforeach ?>
                        <?php endif?>
                    </table>
                    
                </div>

            </div>
            <div class = "editcontent">
            </div>


         
        </main>
    </div>
    <div class = "requestW">
        <div class = "yesornow">
            <p class = "text-center"></p>
            <div>
                <button type = "button" class = "yesd">Yes</button>
                <button type = "button" class = "nod">NO</button>
            </div>
        </div>      
    </div>
</div>
<script src="script/jquery.js"></script>
<script src="script/script.js"></script>

</body>
</html>
