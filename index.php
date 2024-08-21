<?php
include('conexao.php');

if (isset($_POST['email']) || isset($_POST['senha'])) {

    if (strlen($_POST['email']) == 0) {
        echo "Preencha seu e-mail.";
    } else if (strlen($_POST["senha"]) == 0) {
        echo "Preencha sua senha.";
    } else {

        // Limpa a entrada do usuário para prevenir injeção SQL
        $email = $mysqli->real_escape_string($_POST['email']);
        $senha = $mysqli->real_escape_string($_POST['senha']);

        $sql_code = "SELECT * FROM tbl_usuario WHERE email = '$email'";
        $sql_query = $mysqli->query($sql_code) or die($mysqli->error);

        $quantidade = $sql_query->num_rows;

        if ($quantidade == 1) {

            $tbl_usuario = $sql_query->fetch_assoc();

            if (password_verify($senha, $tbl_usuario['senha'])) {

                if (!isset($_SESSION)) {
                    session_start();
                }

                $_SESSION['id'] = $tbl_usuario['id'];
                $_SESSION['nome'] = $tbl_usuario['nome'];

                header("Location: painel.php");
            } else {
                echo "Falha ao logar! Senha incorreta";
            }
        } else {
            echo "Falha ao logar! E-mail não encontrado";
        }
    }
}
?>
<!DOCTYPE html>
<HTML lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-COMPATIBLE" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="style1.css">
</head>

<body>
    <h1>Sistema de notas - Entrar</h1>
    <form action="" method="POST">

        <div>
            <label>E-mail</label>
        </div>

        <div>
            <input type="text" name="email" style="width: 300px;">
        </div>

        <div>
            <label>Senha</label>
        </div>

        <div>
            <input type="password" name="senha" style="width: 300px;">
        </div>

        <div>
            <button type="submit">Entrar</button>
        </div>

        <div>
            <a href="redefsenha.php">Esqueci minha senha</a>
        </div>

        <h2>Ainda nao é cadastrado?</h2>
        <a href="criaconta.php">Criar conta</a>

    </form>
</body>

</HTML>