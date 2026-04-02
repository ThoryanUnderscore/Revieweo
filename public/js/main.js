// Quand on clique sur le bouton Like
const likeBtn = document.querySelector('.like-btn');

likeBtn.addEventListener('click', function() {
    const idCritique = this.dataset.id; // Récupère l'ID de la critique

    fetch('index.php?page=like', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'id_critique=' + idCritique
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'success') {
            // Ici tu changes la couleur du bouton ou tu incrémentes le chiffre
            alert('Like mis à jour !');
        }
    });
});