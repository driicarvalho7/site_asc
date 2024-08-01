<?php
session_start();
if (!isset($_SESSION['loggedin'])) {
    header("Location: ../auth/login.php");
    exit();
}

include '../config/db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = $_POST['titulo'];
    $resumo = $_POST['resumo'];
    $conteudo = $_POST['conteudo'];
    $foto_capa = $_FILES['foto_capa']['name'];
    $foto_baner = $_FILES['foto_baner']['name'];
    $tempo_leitura = $_POST['tempo_leitura'];

    move_uploaded_file($_FILES['foto_capa']['tmp_name'], "../img/" . $foto_capa);
    move_uploaded_file($_FILES['foto_baner']['tmp_name'], "../img/" . $foto_baner);

    $sql = "INSERT INTO blog (titulo, resumo, foto_capa, foto_baner, conteudo, tempo_leitura) 
            VALUES ('$titulo', '$resumo', '$foto_capa', '$foto_baner', '$conteudo', '$tempo_leitura')";

    if ($conn->query($sql) === TRUE) {
        echo "Novo conteúdo inserido com sucesso";
    } else {
        echo "Erro: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ASC Digital</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/submit.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">
    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
</head>
<body>
    <!--header design-->
    <header>
        <a href="../index.php" class="logo"> <img src="../img/logo.png" height="80px" style="padding-left: 30px; padding-top: 5px;"> </a>

        <ul class="navlist">
            <li><a href="../blog/blog.php">Blog</a></li>
        </ul>

        <div class="bx bx-menu" id="menu-icon"></div>
    </header>
        
    <div class="content-container">
        <form action="submit_content.php" method="post" enctype="multipart/form-data">
            <h2>Inserir Conteúdo</h2>
            <label for="titulo">Título:</label>
            <input type="text" id="titulo" name="titulo" required>
            <label for="resumo">Resumo:</label>
            <textarea id="resumo" name="resumo" required></textarea>
            <label for="foto_capa">Foto Capa:</label>
            <input type="file" id="foto_capa" name="foto_capa" required>
            <label for="foto_baner">Foto Baner:</label>
            <input type="file" id="foto_baner" name="foto_baner" required>
            <label for="conteudo">Conteúdo:</label>
            <textarea id="conteudo" name="conteudo" required></textarea>
            <label for="tempo_leitura">Tempo de Leitura (minutos):</label>
            <input type="number" id="tempo_leitura" name="tempo_leitura" required>
            <button type="submit">Enviar</button>
        </form>
    </div>
    
    <!--custom js link-->
    <script type="text/javascript" src="../js/script.js"></script>
</body>
</html>