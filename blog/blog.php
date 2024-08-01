<?php
    include '../config/db_connection.php';

    // Pagination logic
    $results_per_page = 16; // 4 columns x 5 rows
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $start_from = ($page-1) * $results_per_page;

    // Fetching total number of blogs
    $sql_total = "SELECT COUNT(id) AS total FROM blog";
    $result_total = $conn->query($sql_total);
    $total_rows = $result_total->fetch_assoc()['total'];
    $total_pages = ceil($total_rows / $results_per_page);

    // Fetching blogs with limit
    $sql = "SELECT id, titulo, resumo, foto_capa, conteudo, tempo_leitura, data_criacao FROM blog ORDER BY data_criacao DESC LIMIT $start_from, $results_per_page";
    $result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog - ASC Digital</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <link rel="stylesheet" type="text/css" href="../css/blog.css">
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
        <a href="../index.php" class="logo"> <img src="../img/logo.png" height="80px" style="padding-left: 30px; padding-top: 5px;"> </a>
        <ul style="display: flex; flex-direction: row; align-items: center; justify-content: space-between; width: 100%;">
            <li style="margin-left: 1rem; margin-right: 1rem; width: 100%">
                <form id="search-form" action="search.php" method="get">
                    <input type="text" name="query" placeholder="Pesquisar..." required>
                    <button type="submit"><i class="bi bi-search"></i></button>
                </form>
            </li>
            <li>
                <a href="../auth/login.php">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-lock" viewBox="0 0 16 16">
                        <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2M5 8h6a1 1 0 0 1 1 1v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V9a1 1 0 0 1 1-1"/>
                    </svg>
                </a>
            </li>
        </ul>
    </header>
    
    <div class="blog-container" id="blog" style="margin-top: 80px;">
        <?php
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo '<div class="blog-card" onclick="location.href=\'blog_content.php?id=' . $row['id'] . '\'">';
                    echo '  <img src="../img/' . $row['foto_capa'] . '" alt="' . $row['titulo'] . '">';
                    echo '  <div class="blog-card-content">';
                    echo '      <h2 class="blog-card-title">' . $row['titulo'] . '</h2>';
                    echo '      <p class="blog-card-summary">' . substr($row['resumo'], 0, 100) . '...</p>';
                    echo '      <div class="blog-card-meta">';
                    echo '          <span>' . $row['data_criacao'] . '</span>';
                    echo '          <span>Leitura: ' . $row['tempo_leitura'] . ' min</span>';
                    echo '      </div>';
                    echo '  </div>';
                    echo '</div>';
                }
            } else {
                echo "0 resultados";
            }
        ?>
    </div>

    <div class="pagination">
        <?php
            if ($page > 1) {
                echo '<a href="blog.php?page=' . ($page - 1) . '">&laquo; Anterior</a>';
            }
            for ($i = 1; $i <= $total_pages; $i++) {
                echo '<a href="blog.php?page=' . $i . '"';
                if ($i == $page) {
                    echo ' class="active"';
                }
                echo '>' . $i . '</a>';
            }
            if ($page < $total_pages) {
                echo '<a href="blog.php?page=' . ($page + 1) . '">Próximo &raquo;</a>';
            }
        ?>
    </div>
    
    <!--custom js link-->
    <script type="text/javascript" src="../js/script.js"></script>
</body>
</html>