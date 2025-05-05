<?php

use App\Enums\Routes;

$title = 'Connexion';
?>

<div id="form-container">
    <div class="logo-container">
        <a href="#">
            <img src="<?= 'http://' . $_SERVER['HTTP_HOST']; ?>/assets/images/logo-odc-sonatel.png" alt="logo" />
        </a>
    </div>

    <h3>Bienvenue sur<br> <span>Ecole du code Sonatel Academy</span></h3>
    <?php if (!empty($_SESSION['flash_success'])): ?>
        <div class="success message"><?= htmlspecialchars($_SESSION['flash_success']) ?></div>
    <?php endif; ?>
    <?php if (!empty($error_message)): ?>
        <div class="error message"><?= htmlspecialchars($error_message) ?></div>
    <?php endif; ?>

    <form action="<?= Routes::AUTH->resolve()?>" method="post">
        <h1>Se connecter</h1>

        <div class="form-group">
            <label for="login">Login</label>
            <input
                type="text"
                name="login"
                placeholder="Matricule ou email"
                value="<?= htmlspecialchars($old_input['login'] ?? '') ?>" autocomplete="off"
            />
            <?php if (!empty($errors['login'])): ?>
                <div class="input-error"><?= htmlspecialchars($errors['login']) ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" placeholder="Mot de passe" autocomplete="off" />
            <?php if (!empty($errors['password'])): ?>
                <div class="input-error"><?= htmlspecialchars($errors['password']) ?></div>
            <?php endif; ?>
        </div>

        <a href="<?= Routes::AUTH->resolve() ?>?action=forgot-password" class="forget-password">Mot de passe oublié ?</a>

        <button type="submit" class="login-btn" name="auth">Se connecter</button>
    </form>
</div>
