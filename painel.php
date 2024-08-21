<?php
// Inicia a sessão se ela ainda não foi iniciada
if (!isset($_SESSION)) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Define a codificação de caracteres do documento -->
    <meta charset="UTF-8">
    <!-- Define a compatibilidade com o Internet Explorer -->
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Define a viewport para dispositivos móveis -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Define o título do documento -->
    <title>Painel</title>
    <link rel="stylesheet" type="text/css" href="style1.css">
</head>

<body>
    <!-- Exibe uma mensagem de boas-vindas ao usuário -->
    Seja bem-vindo(a), <?php echo $_SESSION['nome']; ?>.

    <p>
        <!-- Link para a página de cadastro de alunos -->
        <a href="cadastro_aluno.php" class="button">Cadastro de Aluno</a>
    </p>

    <p>
        <!-- Link para sair (encerrar a sessão) -->
        <a href="logout.php">Sair</a>
    </p>
</body>

</html>