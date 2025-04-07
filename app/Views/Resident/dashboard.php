<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="sidebar-header">
            <div class="d-flex justify-content-between">
                <div class="logo">
                    <a href="<?= site_url('resident/dashboard') ?>">Soft UI Dashboard</a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-item active">
                    <a href="<?= site_url('resident/dashboard') ?>" class="sidebar-link">
                        <i class="bi bi-grid-fill"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="sidebar-item">
                    <a href="<?= site_url('resident/reservations/manage') ?>" class="sidebar-link">
                        <i class="bi bi-calendar2-week"></i>
                        <span>Gerenciar reservas</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>