CREATE DATABASE todo_list;
USE todo_list;

CREATE TABLE IF NOT EXISTS tasks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    status ENUM('Pendente', 'Em Progresso', 'Concluído') DEFAULT 'Pendente',
    data_limite DATE
);