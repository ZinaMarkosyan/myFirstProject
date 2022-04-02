$('#add_exam').click(function (){
    // $('#questions-container').hide()
    // $('#addedSuccess').hide()
    // $('#fillFields').hide()
    // $('#edit-form').hide()
    $('#open-form').show()
    $('#allExams').hide();
    $('.editcontent').hide();
})

$(document).on('click','.addAnswer',function () {
     $(this).parent().parent().find('.answers-containerA').append(`<div class="answ-blockA">
            <label for="answer"><b>Answer </b></label>
            <textarea class="answerA" name="" id=""></textarea>
             Right answer<input class="currectA" type="checkbox" >
            <button class="btn btn-danger removeAnswer">Remove</button>
        </div>`)
})
$(document).on('click','.addAnswerB',function () {
    let c = $(this).closest('.quest-blokB').index();
    let k = $(this).closest('.quest-blokB').find('.answ-blockB').length;
    $(this).parent().parent().find('.answers-containerB').append(`<div class="answ-blockB">
            <label for="answer"><b>Answer ${k+1}</b></label>
            <textarea class="answerB" name = "answer[${c}][]"></textarea>
            <input type="hidden" name = "ansid[${c}][]"  class = "ansid">
             Right answer<input class="currectB" type="checkbox" >
             <input type="hidden" value = "0" name = "right[${c}][]" class = "rightor">
            <button class="btn btn-danger removeAnswerB">Remove</button>
        </div>`);

})

$(document).on('click','.currectB',function () {
    if($(this).next().val() == 1){
        $(this).next().val(0)
    }else{
        $(this).next().val(1)
    }
 
})

$(document).on('click','.removeAnswer',function () {
    $(this).parent().remove()
})
$(document).on('click','.removeAnswerB',function () {
    $(this).parent().remove()
})
$(document).on('click','.remove-questionB',function () {
    $(this).parent().parent().remove();
    let c = $('.counter').val();
    $('.counter').val(parseInt(c)-1);
    var i = 0;
    $('.quest-blokB').each(function(){
        $(this).find('.questionB').attr('name',`question[${i}][]`);
        $(this).find('.questionid').attr('name',`questionid[${i}][]`);
        $(this).find('.answerB').attr('name',`answer[${i}][]`);
        $(this).find('.rightor').attr('name',`right[${i}][]`);
        $(this).find('.ansid').attr('name',`right[${i}][]`);
        i++;
    })
})



$(document).on('click','.add-question',function () {
    $('.quest-container').append(`<div class="quest-blok">
        <label for="question"><b>Question</b></label>
        <input type="text" placeholder="Enter question" name="question" class="questionA" id="questionA" >
        <div class="answers-containerA">
            <div class="answ-blockA">
               <label for="answer"><b>Answer </b></label>
                <textarea class="answerA" name="answer" id="" ></textarea>
                <input name="currectA" class="currectA" type="checkbox">
            </div>
        </div>
        <p>
            <button class="addAnswer">Add answer</button>
        </p>
   </div>`)

})
$(document).on('click','.add-questionB',function () {
    let c = $('.counter').val();
    $('.quest-containerB').append(`<div class="quest-blokB">
        <label for="questionB"><b>Question</b></label>
        <input type="text" placeholder="Enter question" name="question[${c}][]" class="questionB" id="questionB" >
        <input type="hidden" name = "questionid[${c}][]" class = "questionid"> 
        <div class="answers-containerB">
            <div class="answ-blockB">
               <label for="answerB"><b>Answer </b></label>
                <textarea class="answerB" name = "answer[${c}][]" id="" ></textarea>
                <input type="hidden" name = "ansid[${c}][]" class = "ansid">
                <input  class="currectB" type="checkbox"  class = "rightor">
                <input type="hidden" value = "0" name = "right[${c}][]" class = "rightor">
            </div>
        </div>
        <p>
            <button class="addAnswerB">Add answer</button>
        </p>
        <p style="text-align: right"> <button type="submit" name="remove-questionB" class="remove-questionB">Remove Question</button></p>
   </div>`);
   $('.counter').val(parseInt(c)+1);
//    $('.currectB').click(function () {
//        alert($(this).next().val() );
//         if(parseInt($(this).next().val()) == 1){
//             $(this).next().val(0)
//         }else{
//             $(this).next().val(1)
//         }
     
//     })
})
$(document).ready(function(){
    $('.deleteexam').click(function(){
        var tr = $(this).closest('tr');
        let val = $(this).parent().find('.examid').val();
        let name = $(this).closest('tr').find('.exnamep').text();
        $('.yesornow p').html('Do you want to delete the exam '+name);
        $('.requestW').css({'display':'flex'});
        $('.nod').click(function(){
            $('.requestW').hide();
        });
        $('.yesd').click(function(){
        
            $.ajax({
                method: "POST",
                url: "/admin/action/deleteQuestion.php",
                data: {
                    exid:val,
                },
                success: function (res) {
                    if(res){
                        
                        // $('.requestW').hide(); 
                         location.reload(); 
                    }
                }
            })
            
        })
        
    })
})



$(document).on('click','.save-exam',async function () {
    if($('.add_exam').val() != ''){
            const blocks = document.querySelectorAll('.quest-blok');
    const examName=$('#examA').val()

    const examId = await instertExam(examName);
    let answ
    let right_answ
    const data = [];
    for(const item of blocks){
        const qArr = [];
        const question = $(item).find('.questionA').val();
        const obj = {
            question
        };
        qArr.push(obj)
        const answerBlock = item.querySelectorAll('.answers-containerA .answ-blockA');

        const answerArr = [];
        for (let i = 0; i < answerBlock.length; i++) {
            answerArr.push({
                answer: $(answerBlock[i]).find('.answerA').val(),
                right_answer: $(answerBlock[i]).find('.currectA').prop('checked') ? 1 : 0,
            })

        }
       if(examName==''){
           $('#fillFields').html('Please fill in the fields')
       }else{
        $.ajax({
            method: "POST",
            url: "/admin/action/addQuestion.php",
            data: {
                question:question,
                answer: answerArr,
                examId:examId
            },
            success: function (res) {

                document.location.reload(true);




            },
        });
    }
    }
        
    }

})







function instertExam(examName){

    return $.ajax({
        method: "POST",
        url: "action/addExam.php",
        data: {
            examName
        },
        success: function (res) {}
    })
}

$(document).on('click','#all_exam',function () {
    $.ajax({
        method: "POST",
        url: "action/allExam.php",
        data: { },
        success: function (res) {
            $('#open-form').hide();
            $('.rescontent').html(res)
        },
    });
})

$(document).on('click','.examUpdate',function () {
    let examId=$(this).parent().find('.examid').val()

    $.ajax({
        method: "POST",
        url: "action/examUpdate.php",
        data: {examId},
        success: function (res) {
            $('#open-form').hide()
            $('.editcontent').html(res)
            $('.save-examB').click(function(){
                $(this).closest('form').removeAttr('onsubmit');
            })
        },
    });
})
