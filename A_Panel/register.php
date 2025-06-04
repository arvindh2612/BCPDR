<?php
session_start();
require 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
        $message = "Please fill all fields.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format.";
    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match.";
    } else {
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $message = "Username or Email already taken.";
        } else {
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $insert_stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
            $insert_stmt->bind_param("sss", $username, $email, $hashed_password);

            if ($insert_stmt->execute()) {
                $_SESSION['username'] = $username;
                header("Location: login.php");
                exit();
            } else {
                $message = "Registration failed, try again.";
            }
            $insert_stmt->close();
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Register - BCPDR</title>

<style>
  * {
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  body {
    margin: 0; padding: 0;
    height: 100vh;
    background-color: #0b2347; /* deep navy blue */
    background-image:
      radial-gradient(circle at top left, rgba(129,161,193,0.3) 0%, transparent 70%),
      radial-gradient(circle at bottom right, rgba(94,129,172,0.25) 0%, transparent 70%);
    display: flex;
    justify-content: center;
    align-items: center;
    color: #cfd8dc;
    overflow: hidden;
  }

  .glow-effect {
    position: absolute;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle at center, rgba(129,161,193,0.7), transparent 60%);
    filter: blur(100px);
    top: 20%;
    left: 50%;
    transform: translateX(-50%);
    animation: floatGlow 6s ease-in-out infinite;
    z-index: 0;
  }

  @keyframes floatGlow {
    0%, 100% { transform: translateX(-50%) translateY(0); }
    50% { transform: translateX(-50%) translateY(20px); }
  }

  .register-container {
    position: relative;
    background: #1e2c47; /* dark navy */
    padding: 40px 35px;
    border-radius: 15px;
    box-shadow:
      0 0 15px 2px rgba(129,161,193,0.7),
      0 8px 24px rgba(0,0,0,0.6);
    width: 370px;
    animation: fadeIn 1.2s ease forwards;
    z-index: 1;
  }

  @keyframes fadeIn {
    from {opacity: 0; transform: translateY(-20px);}
    to {opacity: 1; transform: translateY(0);}
  }

  h2 {
    text-align: center;
    margin-bottom: 30px;
    font-weight: 700;
    letter-spacing: 2px;
    text-transform: uppercase;
    color: #a1b2cd;
    background: linear-gradient(90deg, #5e81ac, #81a1c1);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    text-shadow: 0 2px 5px rgba(94,129,172,0.6);
  }

  label {
    font-weight: 600;
    display: block;
    margin-bottom: 8px;
    color: #a7b1c2;
  }

  input[type="text"],
  input[type="email"],
  input[type="password"] {
    width: 100%;
    padding: 12px 15px;
    margin-bottom: 20px;
    border: none;
    border-radius: 8px;
    background: #2a3a65;
    color: #e0e6f1;
    font-size: 16px;
    transition: background 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
  }

  input[type="text"]:focus,
  input[type="email"]:focus,
  input[type="password"]:focus {
    background: #3c517c;
    outline: none;
    box-shadow: 0 0 12px 3px #81a1c1;
    color: #fff;
    transform: scale(1.03);
  }

  input[type="submit"] {
    width: 100%;
    background: linear-gradient(90deg, #5e81ac, #81a1c1);
    border: none;
    padding: 14px 20px;
    border-radius: 10px;
    color: #eceff4;
    font-weight: 700;
    font-size: 18px;
    cursor: pointer;
    letter-spacing: 1.1px;
    transition: background 0.4s ease, transform 0.3s ease, box-shadow 0.3s ease;
    box-shadow: 0 5px 15px rgba(94,129,172,0.7);
  }

  input[type="submit"]:hover {
    background: linear-gradient(90deg, #81a1c1, #5e81ac);
    transform: scale(1.1);
    box-shadow: 0 10px 30px rgba(94,129,172,0.9);
  }

  p.message {
    color: #bf616a;
    font-weight: 600;
    text-align: center;
    margin-bottom: 20px;
    text-shadow: 0 0 5px #b35050;
  }

  p.login-link {
    text-align: center;
    margin-top: 15px;
    font-size: 14px;
    color: #a7b1c2;
  }

  p.login-link a {
    color: #81a1c1;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
  }

  p.login-link a:hover {
    color: #5e81ac;
    text-shadow: 0 0 6px #81a1c1;
  }
</style>

</head>
<body>

<div class="glow-effect"></div>

<div class="register-container">
    <h2>Register</h2>
    <?php if ($message): ?>
        <p class="message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input id="username" type="text" name="username" required autocomplete="username" autofocus>

        <label for="email">Email:</label>
        <input id="email" type="email" name="email" required autocomplete="email">

        <label for="password">Password:</label>
        <input id="password" type="password" name="password" required autocomplete="new-password">

        <label for="confirm_password">Confirm Password:</label>
        <input id="confirm_password" type="password" name="confirm_password" required autocomplete="new-password">

        <input type="submit" value="Register">
    </form>
    <p class="login-link">Already registered? <a href="login.php">Login here</a>.</p>
</div>

</body>
</html>
