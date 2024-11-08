<?php
$conn = new mysqli("localhost", "root", "", "todo_list");
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

if (isset($_GET['id'])) {
    $id = (int)$_GET['id'];
    $sql = "SELECT * FROM tasks WHERE id = $id";
    $result = $conn->query($sql);
    $task = $result->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];
    $nome = $conn->real_escape_string($_POST['nome']);
    $descricao = $conn->real_escape_string($_POST['descricao']);
    $status = $conn->real_escape_string($_POST['status']);
    $data_limite = $conn->real_escape_string($_POST['data_limite']);

    $sql = "UPDATE tasks SET nome='$nome', descricao='$descricao', status='$status', data_limite='$data_limite' WHERE id = $id";
    $conn->query($sql);
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Tarefa - TO DO LIST DAN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #32CD32; 
            --text-dark: #000;
        }
        body {
            background-color: #FFF;
            color: var(--text-dark);
        }
        h2 {
            color: var(--primary-color);
        }
        .btn-save {
            background-color: var(--primary-color);
            color: #FFF;
        }
        .btn-save:hover {
            background-color: #28a745;
        }
        .btn-back {
            background-color: #000;
            color: #FFF;
        }
        .theme-toggle-btn {
            position: fixed;
            top: 10px;
            right: 10px;
            z-index: 1000;
        }
        .theme-toggle-btn {
            cursor: pointer;
            background-color: transparent; 
            border: none; 
            color: var(--primary-color); 
        }
        .theme-toggle-btn:hover {
            background-color: var(--primary-color); 
            color: #FFF; 
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Editar Tarefa</h2>
        
        <button class="btn theme-toggle-btn" onclick="toggleTheme()">🌞/🌙</button>

        <form action="edit_task.php" method="POST" class="my-4">
            <input type="hidden" name="id" value="<?= $task['id']; ?>">
            <div class="mb-3">
                <label class="form-label">Nome</label>
                <input type="text" name="nome" class="form-control" value="<?= htmlspecialchars($task['nome']); ?>" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea name="descricao" class="form-control"><?= htmlspecialchars($task['descricao']); ?></textarea>
            </div>
            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="Pendente" <?= $task['status'] == 'Pendente' ? 'selected' : ''; ?>>Pendente</option>
                    <option value="Em Progresso" <?= $task['status'] == 'Em Progresso' ? 'selected' : ''; ?>>Em Progresso</option>
                    <option value="Concluído" <?= $task['status'] == 'Concluído' ? 'selected' : ''; ?>>Concluído</option>
                </select>
            </div>
            <div class="mb-3">
                <label class="form-label">Data Limite</label>
                <input type="date" name="data_limite" class="form-control" value="<?= $task['data_limite']; ?>">
            </div>
            <button type="submit" class="btn btn-save w-100">Salvar</button>
        </form>
        <a href="index.php" class="btn btn-back w-100 mt-3">Voltar para a Home</a>
    </div>

    <script>
        function toggleTheme() {
            const theme = document.documentElement.getAttribute("data-bs-theme") === "dark" ? "light" : "dark";
            document.documentElement.setAttribute("data-bs-theme", theme);
            document.body.classList.toggle("bg-dark", theme === "dark");
            document.body.classList.toggle("text-light", theme === "dark");
            document.body.classList.toggle("bg-light", theme === "light");
            document.body.classList.toggle("text-dark", theme === "light");
            localStorage.setItem("theme", theme);
        }

        document.addEventListener("DOMContentLoaded", () => {
            const savedTheme = localStorage.getItem("theme") || "light";
            document.documentElement.setAttribute("data-bs-theme", savedTheme);
            document.body.classList.toggle("bg-dark", savedTheme === "dark");
            document.body.classList.toggle("text-light", savedTheme === "dark");
            document.body.classList.toggle("bg-light", savedTheme === "light");
            document.body.classList.toggle("text-dark", savedTheme === "light");
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php $conn->close(); ?>
