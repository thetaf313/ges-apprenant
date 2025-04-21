<?php
// Définition des variables pour le layout
$title = 'Connexion';
ob_start(); // Démarre la capture de sortie
?>

<div id="form-container">
    <div class="logo-container">
        <a href="#"><img src="assets/images/logo-odc-sonatel.png" alt="logo" /></a>
    </div>
    <h3>Bienvenue sur<br> <span>Ecole du code Sonatel Academy</span></h3>
    
    <?php if (isset($error)): ?>
        <div class="error message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <form action="/?action=login" method="post">
        <h1>Se connecter</h1>

        <div class="form-group">
            <label for="login">Login</label>
            <input type="text" name="login" placeholder="Matricule ou email" value="<?= htmlspecialchars($_POST['login'] ?? '') ?>"/>
            <span class="invalid"><?= $errors['login'] ?? '' ?></span>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" placeholder="Mot de passe"/>
            <span class="invalid"><?= $errors['password'] ?? '' ?></span>
        </div>

        <a href="/?action=forgotPassword" class="forget-password">Mot de passe oublié?</a>

        <button type="submit" class="login-btn" name="auth">Se connecter</button>
    </form>
</div>

<?php
// Fin de capture et passage au layout
$content = ob_get_clean();
require __DIR__ . '/../layout/base.layout.php';