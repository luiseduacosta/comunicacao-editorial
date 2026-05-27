<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Pauta $pauta
 */
?>
<div class="row mb-4 align-items-center">
    <div class="col-12 col-md-8">
        <h2 class="fw-bold text-dark mb-1">
            <i class="fa-solid fa-plus-circle text-primary me-2"></i>Planejar Nova Pauta
        </h2>
        <p class="text-muted mb-0">Cadastre uma nova pauta para orientar a produção de matérias jornalísticas.</p>
    </div>
    <div class="col-12 col-md-4 text-md-end text-start mt-3 mt-md-0">
        <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn btn-outline-secondary rounded-pill px-4">
            <i class="fa-solid fa-arrow-left me-1"></i> Voltar para Lista
        </a>
    </div>
</div>

<div class="row justify-content-center">
    <div class="col-lg-8 col-12">
        <div class="card main-card shadow-sm border-0">
            <div class="card-body p-4 p-md-5">
                <?= $this->Form->create($pauta, ['class' => 'needs-validation']) ?>
                
                <div class="row g-4">
                    <div class="col-md-6 col-12">
                        <label for="titulo" class="form-label fw-semibold text-secondary">Título da Pauta</label>
                        <?= $this->Form->control('titulo', [
                            'label' => false,
                            'class' => 'form-control bg-light py-2.5',
                            'placeholder' => 'Digite o título da pauta...',
                            'templates' => [
                                'inputContainer' => '{{content}}'
                            ]
                        ]) ?>
                    </div>

                    <div class="col-md-6 col-12">
                        <label for="data" class="form-label fw-semibold text-secondary">Data de Planejamento</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fa-regular fa-calendar"></i></span>
                            <?= $this->Form->control('data', [
                                'label' => false,
                                'type' => 'date',
                                'required' => true,
                                'class' => 'form-control bg-light py-2.5',
                                'templates' => [
                                    'inputContainer' => '{{content}}'
                                ]
                            ]) ?>
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
                            <div class="text-muted small ps-2 mt-1">Se ativado, esta pauta integrará a newsletter. Do contrário, irá para o Website.</div>
                        </div>
                    </div>

                    <div class="col-md-6 col-12">
                        <label class="form-label fw-semibold text-secondary">Enviar Anexos</label>
                        <div class="input-group">
                            <span class="input-group-text bg-light"><i class="fa-solid fa-paperclip"></i></span>
                            <?= $this->Form->control('anexos', [
                                'label' => false,
                                'class' => 'form-control bg-light py-2.5',
                                'placeholder' => 'Caminho ou referência dos anexos...',
                                'templates' => ['inputContainer' => '{{content}}']
                            ]) ?>
                        </div>
                    </div>

                    <div class="col-12">
                        <label for="descricao" class="form-label fw-semibold text-secondary">Descrição da Pauta / Assunto Principal</label>
                        <?= $this->Form->control('descricao', [
                            'label' => false,
                            'type' => 'textarea',
                            'rows' => 6,
                            'class' => 'form-control bg-light',
                            'placeholder' => 'Descreva detalhadamente o assunto, diretrizes da reportagem, fontes sugeridas, prazos e orientações.',
                            'templates' => [
                                'inputContainer' => '{{content}}'
                            ]
                        ]) ?>
                    </div>

                    <div class="col-12">
                        <label for="observacoes" class="form-label fw-semibold text-secondary">Observações Adicionais</label>
                        <?= $this->Form->control('observacoes', [
                            'label' => false,
                            'type' => 'textarea',
                            'rows' => 3,
                            'class' => 'form-control bg-light',
                            'placeholder' => 'Adicione observações ou notas importantes sobre esta pauta...',
                            'templates' => [
                                'inputContainer' => '{{content}}'
                            ]
                        ]) ?>
                    </div>

                    <div class="col-12 mt-5 border-top pt-4">
                        <div class="d-flex justify-content-end gap-2">
                            <a href="<?= $this->Url->build(['action' => 'index']) ?>" class="btn btn-outline-danger rounded-pill px-4 py-2">
                                <i class="fa-solid fa-times me-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-success rounded-pill px-4 py-2 shadow-sm">
                                <i class="fa-solid fa-save me-1"></i> Salvar Pauta
                            </button>
                        </div>
                    </div>
                </div>

                <?= $this->Form->end() ?>
            </div>
        </div>
    </div>
</div>
