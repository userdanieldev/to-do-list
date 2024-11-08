<?php
$conn = new mysqli("localhost", "root", "", "todo_list");
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if (isset($_POST['nome'], $_POST['descricao'], $_POST['status'], $_POST['data_limite'])) {
    $nome = $conn->real_escape_string($_POST['nome']);
    $descricao = $conn->real_escape_string($_POST['descricao']);
    $status = $conn->real_escape_string($_POST['status']);
    $data_limite = $conn->real_escape_string($_POST['data_limite']);
    
    $sql = "INSERT INTO tasks (nome, descricao, status, data_limite) VALUES ('$nome', '$descricao', '$status', '$data_limite')";
    $conn->query($sql);
}

$conn->close();
header("Location: index.php");
exit();
