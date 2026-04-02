<div class="row justify-content-center mt-5">
    <div class="col-md-4">
        <div class="card shadow">
            <div class="card-header bg-dark text-white text-center">
                <h3 class="mb-0">Connexion</h3>
            </div>
            <div class="card-body">
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger">
                        <?= htmlspecialchars($error) ?>
                    </div>
                <?php endif; ?>

                <form action="index.php?page=login" method="POST">
                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="nom@exemple.com" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" name="password" id="password" class="form-control" required>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Se connecter</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
                <p class="mb-0 small text-muted">Pas encore de compte ? <a href="index.php?page=register">Inscrivez-vous</a></p>
            </div>
        </div>
    </div>
</div>