$(function(){
    // fetchMessages = function(chatId) {
    //     $.ajax({
    //         url: 'fetch_messages.php',
    //         type: 'GET',
    //         data: { chat_id: chatId },
    //         success: function(data) {
    //             $('.hidden_showchat').html(data);
    //             // Scroll to the bottom of the chat container
    //             $('.hidden_showchat').scrollTop($('.hidden_showchat')[0].scrollHeight);
    //         }
    //     });
    // }

    // fetchMessages(chatId);
    // setInterval(function() {
    //     fetchMessages(chatId);
    // }, 5000);
    
    

    $('#sendBtn').on('click', function(){
        console.log('Hello world');

        const message = $('#messageInput').val();
        const receiver_id = $('#receiver_id').val();
        const chat_id = $('#chat_id').val();
        console.log(chat_id);
        sendMessage(receiver_id, message, chat_id);
       location.reload();
    })
    function sendMessage(receiver_id, message , chat_id){
        if(message.trim() === ''){
            alert("No message, Please type a message");
        }
        $.ajax({
            url: 'backend/send_message.php',
            type: 'POST',
            data: { messageInput: message, receiver_id: receiver_id, chat_id: chat_id },
            success: function(data) {
                $('#messageInput').val('');
                // fetchMessages(chat_id);
                }
        });
    }
});