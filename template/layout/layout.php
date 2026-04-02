<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Revieweo - <?= $title ?? 'Accueil' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark mb-4 shadow-sm">
        <div class="container">
            <a class="navbar-brand fw-bold text-warning" href="index.php?page=home">REVIEWEO</a>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center">
                    <?php if (isset($_SESSION['user_id'])): ?>
                        
                        <?php if ($_SESSION['role'] == 2): ?>
                            <li class="nav-item me-2">
                                <a class="btn btn-danger btn-sm" href="index.php?page=admin">
                                    <i class="fa-solid fa-gauge"></i> Admin
                                </a>
                            </li>
                        <?php endif; ?>

                        <?php if ($_SESSION['role'] >= 1): ?>
                            <li class="nav-item me-3">
                                <a class="btn btn-outline-warning btn-sm" href="index.php?page=add-critique">+ Publier</a>
                            </li>
                        <?php endif; ?>
                        
                        <li class="nav-item"><span class="nav-link"><strong><?= htmlspecialchars($_SESSION['pseudo']) ?></strong></span></li>
                        <li class="nav-item"><a class="btn btn-danger btn-sm ms-2" href="index.php?page=logout">Quitter</a></li>
                    
                    <?php else: ?>
                        <li class="nav-item"><a class="nav-link" href="index.php?page=login">Connexion</a></li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <main class="container">
        <?= $content ?>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>