// Gestion des boutons Like
document.addEventListener('DOMContentLoaded', function() {
    // Sélectionner tous les boutons de like
    const likeButtons = document.querySelectorAll('.like-btn');

    likeButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();

            const idCritique = this.dataset.id;
            const isLiked = this.dataset.liked === '1';
            const likesCountElement = this.querySelector('.likes-count');

            // Désactiver le bouton pendant la requête
            button.disabled = true;

            // AJAX via Fetch (avec cookies de session)
            fetch('index.php?page=like', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded'
                },
                body: 'id_critique=' + encodeURIComponent(idCritique),
                credentials: 'include'
            })
            .then(response => {
                if (!response.ok) throw new Error('Statut HTTP ' + response.status);
                return response.json();
            })
            .then(data => {
                if (data.status === 'success') {
                    // Mettre à jour l'état du bouton avec les données du serveur
                    button.dataset.liked = data.user_liked ? '1' : '0';

                    // Changer la classe CSS du bouton
                    if (data.user_liked) {
                        button.classList.remove('btn-outline-danger');
                        button.classList.add('btn-danger');
                    } else {
                        button.classList.remove('btn-danger');
                        button.classList.add('btn-outline-danger');
                    }

                    likesCountElement.textContent = data.likes_count;
                } else {
                    alert(data.message || 'Erreur lors de la mise à jour du like');
                }
            })
            .catch(error => {
                console.error('Erreur fetch like:', error);
                alert('Erreur de connexion (like)');
            })
            .finally(() => {
                button.disabled = false;
            });
        });
    });
});