<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Materia $materia
 * @var \Cake\Collection\CollectionInterface|string[] $pautas
 * @var \Cake\Collection\CollectionInterface|string[] $tags
 */
?>
<div class="row mb-4 align-items-center">
    <div class="col-12 col-md-8">
        <h2 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-file-signature text-primary me-2"></i>Editar Matéria #<?= h($materia->id) ?>
        </h2>
        <p class="text-muted mb-0">Atualize os detalhes do artigo jornalístico, gerencie anexos e categorias.</p>
    </div>
    <div class="col-12 col-md-4 text-md-end text-start mt-3 mt-md-0">
        <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fa-solid fa-arrow-left me-1"></i> Voltar para Lista
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-10 col-12">
        <div class="card main-card shadow-sm border-0">
            <div class="card-body p-4 p-md-5">
                <?= $this->Form->create($materia, ['type' => 'file', 'class' => 'needs-validation']) ?>
                
                <div class="row g-4">
                    <div class="col-md-6 col-12">
                        <label for="titulo" class="form-label fw-semibold text-secondary">Título da Matéria</label>
                        <?= $this->Form->control('titulo', [
                            'label' => false,
                            'required' => true,
                            'class' => 'form-control bg-light py-2.5',
                            'templates' => ['inputContainer' => '{{content}}']
                        ]) ?>
                    </div>

                    <div class="col-md-6 col-12">
                        <label for="pauta-id" class="form-label fw-semibold text-secondary">Vincular a Pauta (Opcional)</label>
                        <?= $this->Form->control('pauta_id', [
                            'label' => false,
                            'options' => $pautas,
                            'empty' => 'Sem Pauta Vinculada',
                            'class' => 'form-select bg-light py-2.5',
                            'templates' => ['inputContainer' => '{{content}}']
                        ]) ?>
                    </div>

                    <div class="col-md-6 col-12 d-flex align-items-center mt-md-3 mt-3 ps-md-4">
                        <div class="form-check form-switch p-3 bg-light rounded border w-100 ps-5">
                            <?= $this->Form->checkbox('publicar', [
                                'id' => 'publicar',
                                'class' => 'form-check-input ms-n5 mt-1',
                                'role' => 'switch'
                            ]) ?>
                            <label class="form-check-label fw-semibold text-dark ps-2" for="publicar">
                                Publicar
                            </label>
                            <div class="text-muted small ps-2 mt-1">Se ativado, a matéria será publicada.</div>
                        </div>
                    </div>

                    <div class="col-md-6 col-12 d-flex align-items-center mt-md-3 mt-3 ps-md-4">
                        <div class="form-check form-switch p-3 bg-light rounded border w-100 ps-5">
                            <?= $this->Form->checkbox('informandes', [
                                'id' => 'informandes',
                                'class' => 'form-check-input ms-n5 mt-1',
                                'role' => 'switch'
                            ]) ?>
                            <label class="form-check-label fw-semibold text-dark ps-2" for="informandes">
                                Destinar para a Newsletter (Informandes)
                            </label>
                            <div class="text-muted small ps-2 mt-1">Se ativado, irá para a newsletter. Do contrário, irá para o Website.</div>
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="conteudo" class="form-label fw-semibold text-secondary">Conteúdo / Texto do Artigo</label>
                        <?= $this->Form->control('conteudo', [
                            'label' => false,
                            'type' => 'textarea',
                            'rows' => 12,
                            'required' => true,
                            'class' => 'form-control bg-light',
                            'templates' => ['inputContainer' => '{{content}}']
                        ]) ?>
                    </div>

                    <div class="col-md-6 col-12">
                        <label class="form-label fw-semibold text-secondary">Tags (Categorias)</label>
                        <div class="p-3 bg-light rounded border" style="max-height: 250px; overflow-y: auto;">
                            <?= $this->Form->control('tags._ids', [
                                'type' => 'select',
                                'multiple' => 'checkbox',
                                'options' => $tags,
                                'label' => false,
                                'class' => 'form-check-input me-2',
                                'templates' => [
                                    'checkboxWrapper' => '<div class="form-check mb-2">{{label}}</div>',
                                    'nestingLabel' => '{{hidden}}{{input}}<label class="form-check-label text-dark">{{text}}</label>',
                                    'inputContainer' => '{{content}}'
                                ]
                            ]) ?>
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <!-- Upload new attachments -->
                        <div class="mb-4">
                            <label class="form-label fw-semibold text-secondary">Adicionar Mais Anexos</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="fa-solid fa-paperclip"></i></span>
                                <?= $this->Form->control('upload_files[]', [
                                    'type' => 'file',
                                    'multiple' => true,
                                    'label' => false,
                                    'class' => 'form-control bg-light py-2.5',
                                    'templates' => ['inputContainer' => '{{content}}']
                                ]) ?>
                            </div>
                        </div>

                        <!-- Existing attachments manager -->
                        <div>
                            <label class="form-label fw-semibold text-secondary">Anexos Cadastrados</label>
                            <?php if (!empty($materia->anexos)): ?>
                                <div class="list-group">
                                    <?php foreach (explode(',', $materia->anexos) as $file): ?>
                                        <div class="list-group-item d-flex align-items-center justify-content-between p-3 bg-light border-0 mb-2 rounded">
                                            <div class="d-flex align-items-center overflow-hidden">
                                                <i class="fa-regular fa-file text-primary me-2 flex-shrink-0"></i>
                                                <span class="text-dark small text-truncate" title="<?= h($file) ?>"><?= h($file) ?></span>
                                            </div>
                                            <a href="<?= $this->Url->build(['action' => 'edit', $materia->id, '?' => ['delete_file' => $file]]) ?>" 
                                               class="btn btn-outline-danger btn-sm rounded-circle d-inline-flex align-items-center justify-content-center p-2"
                                               style="width: 28px; height: 28px;"
                                               title="Excluir arquivo anexo"
                                               onclick="return confirm('Deseja realmente remover permanentemente este arquivo anexo?')">
                                                <i class="fa-solid fa-times small"></i>
                                            </a>
                                        </div>
                                    <?php endforeach; ?>
                                </div>
                            <?php else: ?>
                                <div class="p-3 border rounded text-center text-muted small bg-light bg-opacity-50">Nenhum anexo cadastrado nesta matéria.</div>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-12 mt-5 border-top pt-4">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn btn-outline-danger rounded-pill px-4 py-2">
                                <i class="fa-solid fa-times me-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-success rounded-pill px-4 py-2 shadow-sm">
                                <i class="fa-solid fa-save me-1"></i> Salvar Matéria
                            </button>
                        </div>
                    </div>
                </div>

                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
