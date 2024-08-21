<?php
include("conexao.php");

$erro = []; // Inicializa $erro como um array vazio

if (isset($_POST["criar"])) {
    $nome = $mysqli->escape_string($_POST["nome"]);
    $email = $mysqli->escape_string($_POST["email"]);
    $senha = $mysqli->escape_string($_POST["senha"]);

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $erro[] = "E-mail inválido";
    }

    // Verifica se o e-mail já está no banco de dados
    $sql = "SELECT * FROM tbl_usuario WHERE email = '$email'";
    $result = $mysqli->query($sql);

    if ($result->num_rows > 0) {
        $erro[] = "E-mail já cadastrado";
    }

    // Se não houver erros, insere o novo usuário no banco de dados
    if (count($erro) == 0) {
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT); // Hash da senha
        // Prepara a consulta SQL
        $stmt = $mysqli->prepare("INSERT INTO tbl_usuario (nome, email, senha) VALUES (?, ?, ?)");
        if ($stmt === false) {
            die("Erro ao preparar a consulta: " . $mysqli->error);
        }

        // Vincula os parâmetros à consulta preparada
        if ($stmt->bind_param("sss", $nome, $email, $senha_hash) === false) {
            die("Erro ao vincular os parâmetros: " . $stmt->error);
        }

        // Executa a consulta preparada
        if ($stmt->execute() === false) {
            die("Erro ao executar a consulta: " . $stmt->error);
        }

        echo "Sua conta foi criada com sucesso!";
    }
}
?>

<html>

<head>
    <link rel="stylesheet" type="text/css" href="style1.css">
</head>

<body>
    <?php
    if (count($erro) > 0) {
        foreach ($erro as $msg) {
            echo "<p>$msg</p>";
        }
    }
    ?>
    <h1>Crie sua conta</h1>

    <form action="" method="post">
        <input placeholder="Seu nome" name="nome" type="text">
        <input placeholder="Seu e-mail" name="email" type="text">
        <input placeholder="Sua senha" name="senha" type="password">
        <input name="criar" value="Criar conta" type="submit">
    </form>
</body>