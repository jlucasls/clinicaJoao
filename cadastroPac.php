<?php
require 'conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = $_POST['nome'];
    $data_nascimento = $_POST['data_nascimento'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $endereco = $_POST['endereco'];
    $sexo = $_POST['sexo'];

    $data_maioridade = date('Y-m-d', strtotime('-18 years'));
    if ($data_nascimento > $data_maioridade) {
        echo "<div class='alert alert-danger'>Erro: O paciente deve ser maior de idade.</div>";
        exit;
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO pacientes (nome, data_nascimento, email, telefone, endereco, sexo) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->execute([$nome, $data_nascimento, $email, $telefone, $endereco, $sexo]);
        echo "<div class='alert alert-success'>Cadastro realizado com sucesso!</div>";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            echo "<div class='alert alert-danger'>Erro: E-mail já cadastrado!</div>";
        } else {
            echo "<div class='alert alert-danger'>Erro ao cadastrar paciente: " . $e->getMessage() . "</div>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Cadastro de Paciente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container">
    <div class="container2">
    <h1 id="title1">Cadastro de Paciente</h1>          
    <form  id="form1" method="POST">
        <div class="mb-3">
            <input type="text" name="nome" class="form-control" placeholder="Nome Completo" required>
        </div>
        <div class="mb-3">
            <input id="input1" type="date" name="data_nascimento" class="form-control" required>
        </div>
        <div class="mb-3">
            <input id="input1" type="email" name="email" class="form-control" placeholder="E-mail" required>
        </div>
        <div class="mb-3">
            <input id="input1" type="text" name="telefone" class="form-control" placeholder="Telefone" required>
        </div>
        <div class="mb-3">
            <input id="input1" type="text" name="endereco" class="form-control" placeholder="Endereço">
        </div>
        <div class="mb-3">
            <select name="sexo" class="form-control" required>
                <option value="masculino">Masculino</option>
                <option value="feminino">Feminino</option>
                <option value="outro">Outro</option>
            </select>
        </div>
        <div class="btn1">
        <button type="submit" class="btn btn-primary">Cadastrar</button>
        </div>
    </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
