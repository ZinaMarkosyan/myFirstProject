$(document).on('click','.questLink',function () {
    $(this).addClass('visited')
    let questionId=$(this).parent().find('.questId').val();

    $.ajax({
        method:"POST",
        url:`front/action/checkQuestion.php`,
        data:{questionId},
        success:function(res){
            $('#questions').html(res)
        },
    });
})

$(document).on('click','.examLink',function () {
    $('.examLink').removeClass('visited')
    $(this).addClass('visited')
    let examId=$(this).parent().find('.examId').val();
    console.log(examId)
    $.ajax({
        method:"POST",
        url:`front/action/changeExam.php`,
        data:{examId},
        success:function(res){
            //console.log(res)
            $('.exam-quest').html(res);
            $('.questLink').eq(0).trigger('click');
            return false;
        },
    });
})




$(document).on('click','.next',function () {
    let nextQuestionId=$('.hiddenQuestId').val();
    $.ajax({
        method:"POST",
        url:`front/action/changeQuestion.php`,
        data:{nextQuestionId},
        success:function(res){
            $('#questions').html(res);
         
             var el =$('.questLink').find('input');
             let nextQuestionId=$('.hiddenQuestId').val();
             el.each(function(){
                if($(this).val() == nextQuestionId){
                     $(this).parent().addClass('visited');
                  
                }else{
                     $(this).parent().removeClass('visited');
                }
            })
        },
    });
})

$(document).on('click','.prev',function () {

    let prevQuestionId=$('.hiddenQuestId').val();
    $.ajax({
        method:"POST",
        url:`front/action/changeQuestion.php`,
        data:{prevQuestionId},
        success:function(res){
            $('#questions').html(res);
          
            let prevQuestionId=$('.hiddenQuestId').val();
             var el =$('.questLink').find('input');
             el.each(function(){
                if($(this).val() == prevQuestionId){
                     $(this).parent().addClass('visited');
                  
                }else{
                     $(this).parent().removeClass('visited');
                }
            })
        },
    });
})

$(document).on('click','.correct_answer',function () {

    let correct_answer=$('.hiddenQuestId').val();
    $.ajax({
        method:"POST",
        url:`front/action/checkQuestion.php`,
        data:{correct_answer},
        success:function(res){
            $('#questions').html(res)

        },
    });
})

$(document).ready(function(){

    nextbutton()
    chooseans()
})
function chooseans(){
        $('.ans-item').click(function(){
    //     var i = 0;
    //     $('.ans-item').each(function(){
    //         if($(this).find('span').hasClass('selectedans')){
    //             i++;
    //         }
    //     })
        //if(i==0){
            let el = $(this);
            let id = $(this).attr('data-id');
            let quest = $('.hiddenQuestId').val();
            let exam = $('.examm-id').val();
            $.ajax({
                method:"POST",
                url:`front/action/functions.php`,
                data:{ansid:id,quesid:quest,examid:exam},
                success:function(res){
                    el.find('span').addClass('selectedans');
                    $('.nextquest').removeAttr('disabled');
                    
         //console.log(res);
                },
            });
        // }else{
        //     alert('You have already made your choice. please move on.');
        // }
    
        
    })
}
function nextbutton(){
        $('.nextquest').click(function(){
        let exam = $('.examm-id').val();
        let quest = $('.hiddenQuestId').val();
         $.ajax({
            method:"POST",
            url:`/front/action/functions.php`,
            data:{exam:exam,questt:quest,},
            success:function(res){
               let result =  JSON.parse(res);
              
               if(typeof result.all !== 'undefined' ){
                   console.log(result.all);
                   return false
               }
               $('.firstQuest').html('');
               for(var i = 0;i<result.length;i++){
                   if(i == 0){
                       $('.examm-id').val(result[i].exam_id);
                       $('.hiddenQuestId').val(result[i].question_id);
                       $('.quiz_text').html(result[i].question);
                   }
                   $('.firstQuest').append('<li><p  class="success'+result[i].answerId+' ans-item"  data-id = "'+result[i].answerId+'"><span class = "firstex" >'+result[i].answer+'</span></p></li>');
                   //console.log(result[i].exam_id)
               }
               chooseans()
            },
        });
        
    })
}

