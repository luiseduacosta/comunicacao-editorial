<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Materia> $materias
 * @var \Cake\ORM\Association\BelongsToMany $tags
 */

$arquivado = $this->request->getQuery('arquivado') === '1';
$informandes = $this->request->getQuery('informandes');
$tagId = $this->request->getQuery('tag_id');
$search = $this->request->getQuery('search');
?>
<div class="row mb-4 align-items-center">
    <div class="col-md-6 col-12">
        <h2 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-file-lines text-primary me-2"></i>
            <?= $arquivado ? 'Matérias Arquivadas' : 'Matérias Cadastradas' ?>
        </h2>
        <p class="text-muted mb-0">Gerencie a publicação e a distribuição de artigos jornalísticos do ANDES-SN.</p>
    </div>
    <div class="col-md-6 col-12 text-md-end text-start mt-3 mt-md-0">
        <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary rounded-pill px-4 shadow-sm hover-up">
            <i class="fa-solid fa-plus me-1"></i> Escrever Nova Matéria
        </a>
        <a href="<?= $this->Url->build(['action' => 'index', '?' => array_merge($this->request->getQueryParams(), ['export' => 'csv'])]) ?>" class="btn btn-outline-success rounded-pill px-4 ms-2 shadow-sm hover-up">
            <i class="fa-solid fa-file-csv me-1"></i> Exportar CSV
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
        <?= $this->Form->create(null, ['type' => 'get', 'class' => 'row g-3 align-items-end']) ?>
        <?php if ($arquivado): ?>
            <input type="hidden" name="arquivado" value="1">
        <?php endif; ?>
        
        <div class="col-md-3 col-12">
            <label for="search" class="form-label small fw-semibold text-secondary mb-1">Buscar por Texto</label>
            <?= $this->Form->control('search', [
                'label' => false,
                'type' => 'text',
                'value' => $search,
                'class' => 'form-control form-control-sm border-secondary-subtle',
                'placeholder' => 'Título ou conteúdo...',
                'templates' => ['inputContainer' => '{{content}}']
            ]) ?>
        </div>

        <div class="col-md-3 col-12">
            <label for="informandes" class="form-label small fw-semibold text-secondary mb-1">Veículo (Destino)</label>
            <?= $this->Form->select('informandes', [
                '' => 'Todos os veículos',
                '0' => 'Website (Notícias)',
                '1' => 'Newsletter (Informandes)'
            ], [
                'value' => $informandes,
                'class' => 'form-select form-select-sm border-secondary-subtle'
            ]) ?>
        </div>

        <div class="col-md-3 col-12">
            <label for="tag_id" class="form-label small fw-semibold text-secondary mb-1">Filtrar por Tag</label>
            <?= $this->Form->select('tag_id', $tags, [
                'value' => $tagId,
                'empty' => 'Todas as tags',
                'class' => 'form-select form-select-sm border-secondary-subtle'
            ]) ?>
        </div>

        <div class="col-md-3 col-12 d-flex gap-2">
            <button type="submit" class="btn btn-primary btn-sm rounded-pill flex-grow-1 py-2">
                <i class="fa-solid fa-magnifying-glass me-1"></i> Filtrar
            </button>
            <?php if (!empty($search) || ($informandes !== null && $informandes !== '') || !empty($tagId)): ?>
                <a href="<?= $this->Url->build(['action' => 'index', '?' => $arquivado ? ['arquivado' => '1'] : []]) ?>" class="btn btn-outline-danger btn-sm rounded-pill py-2 px-3" title="Limpar Filtros">
                    <i class="fa-solid fa-times"></i>
                </a>
            <?php endif; ?>
        </div>
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
                        <th class="py-3" style="cursor: pointer;">
                            <?= $this->Paginator->sort('titulo', 'Matéria') ?>
                        </th>
                        <th class="py-3 text-center" style="width: 120px; cursor: pointer;">
                            <?= $this->Paginator->sort('created', 'Data') ?>
                        </th>
                        <th class="py-3 text-center" style="width: 150px;">
                            <?= $this->Paginator->sort('informandes', 'Veículo') ?>
                        </th>
                        <th class="py-3 text-center" style="width: 120px;">Anexos</th>
                        <th class="py-3 text-center" style="width: 180px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($materias) && count($materias->toArray()) > 0): ?>
                        <?php foreach ($materias as $materia): ?>
                            <tr>
                                <td class="py-3 ps-4">
                                    <div class="text-dark fw-bold mb-1">
                                        <a href="<?= $this->Url->build(['action' => 'view', $materia->id]) ?>" class="text-decoration-none text-dark hover-primary">
                                            <?= h($materia->titulo) ?>
                                        </a>
                                    </div>
                                    <div class="d-flex flex-wrap align-items-center gap-2">
                                        <?php if ($materia->hasValue('pauta')): ?>
                                            <span class="text-secondary small me-2">
                                                <i class="fa-solid fa-hashtag small text-secondary me-1"></i>Pauta #<?= $materia->pauta->id ?>
                                            </span>
                                        <?php endif; ?>
                                        
                                        <?php if (!empty($materia->tags)): ?>
                                            <?php foreach ($materia->tags as $tag): ?>
                                                <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10 rounded-pill px-2 py-0.5" style="font-size: 0.75rem;">
                                                    <i class="fa-solid fa-tag me-1"></i><?= h($tag->nome) ?>
                                                </span>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </td>
                                <td class="py-3 text-center text-secondary small">
                                    <?php if ($materia->created): ?>
                                        <span title="<?= $materia->created->format('d/m/Y H:i:s') ?>">
                                            <?= $materia->created->format('d/m/Y') ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 text-center">
                                    <?php if ($materia->informandes): ?>
                                        <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-10 rounded-pill px-3 py-2 small">
                                            <i class="fa-solid fa-envelope me-1"></i> Newsletter
                                        </span>
                                    <?php else: ?>
                                        <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-10 rounded-pill px-3 py-2 small">
                                            <i class="fa-solid fa-globe me-1"></i> Website
                                        </span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 text-center text-secondary">
                                    <?php
                                    $anexosCount = !empty($materia->anexos) ? count(explode(',', $materia->anexos)) : 0;
                                    if ($anexosCount > 0): ?>
                                        <span class="badge bg-dark bg-opacity-10 text-dark border border-dark border-opacity-10 rounded-pill px-2.5 py-1.5 small">
                                            <i class="fa-solid fa-paperclip me-1"></i> <?= $anexosCount ?>
                                        </span>
                                    <?php else: ?>
                                        <span class="text-muted small">-</span>
                                    <?php endif; ?>
                                </td>
                                <td class="py-3 text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <a href="<?= $this->Url->build(['action' => 'view', $materia->id]) ?>" class="btn btn-outline-primary btn-sm rounded-circle d-inline-flex align-items-center justify-content-center p-2" title="Visualizar" style="width: 32px; height: 32px;">
                                            <i class="fa-solid fa-eye small"></i>
                                        </a>
                                        <a href="<?= $this->Url->build(['action' => 'edit', $materia->id]) ?>" class="btn btn-outline-secondary btn-sm rounded-circle d-inline-flex align-items-center justify-content-center p-2" title="Editar" style="width: 32px; height: 32px;">
                                            <i class="fa-solid fa-pen small"></i>
                                        </a>
                                        <?php if ($materia->arquivar): ?>
                                            <?= $this->Form->postLink('<i class="fa-solid fa-box-open small"></i>', ['action' => 'restore', $materia->id], [
                                                'escape' => false,
                                                'class' => 'btn btn-outline-success btn-sm rounded-circle d-inline-flex align-items-center justify-content-center p-2',
                                                'title' => 'Desarquivar',
                                                'style' => 'width: 32px; height: 32px;',
                                                'confirm' => __('Deseja realmente desarquivar esta matéria?')
                                            ]) ?>
                                        <?php else: ?>
                                            <?= $this->Form->postLink('<i class="fa-solid fa-box small"></i>', ['action' => 'archive', $materia->id], [
                                                'escape' => false,
                                                'class' => 'btn btn-outline-warning btn-sm rounded-circle d-inline-flex align-items-center justify-content-center p-2',
                                                'title' => 'Arquivar',
                                                'style' => 'width: 32px; height: 32px;',
                                                'confirm' => __('Deseja realmente arquivar esta matéria?')
                                            ]) ?>
                                        <?php endif; ?>
                                        <?= $this->Form->postLink('<i class="fa-solid fa-trash small"></i>', ['action' => 'delete', $materia->id], [
                                            'escape' => false,
                                            'class' => 'btn btn-outline-danger btn-sm rounded-circle d-inline-flex align-items-center justify-content-center p-2',
                                            'title' => 'Excluir',
                                            'style' => 'width: 32px; height: 32px;',
                                            'confirm' => __('Deseja realmente excluir permanentemente esta matéria e todos os seus anexos?')
                                        ]) ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="fa-solid fa-newspaper fa-3x mb-3 text-secondary opacity-25"></i>
                                <h5 class="fw-bold">Nenhuma matéria encontrada</h5>
                                <p class="text-muted mb-0 small">Experimente redefinir os seus critérios de busca ou cadastre um novo artigo.</p>
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