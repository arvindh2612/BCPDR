<?php
$conn = new mysqli("localhost", "root", "", "bcpdr");
$id = (int)$_GET['id'];
$conn->query("DELETE FROM corrective_preventive_action_report WHERE id = $id");
header("Location: cpar_list.php");
exit();
