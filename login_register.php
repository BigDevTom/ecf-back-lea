<?php
session_start();
require_once 'include/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['login_action'])) {
        $login = $_POST['login'];
        $password = $_POST['password'];

        $sql = "SELECT * FROM User WHERE login = :login";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':login', $login, PDO::PARAM_STR);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id_user'];
            $_SESSION['role'] = $user['role'];

            echo "role =" .$user['role'];

            if($user['role'] == 'admin') {
                header('location: admin.php');
            } elseif ($user['role'] == 'editor'){
                header('location: editor.php');
            } else {
                echo "role inconnu";
                exit();
            }
            exit();
        } else {
            $login_error = "Nom d'utilisateur ou mot de passe incorrect.";
        }
    } elseif (isset($_POST['register_action'])) {
        $new_login = $_POST['new_login'];
        $new_email = $_POST['new_email'];
        $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
        $role = 'editor';

        $sql = "INSERT INTO User (login, email, password, role) VALUES (:login, :email, :password, :role)";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':login', $new_login, PDO::PARAM_STR);
        $stmt->bindParam(':email', $new_email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $new_password, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $register_success = "Compte créé avec succès. Vous pouvez maintenant vous connecter.";
            header('location: editor.php');
        } else {
            $register_error = "Erreur lors de la création du compte.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Connexion et création de compte">
    <link rel="stylesheet" href="./style/style.css">
    <title>Connexion / Création de compte</title>
</head>
<body>
    <header>
        <h1>Connexion / Création de compte</h1>
        <nav>
                <a href="index.php">Retour a l'accueil</a>
        </nav>
    </header>
    <main>
        <section>
            <h2>Connexion</h2>
            <?php if (isset($login_error)): ?>
                <p class="error"><?php echo $login_error; ?></p>
            <?php endif; ?>
            <form method="POST" action="login_register.php">
                <label for="login">Nom d'utilisateur:</label>
                <input type="text" id="login" name="login" required>
                <label for="password">Mot de passe:</label>
                <input type="password" id="password" name="password" required>
                <input type="hidden" name="login_action" value="1">
                <input type="submit" value="Se connecter">
            </form>
        </section>
        <section>
            <h2>Créer un compte</h2>
            <?php if (isset($register_error)): ?>
                <p class="error"><?php echo $register_error; ?></p>
            <?php endif; ?>
            <?php if (isset($register_success)): ?>
                <p class="success"><?php echo $register_success; ?></p>
            <?php endif; ?>
            <form method="POST" action="login_register.php">
                <label for="new_login">Nom d'utilisateur:</label>
                <input type="text" id="new_login" name="new_login" required>
                <label for="new_email">Email:</label>
                <input type="email" id="new_email" name="new_email" required>
                <label for="new_password">Mot de passe:</label>
                <input type="password" id="new_password" name="new_password" required>
                <input type="hidden" name="register_action" value="1">
                <input type="submit" value="Créer un compte">
            </form>
        </section>
    </main>
</body>
</html>
