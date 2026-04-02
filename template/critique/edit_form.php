<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <h4 class="mb-0 fw-bold text-dark">Modifier ma critique</h4>
    </div>
    <div class="card-body">
        <form action="index.php?page=update-critique" method="POST">
            <input type="hidden" name="id" value="<?= $critique['id'] ?>">

            <div class="mb-3">
                <label class="form-label fw-bold">Titre de l'œuvre</label>
                <input type="text" name="titre" class="form-control"
                    value="<?= htmlspecialchars($critique['titre']) ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Catégorie</label>
                <select name="id_categorie" class="form-select" required>
                    <option value="">-- Choisir une catégorie --</option>

                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= $cat['id'] ?>"
                            <?= (isset($critique['id_categorie']) && $cat['id'] == $critique['id_categorie']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Note / 10</label>
                <input type="number" name="note" step="0.5" min="0" max="10" class="form-control"
                    value="<?= $critique['note'] ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label fw-bold">Votre avis</label>
                <textarea name="contenu" class="form-control" rows="6" required><?= htmlspecialchars($critique['contenu']) ?></textarea>
            </div>

            <div class="d-flex justify-content-between">
                <a href="index.php?page=home" class="btn btn-outline-secondary px-4">Annuler</a>
                <button type="submit" class="btn btn-warning fw-bold px-4">Enregistrer les modifications</button>
            </div>
        </form>
    </div>
</div>