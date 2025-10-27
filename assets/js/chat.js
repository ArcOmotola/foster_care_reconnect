$(function(){
    $('.hidden_showchat').hide()
    $('#chat_box').on('click', function(e){
        e.preventDefault();
        alert('clicked');
        $('.hidden_showchat').show();
    })
    // $('.hidden_showchat').scrollTop($('.hidden_showchat')[0].scrollHeight).show();
})