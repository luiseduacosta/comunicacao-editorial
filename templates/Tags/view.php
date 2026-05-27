<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tag $tag
 */
?>
<div class="row mb-4 align-items-center">
    <div class="col-12 col-md-8">
        <h2 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-tag text-primary me-2"></i>Tag: <?= h($tag->nome) ?>
        </h2>
        <p class="text-muted mb-0">Visualize todas as matérias associadas a esta categoria taxonômica.</p>
    </div>
    <div class="col-12 col-md-4 text-md-end text-start mt-3 mt-md-0">
        <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fa-solid fa-arrow-left me-1"></i> Voltar para Lista
        </a>
        <a href="<?= $this->Url->build(['action' => 'edit', $tag->id]) ?>" class="btn btn-warning rounded-pill px-4 ms-2">
            <i class="fa-solid fa-edit me-1"></i> Editar
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Tag Details -->
    <div class="col-lg-4 col-12">
        <div class="card main-card shadow-sm border-0 h-100">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-circle-info text-primary me-2"></i> Detalhes da Categoria</h5>
            </div>
            <div class="card-body p-4">
                <div class="mb-3">
                    <span class="text-secondary small fw-semibold d-block mb-1">Nome da Tag</span>
                    <h5 class="fw-bold text-dark">
                        <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10 rounded-pill px-3 py-2">
                            <i class="fa-solid fa-tag me-1"></i><?= h($tag->nome) ?>
                        </span>
                    </h5>
                </div>
                <div class="mb-3 border-top pt-3">
                    <span class="text-secondary small fw-semibold d-block mb-1">Descrição</span>
                    <p class="text-muted small"><?= h($tag->descricao ?: 'Nenhuma descrição registrada.') ?></p>
                </div>
                <div class="mb-3 border-top pt-3">
                    <span class="text-secondary small fw-semibold d-block mb-1">Criada em</span>
                    <p class="text-dark small"><i class="fa-regular fa-clock me-1 text-secondary"></i> <?= h($tag->created->format('d/m/Y H:i')) ?></p>
                </div>
            </div>
        </div>
    </div>

    <!-- Associated Articles -->
    <div class="col-lg-8 col-12">
        <div class="card main-card shadow-sm border-0">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-file-lines text-primary me-2"></i> Matérias Classificadas</h5>
            </div>
            <div class="card-body p-4">
                <?php if (!empty($tag->materias)): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th class="py-3 ps-3" style="width: 120px;">Data</th>
                                    <th class="py-3">Título da Matéria</th>
                                    <th class="py-3 text-center" style="width: 150px;">Veículo</th>
                                    <th class="py-3 text-center" style="width: 100px;">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tag->materias as $materia): ?>
                                    <tr>
                                        <td class="py-3 ps-3 fw-semibold text-dark">
                                            <?= h($materia->data->format('d/m/Y')) ?>
                                        </td>
                                        <td class="py-3">
                                            <div class="text-dark fw-bold mb-0">
                                                <a href="<?= $this->Url->build(['controller' => 'Materias', 'action' => 'view', $materia->id]) ?>" class="text-decoration-none text-dark hover-primary">
                                                    <?= h($materia->titulo) ?>
                                                </a>
                                            </div>
                                        </td>
                                        <td class="py-3 text-center">
                                            <?php if ($materia->informandes): ?>
                                                <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-10 rounded-pill px-2.5 py-1.5" style="font-size: 0.75rem;">Newsletter</span>
                                            <?php else: ?>
                                                <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-10 rounded-pill px-2.5 py-1.5" style="font-size: 0.75rem;">Website</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="py-3 text-center">
                                            <a href="<?= $this->Url->build(['controller' => 'Materias', 'action' => 'view', $materia->id]) ?>" class="btn btn-outline-primary btn-sm rounded-circle d-inline-flex align-items-center justify-content-center p-2" title="Visualizar" style="width: 32px; height: 32px;">
                                                <i class="fa-solid fa-eye small"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5 border rounded-3 bg-light bg-opacity-50">
                        <i class="fa-solid fa-file-circle-question fa-3x mb-3 text-secondary opacity-25"></i>
                        <h6 class="fw-semibold text-secondary">Nenhuma matéria vinculada</h6>
                        <p class="small text-muted mb-0">Novas matérias categorizadas com "<?= h($tag->nome) ?>" aparecerão aqui.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<style>
    .hover-primary:hover {
        color: #0d6efd !important;
    }
</style>