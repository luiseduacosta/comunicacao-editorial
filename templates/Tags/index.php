<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Tag> $tags
 */
?>
<div class="row mb-4 align-items-center">
    <div class="col-md-6 col-12">
        <h2 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-tags text-primary me-2"></i>Gerenciar Tags (Categorias)
        </h2>
        <p class="text-muted mb-0">Gerencie a taxonomia de categorias usadas para filtrar matérias jornalísticas.</p>
    </div>
    <div class="col-md-6 col-12 text-md-end text-start mt-3 mt-md-0">
        <a href="<?= $this->Url->build(['action' => 'add']) ?>" class="btn btn-primary rounded-pill px-4 shadow-sm hover-up">
            <i class="fa-solid fa-plus me-1"></i> Criar Nova Tag
        </a>
    </div>
</div>

<!-- Table Card -->
<div class="card main-card shadow-sm border-0">
    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="py-3 ps-4" style="width: 250px;">Nome da Tag</th>
                        <th class="py-3">Descrição</th>
                        <th class="py-3 text-center" style="width: 150px;">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($tags) && count($tags->toArray()) > 0): ?>
                        <?php foreach ($tags as $tag): ?>
                            <tr>
                                <td class="py-3 ps-4 fw-bold text-dark">
                                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10 rounded-pill px-3 py-2">
                                        <i class="fa-solid fa-tag me-1"></i><?= h($tag->nome) ?>
                                    </span>
                                </td>
                                <td class="py-3 text-secondary">
                                    <?= h($tag->descricao ?: 'Nenhuma descrição informada.') ?>
                                </td>
                                <td class="py-3 text-center">
                                    <div class="d-flex align-items-center justify-content-center gap-2">
                                        <a href="<?= $this->Url->build(['action' => 'view', $tag->id]) ?>" class="btn btn-outline-primary btn-sm rounded-circle d-inline-flex align-items-center justify-content-center p-2" title="Ver Matérias" style="width: 32px; height: 32px;">
                                            <i class="fa-solid fa-eye small"></i>
                                        </a>
                                        <a href="<?= $this->Url->build(['action' => 'edit', $tag->id]) ?>" class="btn btn-outline-secondary btn-sm rounded-circle d-inline-flex align-items-center justify-content-center p-2" title="Editar" style="width: 32px; height: 32px;">
                                            <i class="fa-solid fa-pen small"></i>
                                        </a>
                                        <?= $this->Form->postLink('<i class="fa-solid fa-trash small"></i>', ['action' => 'delete', $tag->id], [
                                            'escape' => false,
                                            'class' => 'btn btn-outline-danger btn-sm rounded-circle d-inline-flex align-items-center justify-content-center p-2',
                                            'title' => 'Excluir',
                                            'style' => 'width: 32px; height: 32px;',
                                            'confirm' => __('Deseja realmente excluir permanentemente a tag "{0}"?', $tag->nome)
                                        ]) ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center py-5">
                                <i class="fa-solid fa-tags fa-3x mb-3 text-secondary opacity-25"></i>
                                <h5 class="fw-bold">Nenhuma tag cadastrada</h5>
                                <p class="text-muted mb-0 small">Comece adicionando uma nova tag de categoria clicando no botão acima.</p>
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