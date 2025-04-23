<?php

use App\Enums\Routes;

$title = 'Vérification Email';
?>

<div id="form-container">
    <div class="logo-container">
        <a href="#">
            <img src="<?= 'http://' . $_SERVER['HTTP_HOST']; ?>/assets/images/logo-odc-sonatel.png" alt="logo" />
        </a>
    </div>

    <h3>Bienvenue sur<br> <span>Ecole du code Sonatel Academy</span></h3>

    <?php if (!empty($error_message)): ?>
        <div class="error message"><?= htmlspecialchars($error_message) ?></div>
    <?php endif; ?>

    <form action="<?= Routes::AUTH->resolve() ?>?action=verify-email" method="post">
        <h1>Vérification de l'adresse email</h1>

        <div class="form-group">
            <label for="login">Email</label>
            <input
                type="text"
                name="login"
                placeholder="Entrer votre email"
                value="<?= htmlspecialchars($old_input['login'] ?? '') ?>"
            />
            <?php if (!empty($errors['login'])): ?>
                <div class="input-error"><?= htmlspecialchars($errors['login']) ?></div>
            <?php endif; ?>
        </div>

        <button type="submit" class="login-btn" name="auth">Se connecter</button>
    </form>
</div>
