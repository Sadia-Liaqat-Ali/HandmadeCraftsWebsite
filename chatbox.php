<?php
session_start();
include 'connection.php';

if (!isset($_SESSION['role'])) {
  echo "<script>alert('Access denied.'); window.location='login.php';</script>";
  exit();
}

$request_id = $_GET['request_id'];
$sender_role = $_SESSION['role']; // 'user' or 'artisan'

if (isset($_POST['send'])) {
  $msg = $_POST['message'];
  $conn->query("INSERT INTO messages (request_id, sender, message) VALUES ($request_id, '$sender_role', '$msg')");
}

$messages = $conn->query("SELECT * FROM messages WHERE request_id = $request_id ORDER BY sent_at ASC");
?>

<!DOCTYPE html>
<html>
<head>
  <title>Chatbox</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: #fdf0f5;
    }
    .chatbox {
      max-width: 700px;
      margin: 40px auto;
      background: #fff;
      border-radius: 15px;
      padding: 25px;
      box-shadow: 0 0 25px rgba(0, 0, 0, 0.1);
      height: 80vh;
      display: flex;
      flex-direction: column;
    }
    .chat-title {
      text-align: center;
      font-size: 24px;
      color: #d63384;
      margin-bottom: 15px;
    }
    .messages {
      flex-grow: 1;
      overflow-y: auto;
      padding-right: 10px;
      margin-bottom: 20px;
    }
    .message-box {
      max-width: 70%;
      padding: 10px 15px;
      border-radius: 12px;
      margin-bottom: 12px;
      position: relative;
      word-wrap: break-word;
    }
    .customer {
      background-color: #ffe6e9;
      align-self: flex-start;
    }
    .artisan {
      background-color: #dbeeff;
      align-self: flex-end;
    }
    .sender-label {
      font-weight: bold;
      font-size: 13px;
      margin-bottom: 2px;
      color: #555;
    }
    .timestamp {
      font-size: 11px;
      color: #777;
      margin-top: 5px;
    }
    .send-box {
      display: flex;
      gap: 10px;
    }
  </style>
</head>
<body>

<?php
// ✅ Dynamic navbar include based on role
if ($_SESSION['role'] === 'artisan') {
  include 'includes/navbar_saller.php';
} else {
  include 'user_navbar.php';
}
?>

<div class="chatbox">
  <div class="chat-title">Custom Design Chat</div>

  <div class="messages">
    <?php while ($m = $messages->fetch_assoc()) {
      $sender_class = $m['sender'] === 'artisan' ? 'artisan' : 'customer';
      $sender_label = ucfirst($m['sender']);
    ?>
      <div class="d-flex flex-column <?php echo $sender_class; ?> message-box">
        <div class="sender-label"><?php echo $sender_label; ?></div>
        <div><?php echo htmlspecialchars($m['message']); ?></div>
        <div class="timestamp"><?php echo $m['sent_at']; ?></div>
      </div>
    <?php } ?>
  </div>

  <form method="POST" class="send-box">
    <input type="text" name="message" class="form-control" placeholder="Type your message..." required>
    <button name="send" class="btn btn-primary">Send</button>
  </form>
</div>

</body>
</html>
