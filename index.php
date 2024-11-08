<?php
$conn = new mysqli("localhost", "root", "", "todo_list");
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$sql = "SELECT * FROM tasks";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TO DO LIST DAN</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #32CD32;
            --bg-dark: #000;
            --text-light: #FFF;
        }
        body {
            background-color: var(--primary-color);
            color: var(--text-light);
        }
        .navbar {
            background-color: #000;
            color: var(--text-light);
        }
        .navbar-brand {
            font-weight: bold;
            color: var(--primary-color);
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
        .list-group-item {
            background-color: var(--bg-dark);
            color: var(--text-light);
            border-left: 5px solid #FFF;
            transition: all 0.3s ease;
        }
        .list-group-item.pending { border-color: #ffeb3b; }
        .list-group-item.in-progress { border-color: #0dcaf0; }
        .list-group-item.completed { border-color: #198754; }
        .btn-add {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            color: #FFF;
        }
        .btn-add:hover {
            background-color: #28a745;
            border-color: #28a745;
        }
        footer {
            background-color: #000;
            color: var(--text-light);
            text-align: center;
            padding: 10px 0;
            width: 100%;
            bottom: 0;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="#">TO DO LIST DAN</a>
        </div>
    </nav>

    <div class="container mt-5 mb-5">
        <button class="btn btn-outline-light theme-toggle-btn" onclick="toggleTheme()">🌞/🌙</button>

        <form action="add_task.php" method="POST" class="my-4">
            <div class="input-group mb-3">
                <input type="text" name="nome" class="form-control" placeholder="Nome da Tarefa" required>
            </div>
            <div class="input-group mb-3">
                <input type="text" name="descricao" class="form-control" placeholder="Descrição da Tarefa">
            </div>
            <div class="input-group mb-3">
                <select name="status" class="form-select">
                    <option value="Pendente">Pendente</option>
                    <option value="Em Progresso">Em Progresso</option>
                    <option value="Concluído">Concluído</option>
                </select>
            </div>
            <div class="input-group mb-3">
                <input type="date" name="data_limite" class="form-control">
            </div>
            <button class="btn btn-add w-100" type="submit">Adicionar</button>
        </form>

        <ul class="list-group mb-5">
            <?php while ($row = $result->fetch_assoc()): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center 
                    <?= $row['status'] == 'Pendente' ? 'pending' : ($row['status'] == 'Em Progresso' ? 'in-progress' : 'completed'); ?>">
                    <div>
                        <h5><?= htmlspecialchars($row['nome']); ?></h5>
                        <p class="mb-1"><?= htmlspecialchars($row['descricao']); ?></p>
                        <small>Data Limite: <?= $row['data_limite'] ? date("d/m/Y", strtotime($row['data_limite'])) : "Sem data"; ?></small>
                    </div>
                    <div class="text-end">
                        <span class="badge bg-<?= $row['status'] == 'Pendente' ? 'warning' : ($row['status'] == 'Em Progresso' ? 'info' : 'success'); ?>">
                            <?= $row['status']; ?>
                        </span>
                        <a href="edit_task.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-warning">✏️</a>
                        <a href="delete_task.php?id=<?= $row['id']; ?>" class="btn btn-sm btn-danger">🗑️</a>
                    </div>
                </li>
            <?php endwhile; ?>
        </ul>
    </div>

    <footer>
        <p>&copy; 2024 Daniel Costa</p>
    </footer>

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
