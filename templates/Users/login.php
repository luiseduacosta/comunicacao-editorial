<?php
/**
 * @var \App\View\AppView $this
 */
?>
<div class="row justify-content-center">
    <div class="col-md-5">
        <div class="card main-card p-4 p-md-5 shadow-lg border-0 my-5" style="background: rgba(255,255,255,0.95); backdrop-filter: blur(10px);">
            <div class="text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center bg-primary bg-gradient text-white rounded-circle p-3 mb-3 shadow" style="width: 70px; height: 70px;">
                    <i class="fa-solid fa-lock fa-2x"></i>
                </div>
                <h3 class="fw-bold text-dark mb-1">Acesso Restrito</h3>
                <p class="text-muted small">Por favor, entre com suas credenciais para continuar.</p>
            </div>

            <?= $this->Form->create(null, ['class' => 'needs-validation']) ?>
            <div class="mb-3">
                <label for="username" class="form-label fw-semibold text-secondary">Usuário</label>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-secondary"><i class="fa-regular fa-user"></i></span>
                    <?= $this->Form->control('username', [
                        'label' => false,
                        'required' => true,
                        'class' => 'form-control bg-light border-start-0 py-2.5 ps-0',
                        'placeholder' => 'Digite seu usuário',
                        'templates' => [
                            'inputContainer' => '{{content}}'
                        ]
                    ]) ?>
                </div>
            </div>

            <div class="mb-4">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <label for="password" class="form-label fw-semibold text-secondary mb-0">Senha</label>
                </div>
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0 text-secondary"><i class="fa-solid fa-key"></i></span>
                    <?= $this->Form->control('password', [
                        'label' => false,
                        'required' => true,
                        'class' => 'form-control bg-light border-start-0 py-2.5 ps-0',
                        'placeholder' => 'Digite sua senha',
                        'templates' => [
                            'inputContainer' => '{{content}}'
                        ]
                    ]) ?>
                </div>
            </div>

            <div class="d-grid mb-3">
                <button type="submit" class="btn btn-primary btn-lg rounded-pill py-2.5 fw-semibold shadow-sm hover-up">
                    <i class="fa-solid fa-right-to-bracket me-2"></i> Entrar
                </button>
            </div>
            <?= $this->Form->end() ?>

            <div class="text-center mt-3">
                <span class="text-muted small">Dúvidas ou problemas? Contate o suporte.</span>
            </div>
        </div>
    </div>
</div>

<style>
    .input-group-text {
        border-color: #dee2e6;
    }
    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13,110,253,.15);
    }
    .hover-up {
        transition: all 0.2s ease-in-out;
    }
    .hover-up:hover {
        transform: translateY(-2px);
    }
</style>
