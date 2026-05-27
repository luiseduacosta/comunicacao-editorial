<?php
/**
 * @var \App\View\AppView $this
 */
use Cake\ORM\TableRegistry;

// Fetch dynamic database counts directly using TableLocator
$pautasTable = TableRegistry::getTableLocator()->get('Pautas');
$materiasTable = TableRegistry::getTableLocator()->get('Materias');
$tagsTable = TableRegistry::getTableLocator()->get('Tags');

$totalPautas = $pautasTable->find()->count();
$totalMaterias = $materiasTable->find()->count();
$totalTags = $tagsTable->find()->count();

// Fetch recent materias
$recentMaterias = $materiasTable->find()
    ->contain(['Pautas'])
    ->orderBy(['Materias.id' => 'DESC'])
    ->limit(5)
    ->all();

$identity = $this->request->getAttribute('identity');
?>

<div class="row mb-4 align-items-center">
    <div class="col-12">
        <h2 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-gauge text-primary me-2"></i>Painel Editorial
        </h2>
        <p class="text-muted mb-0">Bem-vindo ao sistema de planejamento editorial e matérias do ANDES-SN.</p>
    </div>
</div>

<!-- Stats row -->
<div class="row g-4 mb-5">
    <div class="col-md-4 col-12">
        <div class="card main-card shadow-sm border-0 h-100 bg-gradient text-white" style="background: linear-gradient(135deg, #0d6efd, #0b5ed7);">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-white-50 fw-semibold text-uppercase mb-2 small">Pautas Cadastradas</h6>
                    <h2 class="fw-bold mb-0"><?= h($totalPautas) ?></h2>
                </div>
                <div class="bg-white bg-opacity-10 rounded-circle p-3">
                    <i class="fa-solid fa-list-check fa-2x"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-12">
        <div class="card main-card shadow-sm border-0 h-100 bg-gradient text-white" style="background: linear-gradient(135deg, #198754, #157347);">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-white-50 fw-semibold text-uppercase mb-2 small">Matérias Produzidas</h6>
                    <h2 class="fw-bold mb-0"><?= h($totalMaterias) ?></h2>
                </div>
                <div class="bg-white bg-opacity-10 rounded-circle p-3">
                    <i class="fa-solid fa-file-lines fa-2x"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-4 col-12">
        <div class="card main-card shadow-sm border-0 h-100 bg-gradient text-white" style="background: linear-gradient(135deg, #ffc107, #ffb300);">
            <div class="card-body p-4 d-flex align-items-center justify-content-between">
                <div>
                    <h6 class="text-white-50 fw-semibold text-uppercase mb-2 small">Tags para Filtros</h6>
                    <h2 class="fw-bold mb-0"><?= h($totalTags) ?></h2>
                </div>
                <div class="bg-white bg-opacity-10 rounded-circle p-3 text-white">
                    <i class="fa-solid fa-tags fa-2x"></i>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-4">
    <!-- Quick Shortcuts Card -->
    <div class="col-lg-6 col-12">
        <div class="card main-card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-bolt text-primary me-2"></i> Acesso Rápido</h5>
            </div>
            <div class="card-body p-4">
                <div class="row g-3">
                    <div class="col-6">
                        <a href="<?= $this->Url->build('/pautas') ?>" class="quick-link-card d-block p-4 text-center border rounded-3 text-decoration-none hover-shadow">
                            <i class="fa-solid fa-list-check fa-2x text-primary mb-3"></i>
                            <h6 class="fw-bold text-dark mb-1">Pautas</h6>
                            <small class="text-muted small">Agendas editoriais</small>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= $this->Url->build('/pautas/add') ?>" class="quick-link-card d-block p-4 text-center border rounded-3 text-decoration-none hover-shadow">
                            <i class="fa-solid fa-plus-circle fa-2x text-success mb-3"></i>
                            <h6 class="fw-bold text-dark mb-1">Nova Pauta</h6>
                            <small class="text-muted small">Planejar pauta</small>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= $this->Url->build('/materias') ?>" class="quick-link-card d-block p-4 text-center border rounded-3 text-decoration-none hover-shadow">
                            <i class="fa-solid fa-file-lines fa-2x text-warning mb-3"></i>
                            <h6 class="fw-bold text-dark mb-1">Matérias</h6>
                            <small class="text-muted small">Redigir e editar</small>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="<?= $this->Url->build('/tags') ?>" class="quick-link-card d-block p-4 text-center border rounded-3 text-decoration-none hover-shadow">
                            <i class="fa-solid fa-tags fa-2x text-info mb-3"></i>
                            <h6 class="fw-bold text-dark mb-1">Categorias (Tags)</h6>
                            <small class="text-muted small">Gerenciar tags</small>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Materias Card -->
    <div class="col-lg-6 col-12">
        <div class="card main-card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-clock text-primary me-2"></i> Matérias Recentes</h5>
            </div>
            <div class="card-body p-4">
                <?php if ($recentMaterias->count() > 0): ?>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($recentMaterias as $m): ?>
                            <div class="d-flex align-items-center border-bottom pb-3 last-no-border">
                                <div class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 42px; height: 42px; min-width: 42px;">
                                    <i class="fa-solid fa-file-signature"></i>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h6 class="fw-bold text-dark mb-0 text-truncate small">
                                            <a href="<?= $this->Url->build(['controller' => 'Materias', 'action' => 'view', $m->id]) ?>" class="text-decoration-none text-dark hover-primary">
                                                <?= h($m->titulo) ?>
                                            </a>
                                        </h6>
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-10 small"><?= h($m->data->format('d/m/Y')) ?></span>
                                    </div>
                                    <p class="text-muted mb-0 small text-truncate">
                                        Pauta: <strong><?= $m->hasValue('pauta') ? h($m->pauta->descricao) : 'Sem Pauta' ?></strong>
                                    </p>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5">
                        <i class="fa-regular fa-bell-slash fa-3x mb-3 text-secondary opacity-25"></i>
                        <h6 class="fw-semibold">Nenhuma matéria cadastrada</h6>
                        <p class="small text-muted mb-0">Novas matérias aparecerão listadas aqui.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    .quick-link-card {
        background-color: #f8f9fa;
        transition: all 0.25s ease-in-out;
    }
    .quick-link-card:hover {
        background-color: #ffffff;
        box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        transform: translateY(-2px);
    }
    .last-no-border:last-child {
        border-bottom: none !important;
        padding-bottom: 0 !important;
    }
    .hover-primary:hover {
        color: #0d6efd !important;
    }
</style>
