<?php
session_start();

require_once 'include/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login_register.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $error = "Tous les champs sont obligatoires.";
    } elseif ($new_password != $confirm_password) {
        $error = "Les mots de passe ne correspondent pas.";
    } else {
        $sql = "SELECT password FROM User WHERE id_user = :id_user";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id_user', $_SESSION['user_id'], PDO::PARAM_INT);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($current_password, $user['password'])) {
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $sql = "UPDATE User SET password = :password WHERE id_user = :id_user";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':password', $hashed_password, PDO::PARAM_STR);
            $stmt->bindParam(':id_user', $_SESSION['user_id'], PDO::PARAM_INT);

            if ($stmt->execute()) {
                $success = "Mot de passe modifié avec succès.";
            } else {
                $error = "Erreur lors de la modification du mot de passe.";
            }
        } else {
            $error = "Mot de passe actuel incorrect.";
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
    <link rel="stylesheet" href="./style/change_password.css">
    <title>Modification du mot de passe</title>
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
        <h2>Modifier le mot de passe</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>
        <form method="POST" action="change_password.php">
            <label for="current_password">Mot de passe actuel:</label>
            <input type="password" id="current_password" name="current_password" required>
            <label for="new_password">Nouveau mot de passe:</label>
            <input type="password" id="new_password" name="new_password" required>
            <label for="confirm_password">Confirmer le nouveau mot de passe:</label>
            <input type="password" id="confirm_password" name="confirm_password" required>
            <input type="submit" value="Modifier le mot de passe">
        </form>
    </main>   
</body>
</html>