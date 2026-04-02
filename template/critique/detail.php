<?php
// On initialise les variables de Like
$likeModel = new \Src\Models\Like($this->db);
$totalLikes = $likeModel->countByCritique($critique['id']);
$alreadyLiked = false;

// Si l'utilisateur est connecté, on vérifie s'il a déjà liké cette critique
if (isset($_SESSION['user_id'])) {
    $alreadyLiked = $likeModel->isLikedByUser($_SESSION['user_id'], $critique['id']);
}
?>

<div class="row justify-content-center">
    <div class="col-md-9 col-lg-8">
        <article class="p-4 p-md-5 bg-white shadow-sm rounded border-top border-warning border-4">
            
            <div class="d-flex justify-content-between align-items-start mb-3">
                <h1 class="fw-bold text-dark mb-0"><?= htmlspecialchars($critique['titre']) ?></h1>
                <div class="mb-2">
                    <span class="badge bg-light text-secondary border px-3 py-2 rounded-pill">
                        <i class="fa-solid fa-folder-open me-2 text-warning"></i>
                        <?= htmlspecialchars($critique['nom_categorie'] ?? 'Non classé') ?>
                    </span>
                </div>
                <span class="badge bg-warning text-dark fs-5 shadow-sm">★ <?= number_format($critique['note'], 1) ?>/10</span>
            </div>

            <p class="text-muted mb-4">
                <i class="fa-solid fa-user-pen me-2"></i>Publié par <strong><?= htmlspecialchars($critique['pseudo']) ?></strong>
            </p>

            <hr class="my-4 opacity-25">

            <div class="critique-content mb-5" style="font-size: 1.15rem; line-height: 1.8; color: #333;">
                <?= nl2br(htmlspecialchars($critique['contenu'])) ?>
            </div>

            <hr class="my-4 opacity-25">

            <div class="d-flex align-items-center justify-content-between">
                <a href="index.php?page=home" class="btn btn-outline-secondary rounded-pill px-4">
                    <i class="fa-solid fa-arrow-left me-2"></i>Retour
                </a>

                <div class="d-flex align-items-center gap-3">
                    <button id="likeBtn" 
                            class="btn <?= $alreadyLiked ? 'btn-danger' : 'btn-outline-danger' ?> rounded-pill px-4 py-2 d-flex align-items-center gap-2 shadow-sm transition"
                            data-id="<?= $critique['id'] ?>">
                        <i class="<?= $alreadyLiked ? 'fa-solid' : 'fa-regular' ?> fa-heart fs-5"></i>
                        <span class="fw-bold">J'aime</span>
                        <span class="badge bg-white text-danger rounded-pill ms-1 count-display"><?= $totalLikes ?></span>
                    </button>
                </div>
            </div>
        </article>
    </div>
</div>

<style>
/* Petite animation pour le bouton like */
.like-btn { transition: all 0.2s ease-in-out; }
.like-btn:hover { transform: scale(1.05); }
.transition { transition: 0.3s; }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const likeBtn = document.getElementById('likeBtn');
    
    if (likeBtn) {
        likeBtn.addEventListener('click', function() {
            const idCritique = this.dataset.id;
            const icon = this.querySelector('i');
            const countSpan = this.querySelector('.count-display');
            const btn = this;

            // Appel AJAX au LikeController
            fetch('index.php?page=like', {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: 'id_critique=' + idCritique
            })
            .then(response => {
                if (!response.ok) throw new Error('Erreur réseau');
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    // 1. Mise à jour du texte du compteur
                    countSpan.textContent = data.new_count;

                    // 2. Bascule visuelle (Rempli vs Vide)
                    if (data.is_liked) {
                        btn.classList.replace('btn-outline-danger', 'btn-danger');
                        icon.classList.replace('fa-regular', 'fa-solid');
                    } else {
                        btn.classList.replace('btn-danger', 'btn-outline-danger');
                        icon.classList.replace('fa-solid', 'fa-regular');
                    }
                } else if (data.message === 'Not logged in') {
                    // Redirection si l'utilisateur essaie de liker sans être connecté
                    window.location.href = 'index.php?page=login';
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
        });
    }
});
</script>