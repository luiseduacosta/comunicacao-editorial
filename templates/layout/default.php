<?php
/**
 * @var \App\View\AppView $this
 */

$identity = $this->request->getAttribute('identity');
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        ANDES-SN Editorial: <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <!-- Google Fonts: Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Bootstrap 5 CSS CDN -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome for Premium Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

    <style>
        body {
            font-family: 'Outfit', sans-serif;
            background-color: #f6f8fa;
            color: #212529;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }
        .navbar-brand {
            font-weight: 700;
            letter-spacing: -0.5px;
        }
        .navbar-brand span {
            color: #0d6efd;
        }
        .main-card {
            border: none;
            border-radius: 16px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.05);
            background: #ffffff;
        }
        .footer {
            margin-top: auto;
            background: #212529;
            color: #adb5bd;
            padding: 2rem 0;
            font-size: 0.9rem;
        }
        /* Custom dynamic scrollbars */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }
        ::-webkit-scrollbar-track {
            background: #f1f1f1;
        }
        ::-webkit-scrollbar-thumb {
            background: #ccc;
            border-radius: 4px;
        }
        ::-webkit-scrollbar-thumb:hover {
            background: #aaa;
        }
    </style>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow-sm py-3">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="<?= $this->Url->build('/') ?>">
                <i class="fa-solid fa-newspaper text-primary me-2"></i>
                ANDES-SN<span>Editorial</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php if ($identity): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $this->Url->build('/pautas') ?>">
                                <i class="fa-solid fa-list-check me-1"></i> Pautas
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $this->Url->build('/materias') ?>">
                                <i class="fa-solid fa-file-lines me-1"></i> Matérias
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?= $this->Url->build('/tags') ?>">
                                <i class="fa-solid fa-tags me-1"></i> Tags
                            </a>
                        </li>
                        <?php if ($identity->role === 'admin'): ?>
                            <li class="nav-item">
                                <a class="nav-link" href="<?= $this->Url->build('/users') ?>">
                                    <i class="fa-solid fa-users me-1"></i> Usuários
                                </a>
                            </li>
                        <?php endif; ?>
                    <?php endif; ?>
                </ul>
                <div class="d-flex align-items-center">
                    <?php if ($identity): ?>
                        <span class="navbar-text text-light me-3">
                            <i class="fa-regular fa-user-circle me-1"></i> <?= h($identity->username) ?>
                        </span>
                        <a href="<?= $this->Url->build('/users/logout') ?>" class="btn btn-outline-danger btn-sm rounded-pill px-3">
                            <i class="fa-solid fa-sign-out-alt me-1"></i> Sair
                        </a>
                    <?php else: ?>
                        <a href="<?= $this->Url->build('/users/login') ?>" class="btn btn-primary btn-sm rounded-pill px-4">
                            <i class="fa-solid fa-sign-in-alt me-1"></i> Acessar
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content Container -->
    <main class="container my-5">
        <div class="row justify-content-center">
            <div class="col-12">
                <?= $this->Flash->render() ?>
                <?= $this->fetch('content') ?>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer">
        <div class="container text-center">
            <p class="mb-0">© 2026 ANDES-SN - Sistema Editorial de Comunicação. Todos os direitos reservados.</p>
            <small class="text-muted">Desenvolvido com CakePHP 5 e Bootstrap 5</small>
        </div>
    </footer>

    <!-- Bootstrap 5 Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
