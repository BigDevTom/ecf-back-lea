<?php 
session_start();

require_once 'include/db_connect.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] != 'editor' && $_SESSION['role'] != 'admin')) {
    header("Location: login_register.php");
    exit();
}

if (isset($_GET['id'])) {
    $id_article = $_GET['id'];

    $sql = "SELECT id_article, titre, description FROM article WHERE id_article = :id_article";
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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $_POST['titre'];
    $description = $_POST['description'];

    if (empty($titre) || empty($description)) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        $sql = "UPDATE Article SET titre = :titre, description = :description WHERE id_article = :id_article";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':titre', $titre, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':id_article', $id_article, PDO::PARAM_INT);

        if ($stmt->execute()) {
            header("Location: edit_article_list.php");
            exit();
        } else {
            $error = "Erreur lors de la modification de l'article.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ECF Backend">
    <link rel="stylesheet" href="./style/edit_article.css">
    <title>Modifier une bonne pratique</title>
</head>
<body>
    <header>
        <div>
            <h1>Eco-Pratiques</h1>
        </div>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="admin.php">Administration</a>
            <a href="logout.php">Se déconnecter</a>
        </nav>
    </header>
    <main>
        <h2>Modifier un article</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" action="edit_article.php?id=<?php echo $article['id_article']; ?>">
            <label for="titre">Titre:</label>
            <input type="text" id="titre" name="titre" value="<?php echo htmlspecialchars($article['titre']); ?>" required>
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="10" required><?php echo htmlspecialchars($article['description']); ?></textarea>
            <input type="submit" value="Modifier">
        </form>
    </main> 
</body>
</html>