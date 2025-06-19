<div class="login-container">
    <div class="login-card">
        <div class="text-center mb-4">
            <!-- Bradesco Logo Image -->
            <div class="bradesco-logo mb-4">
                <img src="https://upload.wikimedia.org/wikipedia/commons/a/a6/Banco_Bradesco_logo_%28horizontal%29.png" 
                     alt="Bradesco" 
                     class="bradesco-logo-login">
            </div>
            <h2 class="fw-bold text-dark">Bem-vindo de Volta</h2>
            <p class="text-muted">Acesse sua conta para continuar</p>
        </div>
        
        <?php if (isset($error)): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle me-2"></i><?= $error ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
        <?php endif; ?>
        
        <form method="POST" action="<?= isset($basePath) ? $basePath : '' ?>/auth/login">
            <div class="mb-3">
                <label for="email" class="form-label fw-semibold">
                    <i class="fas fa-envelope me-2 text-bradesco"></i>Endereço de E-mail
                </label>
                <div class="input-group">
                    <span class="input-group-text border-bradesco">
                        <i class="fas fa-at text-bradesco"></i>
                    </span>
                    <input type="email" class="form-control form-control-lg border-bradesco" 
                           id="email" name="email" placeholder="Digite seu e-mail" required>
                </div>
            </div>
            
            <div class="mb-4">
                <label for="password" class="form-label fw-semibold">
                    <i class="fas fa-lock me-2 text-bradesco"></i>Senha
                </label>
                <div class="input-group">
                    <span class="input-group-text border-bradesco">
                        <i class="fas fa-key text-bradesco"></i>
                    </span>
                    <input type="password" class="form-control form-control-lg border-bradesco" 
                           id="password" name="password" placeholder="Digite sua senha" required>
                </div>
            </div>
            
            <div class="mb-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" id="rememberMe">
                    <label class="form-check-label text-muted" for="rememberMe">
                        Lembrar-me neste dispositivo
                    </label>
                </div>
            </div>
            
            <button type="submit" class="btn btn-bradesco btn-lg w-100 pulse-bradesco">
                <i class="fas fa-sign-in-alt me-2"></i>Entrar no Sistema
            </button>
        </form>
        
        <hr class="my-4">
        
        <div class="text-center">
            <div class="card bg-light border-0">
                <div class="card-body py-3">
                    <h6 class="card-title text-bradesco mb-2">
                        <i class="fas fa-info-circle me-2"></i>Credenciais de Demonstração
                    </h6>
                    <div class="row">
                        <div class="col-12">
                            <small class="text-muted d-block">
                                <strong>E-mail:</strong> admin@example.com
                            </small>
                            <small class="text-muted d-block">
                                <strong>Senha:</strong> password
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="text-center mt-4">
            <small class="text-muted">
                <i class="fas fa-lock me-1"></i>
                Seus dados estão protegidos com criptografia avançada
            </small>
        </div>
    </div>
</div>

<style>
.bradesco-logo {
    transition: transform 0.3s ease;
}

.bradesco-logo:hover {
    transform: scale(1.05);
}

.bradesco-logo-login {
    max-width: 200px;
    height: auto;
    filter: drop-shadow(0 4px 8px rgba(204, 9, 47, 0.3));
    transition: all 0.3s ease;
}

.bradesco-logo-login:hover {
    filter: drop-shadow(0 6px 12px rgba(204, 9, 47, 0.4));
    transform: scale(1.02);
}

/* Fallback in case image doesn't load */
.bradesco-logo-login[alt]:after {
    content: attr(alt);
    display: block;
    font-size: 2rem;
    font-weight: bold;
    color: var(--bradesco-red);
    text-align: center;
    padding: 20px;
    background: #f8f9fa;
    border-radius: 10px;
}
</style>