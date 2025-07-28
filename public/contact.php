<?php
// Initialize variables for messages and form data
$success = "";
$error = "";
$name = "";
$email = "";
$message = "";

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Sanitize input
    $name = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $message = filter_var(trim($_POST['message']), FILTER_SANITIZE_STRING);

    // Validate inputs
    if (empty($name) || strlen($name) < 2) {
        $error = "Please enter a valid name (at least 2 characters).";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = "Please enter a valid email address.";
    } elseif (empty($message) || strlen($message) < 10) {
        $error = "Please enter a message (at least 10 characters).";
    } else {
        // Prepare email
        $to = "htetmyattun28@gmail.com"; // <-- Replace with your email
        $subject = "New Message from $name";
        $body = "Name: $name\nEmail: $email\n\nMessage:\n$message";
        $headers = "From: $email\r\nReply-To: $email\r\n";

        // Send email
        if (mail($to, $subject, $body, $headers)) {
            $success = "Message sent successfully! Thank you for contacting me.";
            // Clear form values on success
            $name = $email = $message = "";
        } else {
            $error = "Failed to send the message. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Contact Me</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #1d3557;
      color: #f1faee;
      padding: 40px 20px;
      text-align: center;
    }

    h2 {
      font-size: 2rem;
      margin-bottom: 10px;
    }

    p {
      font-size: 1.1rem;
      margin-bottom: 30px;
    }

    form {
      max-width: 500px;
      margin: 0 auto;
      display: flex;
      flex-direction: column;
      gap: 15px;
    }

    input, textarea {
      padding: 10px;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      resize: vertical;
    }

    button {
      padding: 10px;
      background-color: #457b9d;
      color: white;
      border: none;
      border-radius: 8px;
      font-size: 1rem;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    button:hover {
      background-color: #1d3557;
    }

    .message {
      max-width: 500px;
      margin: 20px auto;
      padding: 15px;
      border-radius: 8px;
    }

    .success {
      background-color: #2a9d8f;
      color: white;
    }

    .error {
      background-color: #e76f51;
      color: white;
    }
  </style>
</head>
<body>

  <h2>Contact Me</h2>
  <p>Send me a message and I'll get back to you soon!</p>

  <?php if ($success): ?>
    <div class="message success"><?= htmlspecialchars($success) ?></div>
  <?php elseif ($error): ?>
    <div class="message error"><?= htmlspecialchars($error) ?></div>
  <?php endif; ?>

  <form method="POST" action="<?= htmlspecialchars($_SERVER["PHP_SELF"]); ?>" novalidate>
    <input type="text" name="name" placeholder="Your Name" required minlength="2" value="<?= htmlspecialchars($name) ?>" />
    <input type="email" name="email" placeholder="Your Email" required value="<?= htmlspecialchars($email) ?>" />
    <textarea name="message" placeholder="Your Message" rows="5" required minlength="10"><?= htmlspecialchars($message) ?></textarea>
    <button type="submit">Send Message</button>
  </form>

</body>
</html>
