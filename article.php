<?php
session_start();
require_once 'include/db_connect.php';

if (isset($_GET['id'])) {
    $id_article = $_GET['id'];

    $sql = "SELECT id_article, titre, description, date FROM Article WHERE id_article = :id_article";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_article', $id_article, PDO::PARAM_INT);
    $stmt->execute();
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$article) {
        echo "Article non trouvé.";
        exit();
    }
} else {
    echo "ID d'article manquant.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ECF backend">
    <link rel="stylesheet" href="./style/articlestyle.css">
    <title><?php echo htmlspecialchars($article['titre']); ?></title>
<body>
    <header>
        <div>
            <h1>Eco-Pratiques</h1>
        </div>
        <nav>
            <?php if (isset($_SESSION['id_user'])): ?>
                <a href="admin.php">Admin</a>
                <a href="logout.php">Se déconnecter</a>
            <?php else: ?>
                <a href="login.php">Se connecter</a>
                <a href="login.php">Créer un compte</a>
            <?php endif; ?>
        </nav>
    </header>
    <main>
        <article>
            <h2><?php echo htmlspecialchars($article['titre']); ?></h2>
            <p class="date">Publié le : <?php echo htmlspecialchars($article['date']); ?></p>
            <p><?php echo nl2br(htmlspecialchars($article['description'])); ?></p>
        </article>
    </main>
</body>
</html>
