<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card shadow-sm border-0 mt-4">
            <div class="card-header bg-dark text-white p-3">
                <h3 class="mb-0 h5"><i class="fa-solid fa-pen me-2 text-warning"></i>Rédiger une nouvelle critique</h3>
            </div>
            <div class="card-body p-4">
                <form action="index.php?page=add-critique" method="POST">
                    
                    <div class="mb-3">
                        <label for="titre" class="form-label fw-bold">Titre de l'œuvre</label>
                        <input type="text" name="titre" id="titre" class="form-control form-control-lg" placeholder="Ex: Inception, The Witcher..." required>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="note" class="form-label fw-bold">Note / 10</label>
                            <div class="input-group">
                                <input type="number" name="note" id="note" class="form-control" min="0" max="10" step="0.5" value="5" required>
                                <span class="input-group-text bg-warning text-dark border-warning"><i class="fa-solid fa-star"></i></span>
                            </div>
                        </div>

                        <div class="col-md-8 mb-3">
                            <label for="id_categorie" class="form-label fw-bold">Catégorie</label>
                            <select name="id_categorie" id="id_categorie" class="form-select" required>
                                <option value="" selected disabled>Choisir un genre...</option>
                                <?php foreach($categories as $cat): ?>
                                    <option value="<?= $cat['id'] ?>"><?= htmlspecialchars($cat['nom']) ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="contenu" class="form-label fw-bold">Votre avis détaillé</label>
                        <textarea name="contenu" id="contenu" class="form-control" rows="8" placeholder="Qu'avez-vous pensé de cette œuvre ?" required></textarea>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-warning btn-lg fw-bold">
                            <i class="fa-solid fa-paper-plane me-2"></i>Publier la critique
                        </button>
                        <a href="index.php" class="btn btn-link text-muted">Annuler</a>
                    </div>

                </form>
            </div>
        </div>
    </div>
</div>