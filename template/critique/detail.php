<div class="row justify-content-center">
    <div class="col-md-8">
        <article class="p-4 bg-white shadow-sm rounded">
            <h1><?= htmlspecialchars($critique['titre']) ?></h1>
            <p class="text-muted">Publié par <strong><?= $critique['pseudo'] ?></strong></p>
            <hr>
            <div class="lead mb-4">
                <?= nl2br(htmlspecialchars($critique['contenu'])) ?>
            </div>
            
            <div class="d-flex align-items-center gap-3">
                <span class="h4">Note : <?= $critique['note'] ?>/10</span>
                <button class="btn <?= $critique['user_liked'] ? 'btn-danger' : 'btn-outline-danger' ?> like-btn"
                        data-id="<?= $critique['id'] ?>"
                        data-liked="<?= $critique['user_liked'] ? '1' : '0' ?>">
                    <i class="fa-solid fa-heart"></i>
                    <span class="likes-count"><?= $critique['likes_count'] ?></span>
                </button>
            </div>
        </article>
    </div>
</div>