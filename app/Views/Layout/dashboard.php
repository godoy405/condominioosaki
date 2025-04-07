<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Soft UI Dashboard</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper">
                <div class="sidebar-header">
                    <div class="logo">
                        <img src="<?= site_url('assets/images/logo.png') ?>" alt="Soft UI Dashboard">
                        <span>Soft UI Dashboard</span>
                    </div>
                </div>

                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-item">
                            <a href="<?= site_url('dashboard') ?>" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class="sidebar-item">
                            <a href="<?= site_url('reservas/gerenciar') ?>" class='sidebar-link'>
                                <i class="bi bi-calendar2-week"></i>
                                <span>Gerenciar reservas</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="main">
            <header class="mb-3">
                <div class="header-title">
                    <h3><?= $title ?? 'Dashboard' ?></h3>
                </div>
            </header>

            <div class="page-content">
                <?= $this->renderSection('content') ?>
            </div>
        </div>
    </div>
</body>
</html>