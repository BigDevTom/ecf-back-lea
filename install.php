<?php
require_once 'include/db_connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['admin_login']) && isset($_POST['admin_email']) && isset($_POST['admin_password'])) {
        $admin_login = $_POST['admin_login'];
        $admin_email = $_POST['admin_email'];
        $admin_password = password_hash($_POST['admin_password'], PASSWORD_DEFAULT);
        $admin_role = 'admin';

        $sql = "SELECT * FROM User WHERE login = :login";
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':login', $admin_login, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() == 0) {
            $sql = "INSERT INTO User (login, email, password, role) VALUES (:login, :email, :password, :role)";
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':login', $admin_login, PDO::PARAM_STR);
            $stmt->bindParam(':email', $admin_email, PDO::PARAM_STR);
            $stmt->bindParam(':password', $admin_password, PDO::PARAM_STR);
            $stmt->bindParam(':role', $admin_role, PDO::PARAM_STR);

            if ($stmt->execute()) {
                $success = "Administrateur par défaut créé avec succès.";
            } else {
                $error = "Erreur lors de la création de l'administrateur.";
            }
        } else {
            $error = "Un administrateur avec ce nom d'utilisateur existe déjà.";
        }
    } else {
        $error = "Tous les champs sont requis.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="ECF backend">
    <link rel="stylesheet" href="./style/install.css">
    <title>Installation - Créer l'Administrateur</title>
</head>
<body>
    <header>
        <h1>Installation - Créer l'Administrateur</h1>
    </header>
    <main>
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        <?php if (isset($success)): ?>
            <p class="success"><?php echo $success; ?></p>
        <?php endif; ?>
        <form method="POST" action="install.php">
            <label for="admin_login">Nom d'utilisateur administrateur:</label>
            <input type="text" id="admin_login" name="admin_login" required>
            <label for="admin_email">Email de l'administrateur:</label>
            <input type="email" id="admin_email" name="admin_email" required>
            <label for="admin_password">Mot de passe de l'administrateur:</label>
            <input type="password" id="admin_password" name="admin_password" required>
            <input type="submit" value="Créer l'administrateur">
        </form>
    </main>
</body>
</html>
