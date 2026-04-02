<?php if (!isset($_GET['ajax'])): ?>
    <div class="row mb-5">
        <div class="col-md-8 mx-auto">
            <div class="input-group shadow-sm">
                <span class="input-group-text bg-white border-end-0"><i class="fa-solid fa-magnifying-glass text-warning"></i></span>
                <input type="text" id="liveSearch" class="form-control form-control-lg border-start-0 shadow-none" placeholder="Rechercher une œuvre...">
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
                        <div class="mb-2">
                            <span class="badge rounded-pill bg-light text-muted border px-2 py-1" style="font-size: 0.7rem;">
                                <i class="fa-solid fa-folder me-1 text-warning"></i>
                                <?= htmlspecialchars($critique['nom_categorie']) ?>
                            </span>
                        </div>

                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h5 class="card-title fw-bold text-dark mb-0"><?= htmlspecialchars($critique['titre']) ?></h5>
                            <span class="badge bg-warning text-dark fw-bold">★ <?= number_format($critique['note'], 1) ?></span>
                        </div>
                        <p class="card-text text-muted small">
                            <?= nl2br(htmlspecialchars(substr($critique['contenu'], 0, 140))) ?>...
                        </p>
                    </div>

                    <div class="card-footer bg-white border-0 d-flex justify-content-between align-items-center pb-3">
                        <div class="d-flex flex-column gap-1">
                            <small class="text-muted"><i class="fa-solid fa-user me-1"></i><?= htmlspecialchars($critique['pseudo']) ?></small>

                            <div class="d-flex align-items-center gap-2">
                                <button class="btn btn-link p-0 border-0 like-btn text-decoration-none d-flex align-items-center gap-1 shadow-none"
                                    data-id="<?= $critique['id'] ?>">
                                    <i class="fa-solid fa-heart text-danger"></i>
                                    <span class="fw-bold small text-muted count-display"><?= $critique['total_likes'] ?></span>
                                </button>

                                <?php if (isset($_SESSION['user_id']) && ($_SESSION['user_id'] == $critique['id_user'] || $_SESSION['role'] == 2)): ?>
                                    <span class="text-muted">|</span>
                                    <a href="index.php?page=edit-critique&id=<?= $critique['id'] ?>" class="text-primary small"><i class="fa-solid fa-pen"></i></a>
                                    <a href="index.php?page=delete-critique&id=<?= $critique['id'] ?>" class="text-danger small" onclick="return confirm('Supprimer ?')"><i class="fa-solid fa-trash"></i></a>
                                <?php endif; ?>
                            </div>
                        </div>

                        <a href="index.php?page=detail&id=<?= $critique['id'] ?>" class="btn btn-sm btn-dark px-3 rounded-pill shadow-sm">Détails</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="col-12 text-center py-5 text-muted">Aucune critique ne correspond à votre recherche.</div>
    <?php endif; ?>
</div>

<?php if (!isset($_GET['ajax'])): ?>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const resultsGrid = document.getElementById('results-grid');
    const liveSearch = document.getElementById('liveSearch');

    if (resultsGrid) {
        resultsGrid.addEventListener('click', function(e) {
            
            const btn = e.target.closest('.like-btn');
            
            if (btn) {
                e.preventDefault();
                const idCritique = btn.dataset.id;
                const countSpan = btn.querySelector('.count-display');
                const icon = btn.querySelector('i');

                fetch('index.php?page=like', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'id_critique=' + idCritique
                })
                .then(res => res.json())
                .then(data => {
                    if (data.status === 'success') {
                        countSpan.textContent = data.new_count;
                        // On change l'icône si tu gères le plein/vide
                        if (data.is_liked) icon.classList.replace('fa-regular', 'fa-solid');
                        else icon.classList.replace('fa-solid', 'fa-regular');
                    } else if (data.message === 'Not logged in') {
                        window.location.href = 'index.php?page=login';
                    }
                })
                .catch(err => console.error(err));
            }
        });
    }
    if (liveSearch) {
        liveSearch.addEventListener('input', function(e) {
            const search = e.target.value;
            fetch(`index.php?page=home&ajax=1&search=${encodeURIComponent(search)}`)
                .then(res => res.text())
                .then(html => {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newGrid = doc.getElementById('results-grid');
                    
                    if (newGrid && resultsGrid) {
                        resultsGrid.innerHTML = newGrid.innerHTML;
                    }
                });
        });
    }
});
</script>
<?php endif; ?>