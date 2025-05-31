<?php
$conn = new mysqli("localhost", "root", "", "bcpdr");
$id = (int)$_GET['id'];
$conn->query("DELETE FROM city_master WHERE id = $id");
header("Location: city_master_list.php");
exit();
