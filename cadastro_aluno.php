<?php
include("conexao.php");

if (isset($_POST["cadastrar"])) { //Verifica se o botão foi pressionado
    // A função escape_string é usada para prevenir ataques de injeção SQL.
    $nomealuno = $mysqli->escape_string($_POST["nomealuno"]);
    $nota1 = $mysqli->escape_string($_POST["nota1"]);
    $nota2 = $mysqli->escape_string($_POST["nota2"]);
    $nota_examefinal = isset($_POST["nota_examefinal"]) ? $mysqli->escape_string($_POST["nota_examefinal"]) : 0;

    $media_provisoria = ($nota1 + $nota2) / 2;
    $media_final = $media_provisoria; // Inicializa a variável $media_final com a média provisória

    //Condições das "situações" do aluno. Escolhi por não criar outra coluna no banco de dados.
    if ($media_provisoria >= 7) {
        $situacao = "aprovado direto";
    } elseif ($media_provisoria < 4) {
        $situacao = "reprovado direto";
    } else {
        $media_final = ($media_provisoria + $nota_examefinal) / 2;
        if ($media_final >= 5) {
            $situacao = "aprovado pós-exame";
        } else {
            $situacao = "reprovado pós-exame";
        }
    }

    // Cria uma string SQL para inserir os dados do aluno na tabela 'tbl_notas'
    $sql = "INSERT INTO tbl_notas (nomealuno, nota1, nota2, media_provisoria, nota_examefinal, media_final) VALUES ('$nomealuno', '$nota1', '$nota2', '$media_provisoria', '$nota_examefinal', '$media_final')";
    // Executa a consulta e encerra o script em caso de erro, após mostrar a mensagem
    $mysqli->query($sql) or die($mysqli->error);

    echo "A situação do aluno $nomealuno (nota final: $media_final) é: $situacao<br>";
}
?>

<head>
    <link rel="stylesheet" type="text/css" href="style1.css">
</head>

<body>
    <h1>Cadastro do aluno</h1>
    <form action="" method="post" id="formNotas" onsubmit="return validarNotas();">
        <input placeholder="Nome do aluno" name="nomealuno" type="text" required>
        <input placeholder="Nota 1" name="nota1" type="number" id="nota1" required>
        <input placeholder="Nota 2" name="nota2" type="number" id="nota2" required>
        <input placeholder="Nota do exame final" name="nota_examefinal" type="number" id="nota_examefinal" required>
        <button type="submit" name="cadastrar">Cadastrar</button>
    </form>

    <script>
        document.getElementById('formNotas').addEventListener('submit', function(e) {
            var nota1 = parseFloat(document.getElementById('nota1').value);
            var nota2 = parseFloat(document.getElementById('nota2').value);
            var media_provisoria = (nota1 + nota2) / 2;

            if (media_provisoria < 4 || media_provisoria >= 7) {
                document.getElementById('nota_examefinal').disabled = true;
            }
        });
    </script>

    <table>
        <thead>
            <tr>
                <th>Nome do aluno</th>
                <th>Nota 1</th>
                <th>Nota 2</th>
                <th>Média Provisória</th>
                <th>Nota do Exame Final</th>
                <th>Média Final</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $sql = "SELECT * FROM tbl_notas";
            $result = $mysqli->query($sql);

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['nomealuno'] . "</td>";
                echo "<td>" . $row['nota1'] . "</td>";
                echo "<td>" . $row['nota2'] . "</td>";
                echo "<td>" . $row['media_provisoria'] . "</td>";
                echo "<td>" . $row['nota_examefinal'] . "</td>";
                echo "<td>" . $row['media_final'] . "</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</body>