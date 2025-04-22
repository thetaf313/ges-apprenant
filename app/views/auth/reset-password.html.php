<?php
$title = 'Changement de mot de passe';
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

    <form action="/?page=auth&action=change-password" method="post">
        <h1>Changer le mot de passe</h1>

        <div class="form-group">
            <label for="password">Nouveau mot de passe</label>
            <input
                type="password"
                name="password"
                placeholder="Nouveau mot de passe"
                value="<?= htmlspecialchars($old_input['password'] ?? '') ?>"
            />
            <?php if (!empty($errors['password'])): ?>
                <div class="input-error"><?= htmlspecialchars($errors['password']) ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label for="password_confirmation">Confirmer le mot de passe</label>
            <input
                type="password"
                name="password_confirmation"
                placeholder="Confirmer le mot de passe"
                value="<?= htmlspecialchars($old_input['password_confirmation'] ?? '') ?>"
            />
            <?php if (!empty($errors['password_confirmation'])): ?>
                <div class="input-error"><?= htmlspecialchars($errors['password_confirmation']) ?></div>
            <?php endif; ?>
        </div>

        <button type="submit" class="login-btn" name="auth">Valider</button>
    </form>
</div>
