<div class="row justify-content-center mt-5">
    <div class="col-md-5">
        <div class="card shadow">
            <div class="card-header bg-success text-white text-center">
                <h3 class="mb-0">Créer un compte</h3>
            </div>
            <div class="card-body">
                
                <?php if (isset($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>

                <form action="index.php?page=register" method="POST">
                    <div class="mb-3">
                        <label for="pseudo" class="form-label">Nom d'utilisateur / Pseudo</label>
                        <input type="text" name="pseudo" id="pseudo" class="form-control" placeholder="Ex: JeanDupont" required>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Adresse Email</label>
                        <input type="email" name="email" id="email" class="form-control" placeholder="nom@exemple.com" required>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" name="password" id="password" class="form-control" minlength="8" required>
                        <div class="form-text">Minimum 8 caractères pour la sécurité.</div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label d-block">Type de compte :</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="role" id="user" value="0" checked>
                            <label class="form-check-label" for="user">
                                <strong>Utilisateur</strong> (Lire et liker)
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="role" id="critique" value="1">
                            <label class="form-check-label" for="critique">
                                <strong>Critique</strong> (Écrire des avis et noter)
                            </label>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-success">S'inscrire</button>
                    </div>
                </form>
            </div>
            <div class="card-footer text-center">
                <p class="mb-0 small text-muted">Déjà un compte ? <a href="index.php?page=login">Connectez-vous ici</a></p>
            </div>
        </div>
    </div>
</div>