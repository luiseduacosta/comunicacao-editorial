<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Pauta> $pautas
 */

$arquivado = $this->request->getQuery('arquivado') === '1';
$informandes = $this->request->getQuery('informandes');
?>
<div class="row mb-4 align-items-center">
    <div class="col-md-6 col-12">
        <h2 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-list-check text-primary me-2"></i>
            <?= $arquivado ? 'Pautas Arquivadas' : 'Pautas Editorial' ?>
        </h2>
        <p class="text-muted mb-0">Planejamento e agendas editoriais para publicação do ANDES-SN.</p>
    </div>
    <div class="col-md-6 col-12 text-md-end text-start mt-3 mt-md-0">
        <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary rounded-pill px-4 shadow-sm hover-up">
            <i class="fa-solid fa-plus me-1"></i> Planejar Nova Pauta
        </a>
        <?php if ($arquivado): ?>
            <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn btn-outline-secondary rounded-pill px-4 ms-2">
                <i class="fa-solid fa-list me-1"></i> Ver Ativas
            </a>
        <?php else: ?>
            <a href="<?= $this->Url->build(['action' => 'index', '?' => ['arquivado' => '1']]) ?>" class="btn btn-outline-secondary rounded-pill px-4 ms-2">
                <i class="fa-solid fa-archive me-1"></i> Ver Arquivadas
            </a>
        <?php endif; ?>
    </div>
</div>

<!-- Filters Card -->
<div class="card main-card shadow-sm border-0 mb-4">
    <div class="card-body p-3">
        <?= $this->Form->create(null, ['type' => 'get', 'class' => 'row g-3 align-items-center']) ?>
        <?php if ($arquivado): ?>
            <input type="hidden" name="arquivado" value="1">
        <?php endif; ?>
        <div class="col-md-4 col-12">
            <label for="informandes" class="form-label small fw-semibold text-secondary mb-1">Destinação (Veículo)</label>
            <?= $this->Form->select('informandes', [
                '' => 'Todos os veículos',
                '0' => 'Website (Notícias)',
                '1' => 'Newsletter (Informandes)'
            ], [
                'value' => $informandes,
                'class' => 'form-select form-select-sm border-secondary-subtle'
            ]) ?>
        </div>
        <div class="col-md-2 col-12 mt-md-4 pt-md-2">
            <button type="submit" class="btn btn-primary btn-sm rounded-pill w-100 py-2">
                <i class="fa-solid fa-filter me-1"></i> Filtrar
            </button>
        </div>
        <?php if ($informandes !== null && $informandes !== ''): ?>
            <div class="col-md-2 col-12 mt-md-4 pt-md-2">
                <a href="<?= $this->Url->build(['action' => 'index', '?' => $arquivado ? ['arquivado' => '1'] : []]) ?>" class="btn btn-outline-danger btn-sm rounded-pill w-100 py-2">
                    <i class="fa-solid fa-times me-1"></i> Limpar
                </a>
            </div>
        <?php endif; ?>
        <?= $this->Form->end() ?>
    </div>
</div>

