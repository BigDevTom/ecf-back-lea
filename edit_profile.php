<?php
session_start();

require_once 'include/db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login_register.php");
    exit();
}

$login = '';
$email = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $login = $_POST['login'];
    $email = $_POST['email'];

    if (empty($login) || empty($email)) {
        $error = "Tous les champs sont obligatoires.";
    } else {
        $sql = "UPDATE User SET login = :login, email = :email WHERE id_user = :id_user";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':id_user', $_SESSION['user_id'], PDO::PARAM_INT);

        if ($stmt->execute()) {
            $success = "Profil modifié avec succès.";
            $_SESSION['login'] = $login;
        } else {
            $error = "Erreur lors de la modification du profil.";
        }
    }
} else {
    $sql = "SELECT login, email FROM User WHERE id_user = :id_user";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id_user', $_SESSION['user_id'], PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $login = $user['login'];
        $email = $user['email'];
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ECF backend">
    <link rel="stylesheet" href="./style/edit_profil.css">
    <title>Modifier le profil</title>
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
        <h2>Modifier le profil</h2>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>
        <form method="POST" action="edit_profile.php">
            <label for="login">Nom d'utilisateur:</label>
            <input type="text" id="login" name="login" value="<?php echo htmlspecialchars($login); ?>" required>
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            <input type="submit" value="Modifier le profil">
        </form>
    </main>
</body>
</html>
