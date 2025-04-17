<?php
// Initialisation des variables
$name = $email = $password = $confirm_password = $age = $website = $gender = "";
$errors = [];

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Nettoyage et validation du nom
    if (empty($_POST["name"])) {
        $errors["name"] = "Le nom est requis.";
    } else {
        $name = htmlspecialchars(trim($_POST["name"]));
        if (!preg_match("/^[a-zA-ZÀ-ÿ\s]+$/", $name)) {
            $errors["name"] = "Le nom ne doit contenir que des lettres et espaces.";
        }
    }

    // Validation de l'email
    if (empty($_POST["email"])) {
        $errors["email"] = "L'email est requis.";
    } else {
        $email = htmlspecialchars(trim($_POST["email"]));
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "L'email n'est pas valide.";
        }
    }

    // Validation du mot de passe
    if (empty($_POST["password"])) {
        $errors["password"] = "Le mot de passe est requis.";
    } else {
        $password = trim($_POST["password"]);
        if (strlen($password) < 8) {
            $errors["password"] = "Le mot de passe doit contenir au moins 8 caractères.";
        }
    }

    // Validation de la confirmation du mot de passe
    if (empty($_POST["confirm_password"])) {
        $errors["confirm_password"] = "Veuillez confirmer votre mot de passe.";
    } else {
        $confirm_password = trim($_POST["confirm_password"]);
        if ($confirm_password !== $password) {
            $errors["confirm_password"] = "Les mots de passe ne correspondent pas.";
        }
    }

    // Validation de l'âge
    if (empty($_POST["age"])) {
        $errors["age"] = "L'âge est requis.";
    } else {
        $age = trim($_POST["age"]);
        if (!filter_var($age, FILTER_VALIDATE_INT) || $age < 18 || $age > 99) {
            $errors["age"] = "L'âge doit être un nombre entre 18 et 99.";
        }
    }

    // Validation du site web (facultatif)
    if (!empty($_POST["website"])) {
        $website = htmlspecialchars(trim($_POST["website"]));
        if (!filter_var($website, FILTER_VALIDATE_URL)) {
            $errors["website"] = "L'URL du site web n'est pas valide.";
        }
    }

    // Validation du genre
    if (empty($_POST["gender"])) {
        $errors["gender"] = "Le genre est requis.";
    } else {
        $gender = htmlspecialchars($_POST["gender"]);
        if (!in_array($gender, ["Homme", "Femme"])) {
            $errors["gender"] = "Genre invalide.";
        }
    }

    // Si aucune erreur, afficher un message de succès
    if (empty($errors)) {
        echo "<p style='color: green;'>Inscription réussie !</p>";
        echo "<p><strong>Nom :</strong> $name</p>";
        echo "<p><strong>Email :</strong> $email</p>";
        echo "<p><strong>Âge :</strong> $age ans</p>";
        echo "<p><strong>Site Web :</strong> " . ($website ? "<a href='$website'>$website</a>" : "Non renseigné") . "</p>";
        echo "<p><strong>Genre :</strong> $gender</p>";
        exit(); // Arrêter l'exécution après l'affichage du message de succès
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire d'inscription</title>
    <style>
        .error { color: red; font-size: 14px; }
    </style>
</head>
<body>
    <h2>Formulaire d'inscription</h2>
    <form action="" method="POST">
        <label>Nom :</label><br>
        <input type="text" name="name" value="<?= htmlspecialchars($name) ?>"><br>
        <span class="error"><?= $errors["name"] ?? "" ?></span><br>

        <label>Email :</label><br>
        <input type="text" name="email" value="<?= htmlspecialchars($email) ?>"><br>
        <span class="error"><?= $errors["email"] ?? "" ?></span><br>

        <label>Mot de passe :</label><br>
        <input type="password" name="password"><br>
        <span class="error"><?= $errors["password"] ?? "" ?></span><br>

        <label>Confirmer le mot de passe :</label><br>
        <input type="password" name="confirm_password"><br>
        <span class="error"><?= $errors["confirm_password"] ?? "" ?></span><br>

        <label>Âge :</label><br>
        <input type="number" name="age" value="<?= htmlspecialchars($age) ?>"><br>
        <span class="error"><?= $errors["age"] ?? "" ?></span><br>

        <label>Site Web (facultatif) :</label><br>
        <input type="text" name="website" value="<?= htmlspecialchars($website) ?>"><br>
        <span class="error"><?= $errors["website"] ?? "" ?></span><br>

        <label>Genre :</label><br>
        <input type="radio" name="gender" value="Homme" <?= $gender === "Homme" ? "checked" : "" ?>> Homme
        <input type="radio" name="gender" value="Femme" <?= $gender === "Femme" ? "checked" : "" ?>> Femme<br>
        <span class="error"><?= $errors["gender"] ?? "" ?></span><br>

        <button type="submit">S'inscrire</button>
    </form>
</body>
</html>
