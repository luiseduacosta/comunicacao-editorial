<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Tag $tag
 */
?>
<div class="row mb-4 align-items-center">
    <div class="col-12 col-md-8">
        <h2 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-plus-circle text-primary me-2"></i>Criar Nova Tag
        </h2>
        <p class="text-muted mb-0">Adicione uma nova categoria taxonômica para categorizar e indexar suas matérias.</p>
    </div>
    <div class="col-12 col-md-4 text-md-end text-start mt-3 mt-md-0">
        <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fa-solid fa-arrow-left me-1"></i> Voltar para Lista
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-6 col-12">
        <div class="card main-card shadow-sm border-0">
            <div class="card-body p-4 p-md-5">
                <?= $this->Form->create($tag, ['class' => 'needs-validation']) ?>
                
                <div class="row g-4">
                    <div class="col-12">
                        <label for="nome" class="form-label fw-semibold text-secondary">Nome da Tag</label>
                        <?= $this->Form->control('nome', [
                            'label' => false,
                            'required' => true,
                            'class' => 'form-control bg-light py-2.5',
                            'placeholder' => 'Ex: Eleições, Greve, Congresso, Andes-SN...',
                            'templates' => ['inputContainer' => '{{content}}']
                        ]) ?>
                    </div>

                    <div class="col-12">
                        <label for="descricao" class="form-label fw-semibold text-secondary">Descrição da Tag (Opcional)</label>
                        <?= $this->Form->control('descricao', [
                            'label' => false,
                            'type' => 'textarea',
                            'rows' => 4,
                            'class' => 'form-control bg-light',
                            'placeholder' => 'Insira uma breve descrição sobre as matérias que se enquadram nesta categoria.',
                            'templates' => ['inputContainer' => '{{content}}']
                        ]) ?>
                    </div>

                    <div class="col-12">
                        <label for="observacoes" class="form-label fw-semibold text-secondary">Observações (Opcional)</label>
                        <?= $this->Form->control('observacoes', [
                            'label' => false,
                            'type' => 'textarea',
                            'rows' => 3,
                            'class' => 'form-control bg-light',
                            'placeholder' => 'Adicione observações ou notas sobre esta tag...',
                            'templates' => ['inputContainer' => '{{content}}']
                        ]) ?>
                    </div>

                    <div class="col-12 mt-5 border-top pt-4">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn btn-outline-danger rounded-pill px-4 py-2">
                                <i class="fa-solid fa-times me-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-success rounded-pill px-4 py-2 shadow-sm">
                                <i class="fa-solid fa-save me-1"></i> Salvar Tag
                            </button>
                        </div>
                    </div>
                </div>

                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