<!-- Table Card -->
<div class="card main-card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="py-3 ps-4" style="width: 120px; cursor: pointer;">
                            <?= $this->Paginator->sort('data', 'Data') ?>
                        </th>
                        <th class="py-3" style="cursor: pointer;">
                            <?= $this->Paginator->sort('titulo', 'Título') ?>
                        </th>
                        <th class="py-3" style="cursor: pointer;">
                            <?= $this->Paginator->sort('descricao', 'Descrição') ?>
                        </th>
                        <th class="py-3 text-center" style="width: 180px;">
                            <?= $this->Paginator->sort('informandes', 'Destinação') ?>
                        </th>
                        <th class="py-3 text-center" style="width: 180px;">
                            Ações
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($pautas) && count($pautas->toArray()) > 0): ?>
                        <?php foreach ($pautas as $pauta): ?>
                            <tr>
                                <td class="py-3 ps-4 fw-semibold text-dark">
                                    <?= h($pauta->data->format('d/m/Y')) ?>
                                </td>
                                <td class="py-3">
                                    <div class="text-dark fw-bold mb-1">
                                        <a href="<?= $this->Url->build(['action' => 'view', $pauta->id]) ?>" class="text-decoration-none text-dark hover-primary">
                                            Pauta #<?= $pauta->id ?>
                                        </a>
                                    </div>
                                    <div class="text-muted small text-truncate-2" style="max-height: 40px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                        <?= h($pauta->titulo ?: 'Sem título informado.') ?>
                                    </div>
                                </td>
                                <td class="py-3">
                                    <div class="text-muted small text-truncate-2" style="max-height: 40px; overflow: hidden; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical;">
                                        <?= h($pauta->descricao ?: 'Sem descrição informada.') ?>
                                    </div>
                                </td>
                                <td class="py-3 text-center">
                                    <?php if ($pauta->informandes): ?>
                                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-10 rounded-pill px-3 py-2 small">
                                            <i class="fa-solid fa-envelope me-1"></i> Newsletter
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-10 rounded-pill px-3 py-2 small">
                                            <i class="fa-solid fa-globe me-1"></i> Website
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <a href="<?= $this->Url->build(['action' => 'view', $pauta->id]) ?>" class="btn btn-outline-primary btn-sm rounded-circle d-inline-flex align-items-center justify-content-center p-2" title="Visualizar" style="width: 32px; height: 32px;">
                                            <i class="fa-solid fa-eye small"></i>
                                        </a>
                                        <a href="<?= $this->Url->build(['action' => 'edit', $pauta->id]) ?>" class="btn btn-outline-secondary btn-sm rounded-circle d-inline-flex align-items-center justify-content-center p-2" title="Editar" style="width: 32px; height: 32px;">
                                            <i class="fa-solid fa-pen small"></i>
                                        </a>
                                        <?php if ($pauta->arquivar): ?>
                                            <?= $this->Form->postLink('<i class="fa-solid fa-box-open small"></i>', ['action' => 'restore', $pauta->id], [
                                                'escape' => false,
                                                'class' => 'btn btn-outline-success btn-sm rounded-circle d-inline-flex align-items-center justify-content-center p-2',
                                                'title' => 'Desarquivar',
                                                'style' => 'width: 32px; height: 32px;',
                                                'confirm' => __('Deseja realmente desarquivar esta pauta?')
                                            ]) ?>
                                        <?php else: ?>
                                            <?= $this->Form->postLink('<i class="fa-solid fa-box small"></i>', ['action' => 'archive', $pauta->id], [
                                                'escape' => false,
                                                'class' => 'btn btn-outline-warning btn-sm rounded-circle d-inline-flex align-items-center justify-content-center p-2',
                                                'title' => 'Arquivar',
                                                'style' => 'width: 32px; height: 32px;',
                                                'confirm' => __('Deseja realmente arquivar esta pauta?')
                                            ]) ?>
                                        <?php endif; ?>
                                        <?= $this->Form->postLink('<i class="fa-solid fa-trash small"></i>', ['action' => 'delete', $pauta->id], [
                                            'escape' => false,
                                            'class' => 'btn btn-outline-danger btn-sm rounded-circle d-inline-flex align-items-center justify-content-center p-2',
                                            'title' => 'Excluir',
                                            'style' => 'width: 32px; height: 32px;',
                                            'confirm' => __('Deseja realmente excluir permanentemente esta pauta?')
                                        ]) ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center py-5">
                                <i class="fa-solid fa-folder-open fa-3x mb-3 text-secondary opacity-25"></i>
                                <h5 class="fw-bold">Nenhuma pauta encontrada</h5>
                                <p class="text-muted mb-0 small">Experimente mudar seus filtros de busca ou cadastre uma nova pauta.</p>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Pagination -->
<div class="d-flex flex-column flex-md-row align-items-center justify-content-between mt-4">
    <div class="text-muted small mb-3 mb-md-0">
        <?= $this->Paginator->counter(__('Página {{page}} de {{pages}}, mostrando {{current}} registros de {{count}} no total')) ?>
    </div>
    <nav>
        <ul class="pagination pagination-sm justify-content-center mb-0">
            <?= $this->Paginator->first('<i class="fa-solid fa-angles-left"></i>', ['escape' => false]) ?>
            <?= $this->Paginator->prev('<i class="fa-solid fa-angle-left"></i>', ['escape' => false]) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next('<i class="fa-solid fa-angle-right"></i>', ['escape' => false]) ?>
            <?= $this->Paginator->last('<i class="fa-solid fa-angles-right"></i>', ['escape' => false]) ?>
        </ul>
    </nav>
</div>

<style>
    .hover-primary:hover {
        color: #0d6efd !important;
    }
    .hover-up {
        transition: all 0.2s ease-in-out;
    }
    .hover-up:hover {
        transform: translateY(-2px);
    }
    .pagination {
        gap: 4px;
    }
    .pagination li a, .pagination li span {
        border-radius: 6px;
        color: #495057;
        border-color: #dee2e6;
        padding: 6px 12px;
        text-decoration: none;
        display: block;
    }
    .pagination li.active span {
        background-color: #0d6efd;
        border-color: #0d6efd;
        color: #fff;
    }
    .pagination li.disabled span {
        color: #6c757d;
        background-color: #fff;
    }
</style>