<?php
session_start();
require_once('../includes/config/path.php');
require_once(ROOT_PATH . 'includes/function.php');

$db = new Database();
if (isset($_POST['messageInput']) || isset($_POST['receiver_id']) || isset($_POST['chat_id'])) {
    $user_id = $_SESSION['id'];
    $message = trim(htmlspecialchars($_POST['messageInput'], ENT_QUOTES, "UTF-8"));
    $receiver_id = trim(htmlspecialchars($_POST['receiver_id'], ENT_QUOTES, "UTF-8"));
    $chat_id = $_POST['chat_id'];

    //check if user_id and receiver have message in chat 
    $existing_chat = "SELECT * FROM chat WHERE id  = :id";
    $chat_result = $db->fetch($existing_chat, ['id' => $chat_id]);
    if (!empty($chat_result)) {
        var_dump($chat_result);
        //Insert message into chat_messages table
        $insert_sql = "INSERT INTO chat_messages (chat_id, sender_id, message) VALUES (:chat_id, :sender_id, :message)";
        $insert_result = $db->execute($insert_sql, [
            'chat_id' => $chat_result['id'],
            'sender_id' => $user_id,
            'message' => $message
        ]);
        if ($insert_result) {
            $status = 'success';
            $message = "Message sent successfully";
            // header("Location: ../chat.php?success=" . $success_message);
        } else {
            $status = 'error';
            $message = "Unable to send message. Please try again.";
            // header("Location: ../chat.php?error=" . $error_message);
        }
    } else {
        //Insert message into chat table
        $insert_sql = "INSERT INTO chat (sender_id, receiver_id) VALUES (:sender_id, :receiver_id)";
        $insert_result = $db->execute($insert_sql, ['sender_id' => $user_id, 'receiver_id' => $receiver_id]);
        if ($insert_result) {
            $chat_id = $db->lastInsertId();
            //Insert message into chat_messages table
            $insert_sql = "INSERT INTO chat_messages (chat_id, sender_id, message) VALUES (:chat_id, :sender_id, :message)";
            $insert_result = $db->execute($insert_sql, [
                'chat_id' => $chat_id,
                'sender_id' => $user_id,
                'message' => $message
            ]);
            if ($insert_result) {
                $status = 'success';
                $message = "Message sent successfully";
                // header("Location: ../chat.php?success=" . $success_message);
            } else {
                $message = "Unable to send message. Please try again.";
                // header("Location: ../chat.php?error=" . $error_message);
            }
        } else {
            $status = 'error';

            $message = "Unable to send message. Please try again.";
            // header("Location: ../chat.php?error=" . $error_message);
        }
    }
} else {
    $status = 'error';
    $message = "Unbale to send message. Please try again o.";
    // header("Location: ../chat.php?error=" . $error_message);
}

echo json_encode(['status' => $status, 'message' => $message]);
