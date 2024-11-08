<?php
$conn = new mysqli("localhost", "root", "", "todo_list");
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "UPDATE tasks SET status = NOT status WHERE id = $id";
    $conn->query($sql);
}

$conn->close();
header("Location: index.php");
exit();
