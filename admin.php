<?php 
session_start();

require_once "include/db_connect.php";

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] != 'editeur' && $_SESSION['role'] != 'admin')) {
    header("Location: login_register.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ECF backend">
    <link rel="stylesheet" href="./style/administration.css">
    <title>Page admin</title>
</head>
<body>
    <header>
        <div>
            <h1>Eco-pratiques</h1>
        </div>
        <?php if ($_SESSION['role'] == 'admin'): ?>
        <?php endif; ?>
        <span>Connecté en tant que <?php echo $_SESSION['role']; ?></span>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="logout.php">Se déconnecter</a>
        </nav>
    </header>
    <main>
        <h2>Administration</h2>
        <div class="admin-nav">
            <a href="create_article.php">Créer une bonne pratique</a>
            <a href="edit_article_list.php">Modifier une bonne pratique</a>
            <a href="change_password.php">Modifier le mot de passe</a>
            <a href="edit_profile.php">Modifier le profil</a>
        </div>
    </main>
</body>
</html>