<?php 
session_start();

require_once "include/db_connect.php";

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] != 'editor' && $_SESSION['role'] != 'admin')) {
    header("Location: login_register.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titre = $_POST['titre'];
    $description = $_POST['description'];
    $id_user = $_SESSION['user_id'];

    if (empty($titre) || empty($description)) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        $sql = "INSERT INTO article (id_user, titre, description, date) VALUES (:id_user, :titre, :description, NOW())";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_user', $id_user, PDO::PARAM_INT);
        $stmt->bindParam(':titre', $titre, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);

        if ($stmt->execute()) {
            header("Location: index.php");
            exit();
        } else {
            $error = "Erreur lors de la création de l'article.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ECF backend">
    <link rel="stylesheet" href="./style/create_artcile.css">
    <title>Creation de bonne pratique</title>
</head>
<body>
<header>
        <div>
            <h1>Eco-Pratiques</h1>
        </div>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="create_article.php">Créer un article</a>
            <a href="logout.php">Se déconnecter</a>
        </nav>
    </header>
    <main>
        <h2>Créer un article</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form method="POST" action="create_article.php">
            <label for="titre">Titre:</label>
            <input type="text" id="titre" name="titre" required>
            <label for="description">Description:</label>
            <textarea id="description" name="description" rows="10" required></textarea>
            <input type="submit" value="Créer">
        </form>
    </main>
</body>
</html>