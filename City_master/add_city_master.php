<?php
$conn = new mysqli("localhost", "root", "", "bcpdr");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $city_code = $conn->real_escape_string($_POST["city_code"]);
    $city_name = $conn->real_escape_string($_POST["city_name"]);
    $state_code = $conn->real_escape_string($_POST["state_code"]);

    $conn->query("INSERT INTO city_master (city_code, city_name, state_code) 
                  VALUES ('$city_code', '$city_name', '$state_code')");

    header("Location: city_master_list.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add City</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container-fluid">
        <span class="navbar-brand">Add City</span>
        <a href="city_master_list.php" class="text-light text-decoration-none">📄 Back to List</a>
    </div>
</nav>

<div class="container mt-4">
    <h2>Add City</h2>
    <form method="post">
        <div class="mb-3">
            <label>City Code</label>
            <input type="text" name="city_code" class="form-control" required maxlength="3">
        </div>
        <div class="mb-3">
            <label>City Name</label>
            <input type="text" name="city_name" class="form-control" required maxlength="40">
        </div>
        <div class="mb-3">
            <label>State Code</label>
            <input type="text" name="state_code" class="form-control" required maxlength="3">
        </div>
        <button type="submit" class="btn btn-primary">Add City</button>
    </form>
</div>
<br>
<footer class="bg-dark text-white text-center py-3">
    © 2025 BCPDR System. All rights reserved.
</footer>
</body>
</html>
