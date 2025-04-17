<?php 
  $nom = $email = $age = $password = $confirmPassword = $siteweb = $gender = "";
  $errors = [];

  if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // VALIDATION DE NOM
    if (empty($_POST["nom"])) {
        $errors["nom"] = "Le nom est requis.";
    } else {
        $nom = trim($_POST["nom"]);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $nom)) {
            $errors["nom"] = "<i class='bi bi-x-circle'></i> Le nom ne doit contenir que des lettres et des espaces.";
        }
    }

    // VALIDATION D'EMAIL
    if (empty($_POST["email"])) {
        $errors["email"] = "<i class='bi bi-x-circle'></i> L'email est requis.";
    } else {
        $email = trim($_POST["email"]);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors["email"] = "<i class='bi bi-x-circle'></i> L'email n'est pas valide.";
        }
    }

    // VALIDATION DE MOT DE PASSE
        if (empty($_POST["password"])) {
            $errors["password"] = "<i class='bi bi-x-circle'></i> Le mot de passe est requis.";
        } else {
            $password = $_POST["password"];
            if (strlen($password) < 8) {
                $errors["password"] = "<i class='bi bi-x-circle'></i> Le mot de passe doit contenir au moins 8 caractères.";
            }
        }

    // VALIDATION DE CONFIRMATION DE MOT DE PASSE
    if (empty($_POST["confirmPassword"])) {
        $errors["confirmPassword"] = "<i class='bi bi-x-circle'></i> La confirmation du mot de passe est requise.";
    } else {
        $confirmPassword = $_POST["confirmPassword"];
        if ($confirmPassword !== $password) {
            $errors["confirmPassword"] = "<i class='bi bi-x-circle'></i> Les mots de passe ne correspondent pas.";
        }
    }

    // VALIDATION D'AGE
    if (empty($_POST["age"])) {
        $errors["age"] = "<i class='bi bi-x-circle'></i> L'âge est requis.";
    } else {
        $age = $_POST["age"];
        if (!filter_var($age, FILTER_VALIDATE_INT)) {
            $errors["age"] = "<i class='bi bi-x-circle'></i> L'âge doit être un nombre entier.";
        } elseif ($age < 18 || $age > 99) {
            $errors["age"] = " <i class='bi bi-x-circle'></i> L'âge doit être compris entre 18 et 99 ans.";
        }
    }

    // VALIDATION DE SITEWEB
    if (empty($_POST["siteweb"])) {
        $errors["siteweb"] = "<i class='bi bi-x-circle'></i> Le site web est requis.";
    } else {
        $siteweb = $_POST["siteweb"];
        if (!filter_var($siteweb, FILTER_VALIDATE_URL)) {
            $errors["siteweb"] = "<i class='bi bi-x-circle'></i> Le site web n'est pas valide.";
        }
    }

    // VALIDATION DE GENDER
    if (empty($_POST["gender"])) {
        $errors["gender"] = "<i class='bi bi-x-circle'></i> Le genre est requis.";
    } else {
        $gender = $_POST["gender"];
    }

  }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Validation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body style="background-color: rgb(150, 60, 83);">
<div class="container mt-5">
    <h2 class="text-center p-3 bg-primary text-white rounded w-50 m-auto mb-5">Formulaire de Validation</h2>

    <form action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST" class=" p-4 shadow w-75 mx-auto" style="background-color: rgb(179, 158, 190); border:3px solid rgb(25, 2, 46);border-radius:25px">
        
        <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" name="nom" id="nom" class="form-control" value="<?= htmlspecialchars($nom) ?>">
            <div class="text-danger"><?= isset($errors['nom']) ? $errors['nom'] : '' ?></div>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" id="email" class="form-control" value="<?= htmlspecialchars($email) ?>" >
            <div class="text-danger"><?= isset($errors['email']) ? $errors['email'] : '' ?></div>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Mot de passe</label>
            <input type="password" name="password" id="password" class="form-control" >
            <div class="text-danger"><?= isset($errors['password']) ? $errors['password'] : '' ?></div>
        </div>

        <div class="mb-3">
            <label for="confirmPassword" class="form-label">Confirmation du mot de passe</label>
            <input type="password" name="confirmPassword" id="confirmPassword" class="form-control" >
            <div class="text-danger"><?= isset($errors['confirmPassword']) ? $errors['confirmPassword'] : '' ?></div>
        </div>

        <div class="mb-3">
            <label for="age" class="form-label">Âge</label>
            <input type="number" name="age" id="age" class="form-control" value="<?= htmlspecialchars($age) ?>" >
            <div class="text-danger"><?= isset($errors['age']) ? $errors['age'] : '' ?></div>
        </div>

        <div class="mb-3">
            <label for="siteweb" class="form-label">Site Web</label>
            <input type="text" name="siteweb" id="siteweb" class="form-control" value="<?= htmlspecialchars($siteweb) ?>" >
            <div class="text-danger"><?= isset($errors['siteweb']) ? $errors['siteweb'] : '' ?></div>
        </div>

        <div class="mb-3">
            <label class="form-label">Genre</label><br>
            <input type="radio" name="gender" value="male" <?= $gender === "male" ? "checked" : "" ?>> Homme <i class='bi bi-gender-male'></i>
            <input type="radio" name="gender" value="female" <?= $gender === "female" ? "checked" : "" ?>> Femme <i class='bi bi-gender-female'></i>

            <div class="text-danger"><?= isset($errors['gender']) ? $errors['gender'] : '' ?></div>
        </div>

        <button type="submit" class="btn btn-primary">Envoyer</button>
    </form>

    <?php if (empty($errors) && $_SERVER["REQUEST_METHOD"] == "POST") : ?>
    <div class= "alert alert-success m-auto w-50 text-center mt-4">
        <h3 style='color: green;'>Inscription réussie !</h3>
        <p><strong>Nom :</strong> <?= htmlspecialchars($nom) ?></p>
        <p><strong>Email :</strong> <?= htmlspecialchars($email) ?></p>
        <p><strong>Âge :</strong> <?= htmlspecialchars($age) ?></p>
        <p><strong>Site Web :</strong> <a href="<?= htmlspecialchars($siteweb) ?>" target="_blank"><?= htmlspecialchars($siteweb) ?></a></p>
        <p><strong>Genre :</strong> <?= htmlspecialchars($gender) ?></p>
    </div>
    <?php endif; ?>
</div>
</body>
</html>
