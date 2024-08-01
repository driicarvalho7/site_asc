<?php
    include '../config/db_connection.php';

    function slugify($text) {
        $text = preg_replace('~[^\pL\d]+~u', '-', $text);
        $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        $text = preg_replace('~[^-\w]+~', '', $text);
        $text = trim($text, '-');
        $text = preg_replace('~-+~', '-', $text);
        $text = strtolower($text);
        return empty($text) ? 'n-a' : $text;
    }

    if (isset($_GET['id'])) {
        $id = intval($_GET['id']);
        $sql = "SELECT titulo, resumo, foto_baner, conteudo, tempo_leitura, data_criacao FROM blog WHERE id=$id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            echo "Blog não encontrado.";
            exit();
        }
    } else {
        echo "ID inválido.";
        exit();
    }

    $pageTitle = $row['titulo'];
    $pageSlug = slugify($pageTitle);

    // Redirect to the friendly URL if not already there
    if (!isset($_GET['slug']) || $_GET['slug'] !== $pageSlug) {
        header("Location: blog_content.php?id=$id&slug=$pageSlug");
        exit();
    }

    $whatsappMessage = urlencode("Olá! Tenho interesse nos seu serviços. Vim do conteúdo $pageTitle do seu blog.");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?> - ASC Digital</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/blog_content.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons@latest/css/boxicons.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="shortcut icon" href="../img/logo.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <!--header design-->
    <header>
        <div class="logo-container">
            <a href="../index.php" class="logo"> <img src="../img/logo.png" height="40px"> </a>
        </div>

        <ul class="navlist">
            <li><a href="../blog/blog.php">Ver o Blog</a></li>
        </ul>

        <div class="bx bx-menu" id="menu-icon"></div>

        <div class="cta-container">
            <button class="cta-button" onclick="window.location.href='../contact/contact.php'">Gostou? 🤗 Entre em contato 📲</button>
        </div>
    </header>

    <div class="blog-detail-container">
        <div class="blog-detail-card">
            <img src="../img/<?php echo $row['foto_baner']; ?>" alt="<?php echo $row['titulo']; ?>" class="blog-detail-image">
            <div class="blog-detail-content">
                <h1 class="blog-detail-title"><?php echo $row['titulo']; ?></h1>
                <p class="blog-detail-meta">Publicado em <?php echo $row['data_criacao']; ?> | Leitura: <?php echo $row['tempo_leitura']; ?> min</p>
                <div class="blog-detail-body"><?php echo nl2br($row['conteudo']); ?></div>
            </div>
        </div>
    </div>
    
    <!-- WhatsApp contact icon -->
    <a href="https://wa.me/5519992490898?text=<?php echo $whatsappMessage; ?>" class="whatsapp-contact" target="_blank">
        <i class="bi bi-whatsapp"></i>
    </a>
    
    <!--custom js link-->
    <script type="text/javascript" src="../js/script.js"></script>
</body>
</html>
