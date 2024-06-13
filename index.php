<?php
session_start();

require_once 'include/db_connect.php';

$sql = "SELECT id_article, titre, description, date FROM Article ORDER BY date DESC LIMIT 3";
$stmt = $pdo->prepare($sql);
$stmt->execute();
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ECF backend">
    <link rel="stylesheet" href="./style/style.css">
    <title>Accueil</title>
</head>
<body>
    <header>
        <div>
            <h1>Eco-Pratiques</h1>
        </div>
        <nav>
            <?php if (isset($_SESSION['user_id'])): ?>
                <?php if ($_SESSION['role'] == 'admin'): ?>
                    <a href="admin.php">Mon espace</a>
                <?php elseif ($_SESSION['role'] == 'editor'): ?>
                    <a href="editor.php">Mon espace</a>
                <?php endif; ?>
                <a href="logout.php">Se déconnecter</a>
            <?php else: ?>
                <a href="login_register.php">Se connecter</a>
            <?php endif; ?>
        </nav>
    </header>  
    <main>
        <h2>Dernières publications</h2>
        <?php foreach ($articles as $article): ?>
            <article>
                <h2><?php echo htmlspecialchars($article['titre']); ?></h2>
                <p><?php echo htmlspecialchars($article['description']); ?></p>
                <p><small>Publié le : <?php echo htmlspecialchars($article['date']); ?></small></p>
                <a href="article.php?id=<?php echo $article['id_article']; ?>">LIRE</a>
            </article>
        <?php endforeach; ?>
        <a id="voir-plus" href="liste_article.php">Voir plus</a>
    </main>        
</body>
</html>