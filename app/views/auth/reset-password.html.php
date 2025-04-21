<div class="auth-container">
    <h2>Réinitialiser votre mot de passe</h2>
    
    <?php if (isset($data['error'])): ?>
        <div class="alert alert-danger"><?= $data['error'] ?></div>
    <?php endif; ?>
    
    <form method="post" action="?page=auth&action=update-password">
        <input type="hidden" name="token" value="<?= $data['token'] ?? '' ?>">
        
        <div class="form-group">
            <label>Nouveau mot de passe</label>
            <input type="password" name="password" required>
        </div>
        
        <div class="form-group">
            <label>Confirmer le mot de passe</label>
            <input type="password" name="password_confirmation" required>
        </div>
        
        <button type="submit" class="btn btn-primary">Mettre à jour</button>
    </form>
</div>