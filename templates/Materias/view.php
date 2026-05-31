<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Materia $materia
 * @var \App\Model\Entity\Observaco $observaco
 */

$identity = $this->request->getAttribute('identity');
?>
<div class="row mb-4 align-items-center">
    <div class="col-12 col-md-8">
        <h2 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-file-invoice text-primary me-2"></i>Visualizar Matéria
        </h2>
        <p class="text-muted mb-0">Confira o texto da matéria, gerencie arquivos anexos e colabore com observações.</p>
    </div>
    <div class="col-12 col-md-4 text-md-end text-start mt-3 mt-md-0">
        <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fa-solid fa-arrow-left me-1"></i> Voltar para Lista
        </a>
        <a href="<?= $this->Url->build(['action' => 'edit', $materia->id]) ?>" class="btn btn-warning rounded-pill px-4 ms-2">
            <i class="fa-solid fa-edit me-1"></i> Editar
        </a>
    </div>
</div>

<div class="row g-4">
    <!-- Main content: Article details and body -->
    <div class="col-lg-8 col-12">
        <div class="card main-card shadow-sm border-0 mb-4">
            <div class="card-body p-4 p-md-5">
                <div class="mb-4">
                    <h1 class="fw-bold text-dark mb-3"><?= h($materia->titulo) ?></h1>
                    
                    <div class="d-flex flex-wrap align-items-center gap-3 mb-4 border-bottom pb-3">
                        <div class="d-flex align-items-center">
                            <span class="text-secondary small fw-semibold me-2"><i class="fa-regular fa-calendar me-1"></i> Publicação:</span>
                            <span class="text-dark fw-bold"><?= h($materia->created->format('d/m/Y')) ?></span>
                        </div>
                        <div class="vr d-none d-md-block"></div>
                        <div class="d-flex align-items-center">
                            <span class="text-secondary small fw-semibold me-2"><i class="fa-solid fa-envelope-open-text me-1"></i> Veículo:</span>
                            <?php if ($materia->informandes): ?>
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
                            <?php if ($materia->arquivar): ?>
                                <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-10 rounded-pill px-3 py-1.5 small">Sim</span>
                            <?php else: ?>
                                <span class="badge bg-secondary bg-opacity-10 text-secondary border border-secondary border-opacity-10 rounded-pill px-3 py-1.5 small">Não</span>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- Tags list -->
                <?php if (!empty($materia->tags)): ?>
                    <div class="mb-4">
                        <?php foreach ($materia->tags as $tag): ?>
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10 rounded-pill px-3 py-1.5 me-2 mb-2" style="font-size: 0.85rem;">
                                <i class="fa-solid fa-tag me-1"></i><?= h($tag->nome) ?>
                            </span>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>

                <!-- Article Body -->
                <div class="mt-4 border-top pt-4">
                    <div class="text-dark p-1 markdown-body" id="conteudo-rendered" style="font-size: 1.1rem; line-height: 1.8; text-align: justify; letter-spacing: 0.2px;"></div>
                    <pre id="conteudo-markdown" class="d-none"><?= h($materia->conteudo) ?></pre>
                </div>
            </div>
        </div>

        <!-- Observations / Comments Section -->
        <div class="card main-card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold text-dark mb-0"><i class="fa-regular fa-comment-dots text-primary me-2"></i> Observações Internas</h5>
            </div>
            <div class="card-body p-4">
                <!-- Add observation form -->
                <div class="mb-4 pb-4 border-bottom">
                    <?= $this->Form->create($observaco, ['url' => ['controller' => 'Observacoes', 'action' => 'add'], 'class' => 'add-observation-form']) ?>
                    <?= $this->Form->hidden('materia_id', ['value' => $materia->id]) ?>
                    <div class="mb-3">
                        <label for="autor" class="form-label fw-semibold text-secondary small">Nome/Autor da Observação</label>
                        <?= $this->Form->control('autor', [
                            'label' => false,
                            'type' => 'text',
                            'maxlength' => 50,
                            'required' => true,
                            'class' => 'form-control bg-light',
                            'templates' => [
                                'inputContainer' => '{{content}}'
                            ]
                        ]) ?>
                    </div>
                    <div class="mb-3">
                        <label for="observacao" class="form-label fw-semibold text-secondary small">Adicionar Observação</label>
                        <?= $this->Form->control('observacao', [
                            'label' => false,
                            'type' => 'textarea',
                            'id' => 'observacao',
                            'rows' => 3,
                            'required' => true,
                            'class' => 'form-control bg-light',
                            'templates' => ['inputContainer' => '{{content}}']
                        ]) ?>
                    </div>
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">
                            <i class="fa-regular fa-paper-plane me-1"></i> Registrar
                        </button>
                    </div>
                    <?= $this->Form->end() ?>
                </div>

                <!-- Observations Feed -->
                <?php if (!empty($materia->observacoes)): ?>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach ($materia->observacoes as $o): ?>
                            <div class="d-flex p-3 bg-light rounded-3 border-0">
                                <div class="bg-primary bg-gradient text-white rounded-circle d-flex align-items-center justify-content-center me-3 shadow-sm" style="width: 40px; height: 40px; min-width: 40px; font-weight: 600;">
                                    <?= strtoupper(substr($o->hasValue('user') ? $o->user->username : 'A', 0, 1)) ?>
                                </div>
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <h6 class="fw-bold text-dark mb-0 small">
                                            <?= $o->hasValue('user') ? h($o->user->username) : ($o->autor ? h($o->autor) : 'Anónimo') ?>
                                        </h6>
                                        <div class="d-flex align-items-center gap-2">
                                            <small class="text-muted small"><?= h($o->created->format('d/m/Y H:i')) ?></small>
                                            <?php if ($identity && ($identity->id === $o->user_id || $identity->role === 'admin')): ?>
                                                <?= $this->Form->postLink('<i class="fa-regular fa-trash-can text-danger"></i>', ['controller' => 'Observacoes', 'action' => 'delete', $o->id], [
                                                    'escape' => false,
                                                    'class' => 'btn btn-link p-0 text-decoration-none',
                                                    'title' => 'Remover observação',
                                                    'confirm' => __('Deseja realmente remover esta observação?')
                                                ]) ?>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="text-muted small markdown-only js-observacao-rendered" data-observacao-source="observacao-<?= (int)$o->id ?>"></div>
                                    <pre id="observacao-<?= (int)$o->id ?>" class="d-none"><?= h($o->observacao) ?></pre>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4">
                        <i class="fa-regular fa-bell-slash fa-3x mb-3 text-secondary opacity-25"></i>
                        <h6 class="fw-semibold text-secondary">Nenhuma observação registrada</h6>
                        <p class="small text-muted mb-0">Registre observações ou revisões internas sobre o texto.</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Sidebar: Pauta metadata and file downloads -->
    <div class="col-lg-4 col-12">
        <!-- Linked Pauta -->
        <div class="card main-card shadow-sm border-0 mb-4">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-link text-primary me-2"></i> Pauta Originária</h5>
            </div>
            <div class="card-body p-4">
                <?php if ($materia->hasValue('pauta')): ?>
                    <div class="p-3 bg-light rounded-3 mb-3 border-start border-primary border-3">
                        <h6 class="fw-bold text-dark mb-1">
                            <a href="<?= $this->Url->build(['controller' => 'Pautas', 'action' => 'view', $materia->pauta->id]) ?>" class="text-decoration-none text-dark hover-primary">
                                Pauta #<?= $materia->pauta->id ?>
                            </a>
                        </h6>
                        <small class="text-secondary"><i class="fa-regular fa-calendar me-1"></i> <?= h($materia->pauta->data->format('d/m/Y')) ?></small>
                        <p class="text-muted small mb-0 mt-2 text-truncate-3" style="display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden;">
                            <?= h($materia->pauta->descricao) ?>
                        </p>
                    </div>
                    <a href="<?= $this->Url->build(['controller' => 'Pautas', 'action' => 'view', $materia->pauta->id]) ?>" class="btn btn-outline-primary rounded-pill w-100 btn-sm">
                        <i class="fa-solid fa-arrow-right me-1"></i> Ver Pauta Completa
                    </a>
                <?php else: ?>
                    <div class="text-center py-4 border rounded-3 bg-light bg-opacity-50">
                        <i class="fa-solid fa-unlink fa-2x mb-2 text-secondary opacity-25"></i>
                        <h6 class="small fw-semibold text-secondary mb-0">Sem pauta vinculada</h6>
                        <small class="text-muted">Esta matéria foi escrita de forma independente.</small>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- File attachments download manager -->
        <div class="card main-card shadow-sm border-0">
            <div class="card-header bg-white border-0 pt-4 px-4 pb-0">
                <h5 class="fw-bold text-dark mb-0"><i class="fa-solid fa-paperclip text-primary me-2"></i> Arquivos Anexos</h5>
            </div>
            <div class="card-body p-4">
                <?php if (!empty($materia->anexos)): ?>
                    <div class="d-flex flex-column gap-3">
                        <?php foreach (explode(',', $materia->anexos) as $file): ?>
                            <div class="d-flex align-items-center justify-content-between border-bottom pb-3 last-no-border">
                                <div class="d-flex align-items-center overflow-hidden me-2">
                                    <div class="bg-light text-primary rounded-circle d-flex align-items-center justify-content-center me-3" style="width: 36px; height: 36px; min-width: 36px;">
                                        <i class="fa-solid fa-file"></i>
                                    </div>
                                    <span class="text-dark small text-truncate" title="<?= h($file) ?>"><?= h($file) ?></span>
                                </div>
                                <a href="<?= $this->Url->build('/files/' . $file) ?>" class="btn btn-outline-success btn-sm rounded-circle d-inline-flex align-items-center justify-content-center p-2" style="width: 32px; height: 32px;" title="Baixar arquivo" download>
                                    <i class="fa-solid fa-download small"></i>
                                </a>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-center py-4 border rounded-3 bg-light bg-opacity-50">
                        <i class="fa-solid fa-file-circle-exclamation fa-2x mb-2 text-secondary opacity-25"></i>
                        <h6 class="small fw-semibold text-secondary mb-0">Nenhum anexo enviado</h6>
                        <small class="text-muted">Clique em Editar para enviar anexos.</small>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css">
<script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/marked/marked.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/dompurify/dist/purify.min.js"></script>
<script>
    (function () {
        var source = document.getElementById('conteudo-markdown');
        var target = document.getElementById('conteudo-rendered');
        if (source && target && typeof marked !== 'undefined' && typeof DOMPurify !== 'undefined') {
            marked.setOptions({
                gfm: true,
                breaks: true
            });

            var markdown = source.textContent || '';
            var unsafeHtml = marked.parse(markdown);
            target.innerHTML = DOMPurify.sanitize(unsafeHtml);

            var observacoes = document.querySelectorAll('[data-observacao-source]');
            for (var i = 0; i < observacoes.length; i++) {
                var el = observacoes[i];
                var id = el.getAttribute('data-observacao-source');
                if (!id) {
                    continue;
                }
                var src = document.getElementById(id);
                if (!src) {
                    continue;
                }
                var md = src.textContent || '';
                var html = marked.parse(md);
                el.innerHTML = DOMPurify.sanitize(html);
            }
        }

        var observacao = document.getElementById('observacao');
        if (observacao && typeof EasyMDE !== 'undefined') {
            new EasyMDE({
                element: observacao,
                autofocus: false,
                spellChecker: false,
                status: false,
                forceSync: true
            });
        }
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
