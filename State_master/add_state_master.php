<?php
$conn = new mysqli("localhost", "root", "", "bcpdr");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $state_code = $conn->real_escape_string($_POST["state_code"]);
    $state_name = $conn->real_escape_string($_POST["state_name"]);

    $conn->query("INSERT INTO state_master (state_code, state_name) 
                  VALUES ('$state_code', '$state_name')");

    header("Location: state_master_list.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add State</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Add State</span>
        <a href="state_master_list.php" class="text-light text-decoration-none">📄 Back to List</a>
    </div>
</nav>

<div class="container mt-4">
    <h2>Add State</h2>
    <form method="post">
        <div class="mb-3">
            <label>State Code</label>
            <input type="text" name="state_code" class="form-control" required maxlength="3">
        </div>
        <div class="mb-3">
            <label>State Name</label>
            <input type="text" name="state_name" class="form-control" required maxlength="40">
        </div>
        <button type="submit" class="btn btn-primary">Add State</button>
    </form>
</div>
<br>
<footer class="bg-dark text-white text-center py-3">
    © 2025 BCPDR System. All rights reserved.
</footer>
</body>
</html>
