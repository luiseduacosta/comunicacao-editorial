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
            <i class="fa-solid fa-file-pen text-primary me-2"></i>Escrever Nova Matéria
        </h2>
        <p class="text-muted mb-0">Cadastre um novo artigo jornalístico, vincule-o a uma pauta e envie arquivos anexos.</p>
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
                            'placeholder' => 'Digite o título principal da matéria...',
                            'templates' => ['inputContainer' => '{{content}}']
                        ]) ?>
                    </div>

                    <div class="col-md-6 col-12">
                        <label for="pauta-id" class="form-label fw-semibold text-secondary">Vincular a Pauta</label>
                        <?= $this->Form->control('pauta_id', [
                            'label' => false,
                            'options' => $pautas,
                            'empty' => 'Sem Pauta Vinculada',
                            'required' => false,
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
                            'id' => 'conteudo',
                            'rows' => 12,
                            'required' => true,
                            'class' => 'form-control bg-light',
                            'placeholder' => 'Digite ou cole o texto completo da reportagem ou artigo aqui...',
                            'templates' => ['inputContainer' => '{{content}}']
                        ]) ?>
                    </div>

                    <div class="col-md-6 col-12">
                        <label class="form-label fw-semibold text-secondary">Tags (Categorias)</label>
                        <div class="p-3 bg-light rounded border" style="max-height: 200px; overflow-y: auto;">
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
                        <div class="text-muted small mt-1">Marque todas as categorias que se aplicam a esta matéria.</div>
                    </div>

                    <div class="col-md-6 col-12">
                        <label class="form-label fw-semibold text-secondary">Enviar Anexos (Múltiplos Arquivos)</label>
                        <div class="input-group mb-2">
                            <span class="input-group-text bg-light"><i class="fa-solid fa-paperclip"></i></span>
                            <?= $this->Form->control('upload_files[]', [
                                'type' => 'file',
                                'multiple' => true,
                                'label' => false,
                                'class' => 'form-control bg-light py-2.5',
                                'templates' => ['inputContainer' => '{{content}}']
                            ]) ?>
                        </div>
                        <div class="text-muted small">Você pode selecionar múltiplos arquivos (documentos, imagens, PDFs) mantendo pressionado Ctrl ou Shift ao selecionar os arquivos.</div>
                    </div>

                    <div class="col-12 mt-5 border-top pt-4">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn btn-outline-danger rounded-pill px-4 py-2">
                                <i class="fa-solid fa-times me-1"></i> Cancelar
                            </a>
                            <?= $this->Form->button('Salvar Matéria', [
                                'type' => 'submit',
                                'class' => 'btn btn-success rounded-pill px-4 py-2 shadow-sm',
                            ]) ?>
                        </div>
                    </div>
                </div>

                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.css">
<script src="https://cdn.jsdelivr.net/npm/easymde/dist/easymde.min.js"></script>
<script>
    (function () {
        var textarea = document.getElementById('conteudo');
        if (!textarea) {
            return;
        }
        
        var easyMDE = new EasyMDE({
            element: textarea,
            autofocus: false,
            spellChecker: false,
            status: false
        });
        
        // Garantir que o textarea original fica visível para validação
        textarea.style.display = 'block';
        
        // Sincronizar conteúdo do editor antes de enviar o formulário
        var form = textarea.closest('form');
        if (form) {
            form.addEventListener('submit', function(e) {
                // Garantir que o conteúdo do editor seja sincronizado com o textarea
                var content = easyMDE.value();
                textarea.value = content;
                
                // Validar se o campo obrigatório está preenchido
                if (!content || content.trim() === '') {
                    e.preventDefault();
                    alert('Por favor, preencha o campo Conteúdo da Matéria.');
                    return false;
                }
            });
        }
    })();
</script>
