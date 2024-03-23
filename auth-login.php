<?php
$pdo = require_once __DIR__ . '/database/database.php';
$authDB = require_once __DIR__ . '/database/security.php';

const ERROR_REQUIRED = 'Veuillez renseigner ce champ';
const ERROR_PASSWORD_TOO_SHORT = 'Le mot de passe doit faire au moins 6 caractères';
const ERROR_PASSWORD_MISMATCH = 'Le mot de passe n\'est pas valide';
const ERROR_EMAIL_INVALID = 'L\'email n\'est pas valide';
const ERROR_EMAIL_UNKOWN = 'L\'email n\'est pas enregistré';

$errors = [
    'firstname' => '',
    'lastname' => '',
    'email' => '',
    'password' => '',
    'confirmpassword' => ''
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'] ?? '';


    if (!$email) {
        $errors['email'] = ERROR_REQUIRED;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = ERROR_EMAIL_INVALID;
    }

    if (!$password) {
        $errors['password'] = ERROR_REQUIRED;
    } elseif (mb_strlen($password) < 6) {
        $errors['password'] = ERROR_PASSWORD_TOO_SHORT;
    }

    if (empty(array_filter($errors, fn ($error) => $error !== ''))) {
        $user = $authDB->getUserFromEmail($email);

        if (!$user) {
            $errors['email'] = ERROR_EMAIL_UNKOWN;
        } else {
            if (!password_verify($password, $user['password'])) {
                $errors['password'] = ERROR_PASSWORD_MISMATCH;
            } else {
                $authDB->login($user['id']);
                header('Location: /');
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <?php require_once 'includes/head.php' ?>
    <link rel="stylesheet" href="/public/css/auth-login.css">
    <title>Connexion</title>
</head>

<body>
    <div class="container">
        <?php require_once 'includes/header.php' ?>
        <div class="content">
            <div class="block p-20 form-container">
                <h1>Connexion</h1>
                <form action="/auth-login.php" method="post">
                    <div class="form-control">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" value="<?= $email ?? '' ?>">
                        <?php if ($errors['email']) : ?>
                            <p class="text-danger"><?= $errors['email'] ?></p>
                        <?php endif ?>
                    </div>
                    <div class="form-control">
                        <label for="password">Mot de passe</label>
                        <input type="password" name="password" id="password">
                        <?php if ($errors['password']) : ?>
                            <p class="text-danger"><?= $errors['password'] ?></p>
                        <?php endif ?>
                    </div>
                    <div class="form-actions">
                        <a href="/" class="btn btn-secondary" type="button">Annuler</a>
                        <button class="btn btn-primary" type="submit">Connexion</button>
                    </div>
                </form>
            </div>
        </div>
        <?php require_once 'includes/footer.php' ?>
    </div>

</body>

</html>