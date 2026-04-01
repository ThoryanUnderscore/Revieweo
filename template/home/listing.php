<?php if (!isset($_GET['ajax'])): ?>
<div class="row mb-5">
    <div class="col-md-8 mx-auto">
        <div class="input-group shadow-sm">
            <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-warning"></i></span>
            <input type="text" id="liveSearch" class="form-control form-control-lg border-start-0 shadow-none" placeholder="Rechercher une œuvre par son titre...">
        </div>
    </div>
</div>
<?php endif; ?>

<div class="row" id="results-grid">
    <?php if (!empty($critiques)): ?>
        <?php foreach ($critiques as $critique): ?>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm border-top border-warning border-4">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title fw-bold text-dark mb-0"><?= htmlspecialchars($critique['titre']) ?></h5>
                            <span class="badge bg-warning text-dark fw-bold">★ <?= number_format($critique['note'], 1) ?></span>
                        </div>
                        <p class="card-text text-muted small">
                            <?= nl2br(htmlspecialchars(substr($critique['contenu'], 0, 150))) ?>...
                        </p>
                    </div>
                    <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center pb-3">
                        <div class="d-flex align-items-center gap-2">
                            <small class="text-muted"><i class="fa-solid fa-user-pen me-1"></i><?= htmlspecialchars($critique['pseudo']) ?></small>
                            <button class="btn btn-sm <?= $critique['user_liked'] ? 'btn-danger' : 'btn-outline-danger' ?> like-btn p-1"
                                    data-id="<?= $critique['id'] ?>"
                                    data-liked="<?= $critique['user_liked'] ? '1' : '0' ?>"
                                    title="J'aime">
                                <i class="fa-solid fa-heart fa-xs"></i>
                                <span class="likes-count ms-1"><?= $critique['likes_count'] ?></span>
                            </button>
                        </div>
                        <a href="index.php?page=detail&id=<?= $critique['id'] ?>" class="btn btn-sm btn-dark px-3 rounded-pill">Lire l'avis</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12 text-center py-5">
            <i class="fa-solid fa-magnifying-glass-blur display-1 text-light mb-3"></i>
            <p class="lead text-muted">Aucune œuvre ne correspond à votre recherche.</p>
        </div>
    <?php endif; ?>
</div>

<?php if (!isset($_GET['ajax'])): ?>
<script>
document.getElementById('liveSearch').addEventListener('input', function(e) {
    const search = e.target.value;
    const grid = document.getElementById('results-grid');

    fetch(`index.php?page=home&ajax=1&search=${encodeURIComponent(search)}`)
        .then(response => response.text())
        .then(html => {
            // Le DOMParser va extraire uniquement la grille du HTML reçu
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newGrid = doc.getElementById('results-grid');
            
            if (newGrid) {
                grid.innerHTML = newGrid.innerHTML;
            }
        });
});
</script>
<?php endif; ?>