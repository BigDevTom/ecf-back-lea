<?php
require_once 'include/db_connect.php';

$sql = "SELECT a.id_article, a.titre, a.description, a.date, u.login FROM Article a JOIN User u ON a.id_user = u.id_user ORDER BY a.date DESC";
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
    <title>Liste des articles</title>
    <link rel="stylesheet" href="./style/list_articles.css">
</head>
<body>
    <header>
        <div>
            <h1>Eco-Pratiques</h1>
        </div>
   
    </header>
    <main>
        <h2>Liste des articles</h2>
        <table>
            <thead>
                <tr>
                    <th>Titre</th>
                    <th>Description</th>
                    <th>Auteur</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($articles as $article): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($article['titre']); ?></td>
                        <td><?php echo htmlspecialchars($article['description']); ?></td>
                        <td><?php echo htmlspecialchars($article['login']); ?></td>
                        <td><?php echo htmlspecialchars($article['date']); ?></td>
                        <td>
                            <a class="view-link" href="article.php?id=<?php echo $article['id_article']; ?>">Voir</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </main>
</body>
</html>
