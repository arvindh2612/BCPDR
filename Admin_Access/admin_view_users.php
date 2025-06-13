<?php
session_start();
require 'db.php'; // Adjust this path if your db.php is elsewhere

$sql = "SELECT email, username, role FROM users";
$result = $conn->query($sql);

if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>All Users - Admin</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            background-color: #121417;
            color: #e0e6f1;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #81a1c1;
            margin-bottom: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background-color: #1e262c;
            box-shadow: 0 0 15px rgba(129, 161, 193, 0.3);
            border-radius: 8px;
            overflow: hidden;
        }

        th, td {
            padding: 14px;
            border-bottom: 1px solid #2a333d;
            text-align: left;
        }

        th {
            background-color: #2a333d;
            color: #81a1c1;
        }

        tr:hover {
            background-color: #2f3b45;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .back-link {
            text-align: center;
            margin-top: 20px;
        }

        .back-link a {
            color: #81a1c1;
            text-decoration: none;
        }

        .back-link a:hover {
            color: #5e81ac;
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>All Registered Users</h2>

    <table>
        <thead>
            <tr>
                <th>Email</th>
                <th>Username</th>
                <th>Role</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $result->fetch_assoc()) : ?>
                <tr>
                    <td><?= htmlspecialchars($row['email']) ?></td>
                    <td><?= htmlspecialchars($row['username']) ?></td>
                    <td><?= htmlspecialchars($row['role']) ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>

    <div class="back-link">
        <p><a href="../A_panel/dashboard.php">← Back to Dashboard</a></p>
    </div>
</div>

</body>
</html>
