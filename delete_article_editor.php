<?php
session_start();

require_once 'include/db_connect.php';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'editor') {
    header("Location: login_register.php");
    exit();
}

if (isset($_GET['id'])) {
    $id_article = $_GET['id'];
    
    $sql = "SELECT id_user FROM Article WHERE id_article = :id_article";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_article', $id_article, PDO::PARAM_INT);
    $stmt->execute();
    $article = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($article && $article['id_user'] == $_SESSION['user_id']) {
        $sql = "DELETE FROM Article WHERE id_article = :id_article";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_article', $id_article, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $success = "Article supprimé avec succès.";
        } else {
            $error = "Erreur lors de la suppression de l'article.";
        }
    } else {
        $error = "Vous n'avez pas la permission de supprimer cet article.";
    }
}

header("Location: edit_article_list.php");
exit();
?>
