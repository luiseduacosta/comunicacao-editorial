<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pauta $pauta
 * @var \App\Model\Entity\Comentapauta $comentapauta
 */

$identity = $this->request->getAttribute('identity');
?>
<div class="row mb-4 align-items-center">
    <div class="col-12 col-md-8">
        <h2 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-file-invoice text-primary me-2"></i>Detalhes da Pauta #<?= h($pauta->id) ?>
        </h2>
        <p class="text-muted mb-0">Visualize o planejamento editorial, comentários e matérias associadas.</p>
    </div>
    <div class="col-12 col-md-4 text-md-end text-start mt-3 mt-md-0">
        <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fa-solid fa-arrow-left me-1"></i> Voltar para Lista
        </a>
        <a href="<?= $this->Url->build(['action' => 'edit', $pauta->id]) ?>" class="btn btn-warning rounded-pill px-4 ms-2">
            <i class="fa-solid fa-edit me-1"></i> Editar
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Pauta details -->
    <div class="col-lg-8 col-12">
        <div class="card main-card shadow-sm border-0 mb-4">
            <div class="card-body p-4 p-md-5">
                <div class="d-flex flex-wrap align-items-center gap-3 mb-4 border-bottom pb-3">
                    <div class="d-flex align-items-center">
                        <span class="text-secondary small fw-semibold me-2"><i class="fa-regular fa-calendar me-1"></i> Data:</span>
                        <span class="text-dark fw-bold"><?= h($pauta->data->format('d/m/Y')) ?></span>
                    </div>
                    <div class="vr d-none d-md-block"></div>
                    <div class="d-flex align-items-center">
                        <span class="text-secondary small fw-semibold me-2"><i class="fa-solid fa-envelope-open-text me-1"></i> Veículo:</span>
                        <?php if ($pauta->informandes): ?>
                            <span class="badge bg-warning bg-opacity-10 text-warning border border-warning border-opacity-10 rounded-pill px-3 py-1.5 small">
                                Newsletter (Informandes)
                            </span>
                        <?php else: ?>
                            <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-10 rounded-pill px-3 py-1.5 small">
                                Website
                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="vr d-none d-md-block"></div>
                    <div class="d-flex align-items-center">
                        <span class="text-secondary small fw-semibold me-2"><i class="fa-solid fa-box-archive me-1"></i> Arquivado:</span>
                        <?php if ($pauta->arquivar): ?>
                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-10 rounded-pill px-3 py-1.5 small">Sim</span>
                        <?php else: ?>
                            <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-10 rounded-pill px-3 py-1.5 small">Não</span>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mb-4">
                    <h5 class="fw-bold text-dark mb-3"><i class="fa-solid fa-align-left text-primary me-2"></i> Descrição / Diretrizes</h5>
                    <div class="p-4 bg-light rounded-3 text-dark border-start border-primary border-4 markdown-body" id="descricao-rendered" style="font-size: 1.05rem; line-height: 1.6;"></div>
                    <pre id="descricao-markdown" class="d-none"><?= h($pauta->descricao ?: 'Nenhuma descrição adicionada.') ?></pre>
                </div>
            </div>
        </div>

        <!-- Comments Section -->
        <div class="card main-card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold text-dark mb-0"><i class="fa-regular fa-comments text-primary me-2"></i> Discussão & Comentários</h5>
            </div>
            <div class="card-body p-4">
                <!-- Add comment form -->
                <div class="mb-4 pb-4 border-bottom">
                    <?= $this->Form->create($comentapauta, ['url' => ['controller' => 'Comentapautas', 'action' => 'add']]) ?>
                    <?= $this->Form->hidden('pauta_id', ['value' => $pauta->id]) ?>
                    <div class="mb-3">
                        <label for="autor" class="form-label fw-semibold text-secondary small">Nome/Autor do Comentário</label>
                        <?= $this->Form->control('autor', [
                            'label' => false,
                            'type' => 'text',
                            'maxlength' => 50,
                            'class' => 'form-control bg-light',
                            'placeholder' => 'Digite seu nome ou identificação...',
                            'templates' => [
                                'inputContainer' => '{{content}}'
                            ]
                        ]) ?>
                    </div>
                    <div class="mb-3">
                        <label for="comentario" class="form-label fw-semibold text-secondary small">Adicionar Comentário</label>
                        <?= $this->Form->control('comentario', [
                            'label' => false,
                            'type' => 'textarea',
                            'rows' => 3,
                            'required' => true,
                            'class' => 'form-control bg-light',
                            'placeholder' => 'Digite aqui sua observação, dúvida ou atualização sobre esta pauta...',
                            'templates' => [
                                'inputContainer' => '{{content}}'
                            ]
                        ]) ?>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                            <i class="fa-regular fa-paper-plane me-1"></i> Comentar
                        </button>
                    </div>
                    <?= $this->Form->end() ?>
                </div>

                <!-- Comments Feed -->
                <?php if (!empty($pauta->comentapautas)): ?>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($pauta->comentapautas as $c): ?>
                            <div class="d-flex p-3 bg-light rounded-3 border-0">
                                <div class="bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 40px; height: 40px; min-width: 40px; font-weight: 600;">
                                    <?= strtoupper(substr($c->hasValue('user') ? $c->user->username : 'A', 0, 1)) ?>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h6 class="fw-bold text-dark mb-0 small">
                                            <?= $c->hasValue('user') ? h($c->user->username) : h($c->autor) ?>
                                        </h6>
                                        <div class="d-flex align-items-center gap-2">
                                            <small class="text-muted small"><?= h($c->created->format('d/m/Y H:i')) ?></small>
                                            <?php if ($identity && ($identity->id === $c->user_id || $identity->role === 'admin')): ?>
                                                <?= $this->Form->postLink('<i class="fa-regular fa-trash-can text-danger"></i>', ['controller' => 'Comentapautas', 'action' => 'delete', $c->id], [
                                                    'escape' => false,
                                                    'class' => 'btn btn-link p-0 text-decoration-none',
                                                    'title' => 'Excluir comentário',
                                                    'confirm' => __('Deseja realmente remover este comentário?')
                                                ]) ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="text-muted small" style="white-space: pre-wrap;"><?= h($c->comentario) ?></div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fa-regular fa-comments fa-3x mb-3 text-secondary opacity-25"></i>
                        <h6 class="fw-semibold text-secondary">Nenhum comentário adicionado</h6>
                        <p class="small text-muted mb-0">Seja o primeiro a iniciar a discussão sobre esta pauta.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Related Articles -->
    <div class="col-lg-4 col-12">
        <div class="card main-card shadow-sm border-0">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0 d-flex justify-content-between align-items-center">
                <h5 class="fw-bold text-dark mb-0"><i class="fa-regular fa-file-lines text-primary me-2"></i> Matérias Relacionadas</h5>
            </div>
            <div class="card-body p-4">
                <div class="d-grid gap-3 mb-4">
                    <a href="<?= $this->Url->build(['controller' => 'Materias', 'action' => 'add', '?' => ['pauta_id' => $pauta->id]]) ?>" class="btn btn-outline-success rounded-pill w-100 py-2.5">
                        <i class="fa-solid fa-plus-circle me-1"></i> Escrever Matéria para Pauta
                    </a>
                </div>

                <?php if (!empty($pauta->materias)): ?>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($pauta->materias as $m): ?>
                            <div class="d-flex align-items-center border-bottom pb-3 last-no-border">
                                <div class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px; min-width: 40px;">
                                    <i class="fa-solid fa-file-lines"></i>
                                </div>
                                <div class="flex-grow-1 overflow-hidden">
                                    <h6 class="fw-bold text-dark mb-1 text-truncate small">
                                        <a href="<?= $this->Url->build(['controller' => 'Materias', 'action' => 'view', $m->id]) ?>" class="text-decoration-none text-dark hover-primary">
                                            <?= h($m->titulo) ?>
                                        </a>
                                    </h6>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <small class="text-muted small"><i class="fa-regular fa-calendar me-1"></i><?= h($m->created->format('d/m/Y H:i')) ?></small>
                                        <?php if ($m->arquivar): ?>
                                            <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-10 rounded-pill px-2 py-0.5 small" style="font-size: 0.75rem;">Arquivada</span>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4 border rounded-3 bg-light bg-opacity-50">
                        <i class="fa-regular fa-file-excel fa-2x mb-2 text-secondary opacity-25"></i>
                        <h6 class="small fw-semibold text-secondary mb-0">Nenhuma matéria vinculada</h6>
                        <small class="text-muted">Crie a primeira matéria a partir desta pauta clicando no botão acima.</small>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dompurify/dist/purify.min.js"></script>
<script>
    (function () {
        var source = document.getElementById('descricao-markdown');
        var target = document.getElementById('descricao-rendered');
        if (!source || !target || typeof marked === 'undefined' || typeof DOMPurify === 'undefined') {
            return;
        }

        marked.setOptions({
            gfm: true,
            breaks: true
        });

        var markdown = source.textContent || '';
        var unsafeHtml = marked.parse(markdown);
        target.innerHTML = DOMPurify.sanitize(unsafeHtml);
    })();
</script>
<style>
    .hover-primary:hover {
        color: #0d6efd !important;
    }
    .last-no-border:last-child {
        border-bottom: none !important;
        padding-bottom: 0 !important;
    }
</style>
