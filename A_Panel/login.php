<?php
session_start();
require 'db.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $message = "Please fill all fields.";
    } else {
        $stmt = $conn->prepare("SELECT id, password, role FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows == 1) {
            $stmt->bind_result($id, $hashed_password, $role);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                $_SESSION['username'] = $username;
                $_SESSION['role'] = $role;

                if ($role === 'Admin') {
                    header("Location: dashboard.php");
                } elseif ($role === 'Employee') {
                    header("Location: ../employee_access/Employee_Dashboard.php");
                } elseif ($role === 'Vendor') {
                    header("Location: ../vendor_access/vendor_dashboard.php");
                } else {
                    $message = "Invalid role. Please contact administrator.";
                }
                exit();
            } else {
                $message = "Invalid password.";
            }
        } else {
            $message = "Username not found.";
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
<title>Login - BCPDR</title>

<style>
  * {
    box-sizing: border-box;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  }

  body {
    margin: 0; padding: 0;
    height: 100vh;
    background-color: #121417;
    background-image:
      radial-gradient(circle at top left, rgba(94,129,172,0.2) 0%, transparent 70%),
      radial-gradient(circle at bottom right, rgba(129,161,193,0.15) 0%, transparent 70%);
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
    background: radial-gradient(circle at center, rgba(94,129,172,0.6), transparent 60%);
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

  .login-container {
    position: relative;
    background: #1e262c;
    padding: 40px 35px;
    border-radius: 15px;
    box-shadow:
      0 0 15px 2px rgba(94,129,172,0.7),
      0 8px 24px rgba(0,0,0,0.6);
    width: 350px;
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
    letter-spacing: 1.2px;
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

  input[type="text"], input[type="password"] {
    width: 100%;
    padding: 12px 15px;
    margin-bottom: 20px;
    border: none;
    border-radius: 8px;
    background: #2a333d;
    color: #e0e6f1;
    font-size: 16px;
    transition: background 0.3s ease, box-shadow 0.3s ease, transform 0.3s ease;
  }

  input[type="text"]:focus, input[type="password"]:focus {
    background: #39475a;
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

  .register-link, .forgot-link {
    text-align: center;
    margin-top: 15px;
    font-size: 14px;
    color: #a7b1c2;
  }

  .register-link a, .forgot-link a {
    color: #81a1c1;
    text-decoration: none;
    font-weight: 600;
    transition: color 0.3s ease;
  }

  .register-link a:hover, .forgot-link a:hover {
    color: #5e81ac;
    text-shadow: 0 0 6px #81a1c1;
  }

  .forgot-button {
    margin-top: 10px;
    text-align: center;
  }

  .forgot-button a {
    display: inline-block;
    padding: 10px 20px;
    background: transparent;
    color: #81a1c1;
    font-weight: 600;
    text-decoration: none;
    border: 1px solid #81a1c1;
    border-radius: 8px;
    transition: background 0.3s ease, color 0.3s ease, transform 0.3s ease;
  }

  .forgot-button a:hover {
    background: #81a1c1;
    color: #1e262c;
    transform: scale(1.05);
  }
</style>

</head>
<body>

<div class="glow-effect"></div>

<div class="login-container">
    <h2>LOGIN</h2>
    <?php if ($message): ?>
        <p class="message"><?php echo htmlspecialchars($message); ?></p>
    <?php endif; ?>
    <form method="POST" action="">
        <label for="username">Username:</label>
        <input id="username" type="text" name="username" required autocomplete="username" autofocus>

        <label for="password">Password:</label>
        <input id="password" type="password" name="password" required autocomplete="current-password">

        <input type="submit" value="Login">

       
 <p class="register-link">DId you forget your password? <a href="forgot_password.php">forgot password</a>.</p>
    <p class="register-link">Don't have an account? <a href="register.php">Register here</a>.</p>
</div>

</body>
</html>
