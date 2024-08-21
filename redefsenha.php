<html>

<head>
    <link rel="stylesheet" type="text/css" href="style1.css">
</head>

<body>
    <?php
    include("conexao.php");

    $erro = []; // Inicializa $erro como um array vazio

    if (isset($_POST["ok"])) {

        $email = $mysqli->escape_string($_POST["email"]);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $erro[] = "E-mail inválido";
        }

        // Verifica se o e-mail está no banco de dados
        $sql = "SELECT * FROM tbl_usuario WHERE email = '$email'";
        $result = $mysqli->query($sql);

        if ($result->num_rows > 0) {
            // Se o e-mail existe no banco de dados, prossegue com a redefinição de senha
            if (count($erro) == 0) {

                // Gera uma nova senha usando a função md5 e a função time do PHP, e pega os primeiros 6 caracteres
                $novasenha = substr(md5(time()), 0, 6);
                // Usa a função password_hash do PHP para criar um hash seguro da nova senha
                $novasenha_hash = password_hash($novasenha, PASSWORD_DEFAULT);

                // Envia a nova senha por e-mail. Não pude testar no meu servidor, mas funciona, uma vez que retorna o erro :)
                if (mail($email, "Sua nova senha de acesso", "Sua nova senha é:" . $novasenha)) {
                    $sql_code = "UPDATE login SET senha = '$novasenha_hash' WHERE email = '$email'";
                    $sql_query = $mysqli->query($sql_code) or die($mysqli->error);
                }

                // Imprime a nova senha na tela (apenas para demonstração!)
                echo "Senha gerada: $novasenha";
            }
        } else {
            // Mensagem de erro de e-mail não encontrado
            echo "E-mail não encontrado no banco de dados.";
        }
    }

    if (count($erro) > 0) {
        foreach ($erro as $msg) {
            echo "<p>$msg</p>";
        }
    }
    ?>
    <h1>Redefinição de senha</h1>

    <form action="" method="post">
        <div>
            <label>Digite o e-mail cadastrado</label>
        </div>

        <div>
            <input placeholder="Seu e-mail" name="email" type="text" style="width: 300px;">
        </div>

        <div>
            <input name="ok" value="Ok" type="submit">
        </div>

    </form>

</body>

</html>