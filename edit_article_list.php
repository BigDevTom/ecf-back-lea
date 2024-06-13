<?php
session_start();

require_once 'include/db_connect.php';

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] != 'editor' && $_SESSION['role'] != 'admin')) {
    header("Location: login_register.php");
    exit();
}

if ($_SESSION['role'] == 'admin') {
    $sql = "SELECT id_article, titre, date, id_user FROM Article ORDER BY date DESC";
} else {
    $sql = "SELECT id_article, titre, date, id_user FROM Article WHERE id_user = :id_user ORDER BY date DESC";
}

$stmt = $pdo->prepare($sql);
if ($_SESSION['role'] != 'admin') {
    $stmt->bindParam(':id_user', $_SESSION['user_id'], PDO::PARAM_INT);
}
$stmt->execute();
$articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ECF backend">
    <link rel="stylesheet" href="./style/edit_article_list.css">
    <title>Liste de bonne pratique</title>
</head>
<body>
<header>
        <div>
            <h1>Eco-Pratiques</h1>
        </div>
        <?php if ($_SESSION['role'] == 'editor'): ?>
            <?php endif; ?>
        <span>Connecté en tant que <?php echo $_SESSION['role']; ?></span>
        <nav>
            <a href="index.php">Accueil</a>
            <a href="logout.php">Se déconnecter</a>
        </nav>
    </header>
    <main>
        <h2>Modifier une bonne pratique</h2>
        <table>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Date</th>
                    <th>Action</th>
                    <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'editor'): ?>
                        <th>Supprimer</th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($articles as $article): ?>
                <tr>
                    <td><?php echo htmlspecialchars($article['titre']); ?></td>
                    <td><?php echo htmlspecialchars($article['date']); ?></td>
                    <td>
                        <a class="edit-link" href="edit_article.php?id=<?php echo $article['id_article']; ?>">Modifier</a>
                    </td>
                    <?php if ($_SESSION['role'] == 'admin'): ?>
                        <td>
                            <a class="delete-link" href="delete_article.php?id=<?php echo $article['id_article']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">Supprimer</a>
                        </td>
                    <?php elseif ($_SESSION['role'] == 'editor' && $article['id_user'] == $_SESSION['user_id']): ?>
                        <td>
                            <a class="delete-link" href="delete_article_editor.php?id=<?php echo $article['id_article']; ?>" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">Supprimer</a>
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach; ?>
        </tbody>
        </table>
    </main>
</body>
</html>