<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold"><i class="fa-solid fa-lock text-danger me-2"></i>Panel Administration</h2>
        <span class="badge bg-dark px-3 py-2">Mode Administrateur</span>
    </div>

    <ul class="nav nav-tabs mb-4" id="adminTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active fw-bold text-dark" id="users-tab" data-bs-toggle="tab" data-bs-target="#users" type="button">
                <i class="fa-solid fa-users me-2"></i>Utilisateurs
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link fw-bold text-dark" id="critiques-tab" data-bs-toggle="tab" data-bs-target="#critiques" type="button">
                <i class="fa-solid fa-pen-nib me-2"></i>Critiques
            </button>
        </li>
    </ul>

    <div class="tab-content" id="adminTabContent">
        <div class="tab-pane fade show active" id="users" role="tabpanel">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <table class="table table-hover align-middle">
                        <thead class="table-light">
                            <tr>
                                <th>ID</th>
                                <th>Pseudo</th>
                                <th>Email</th>
                                <th>Rôle</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                            <tr>
                                <td>#<?= $user['id'] ?></td>
                                <td class="fw-bold"><?= htmlspecialchars($user['pseudo']) ?></td>
                                <td><?= htmlspecialchars($user['email']) ?></td>
                                <td>
                                    <?php if($user['role'] == 2): ?>
                                        <span class="badge bg-danger">Admin</span>
                                    <?php elseif($user['role'] == 1): ?>
                                        <span class="badge bg-info text-dark">Critique</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">Membre</span>
                                    <?php endif; ?>
                                </td>
                                <td class="text-end">
                                    <?php if ($user['id'] != $_SESSION['user_id']): ?>
                                        <a href="index.php?page=admin-delete-user&id=<?= $user['id'] ?>" 
                                           class="btn btn-sm btn-outline-danger" 
                                           onclick="return confirm('Supprimer cet utilisateur ?')">
                                            <i class="fa-solid fa-trash"></i>
                                        </a>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="tab-pane fade" id="critiques" role="tabpanel">
            <form action="index.php?page=admin-bulk-delete" method="POST" id="bulk-form">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="selectAll">
                            <label class="form-check-label fw-bold" for="selectAll">Tout sélectionner</label>
                        </div>
                        <button type="submit" name="bulk_delete" class="btn btn-danger btn-sm fw-bold" onclick="return confirm('Supprimer la sélection ?')">
                            <i class="fa-solid fa-trash-can me-2"></i>Supprimer la sélection
                        </button>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th width="40"></th>
                                    <th>Titre</th>
                                    <th>Auteur</th>
                                    <th>Date</th>
                                    <th class="text-end">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($critiques as $critique): ?>
                                <tr>
                                    <td>
                                        <input class="form-check-input select-item" type="checkbox" name="ids[]" value="<?= $critique['id'] ?>">
                                    </td>
                                    <td class="fw-bold"><?= htmlspecialchars($critique['titre']) ?></td>
                                    <td><?= htmlspecialchars($critique['pseudo']) ?></td>
                                    <td><?= date('d/m/Y', strtotime($critique['date_publication'])) ?></td>
                                    <td class="text-end">
                                        <a href="index.php?page=admin-delete-critique&id=<?= $critique['id'] ?>" 
                                           class="btn btn-sm btn-outline-danger"
                                           onclick="return confirm('Supprimer cette critique ?')">
                                            <i class="fa-solid fa-xmark"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Logique "Tout sélectionner"
document.getElementById('selectAll').addEventListener('click', function() {
    const checkboxes = document.querySelectorAll('.select-item');
    checkboxes.forEach(cb => cb.checked = this.checked);
});
</script>