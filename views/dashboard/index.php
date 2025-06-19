<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="page-title">
                <!-- Bradesco Logo Image in Dashboard Title -->
                <img src="https://upload.wikimedia.org/wikipedia/commons/a/a6/Banco_Bradesco_logo_%28horizontal%29.png" 
                     alt="Bradesco" 
                     class="bradesco-logo-title">
                Painel de Controle
            </h1>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-8 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-user-circle me-2"></i>Informações do Perfil
                    </h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="<?= isset($basePath) ? $basePath : '' ?>/dashboard/user/edit">
                        <input type="hidden" name="id" value="<?= $user['id'] ?>">
                        
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="name" class="form-label">
                                    <i class="fas fa-user me-1 text-bradesco"></i>Nome Completo
                                </label>
                                <input type="text" class="form-control border-bradesco" id="name" name="name" 
                                       value="<?= htmlspecialchars($user['name']) ?>" 
                                       placeholder="Digite seu nome completo" required>
                            </div>
                            
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">
                                    <i class="fas fa-envelope me-1 text-bradesco"></i>Endereço de E-mail
                                </label>
                                <input type="email" class="form-control border-bradesco" id="email" name="email" 
                                       value="<?= htmlspecialchars($user['email']) ?>" 
                                       placeholder="Digite seu e-mail" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-1 text-bradesco"></i>Nova Senha 
                                <small class="text-muted">(deixe em branco para manter a atual)</small>
                            </label>
                            <input type="password" class="form-control border-bradesco" id="password" name="password" 
                                   placeholder="Digite uma nova senha ou deixe em branco">
                        </div>
                        
                        <input type="hidden" name="role" value="<?= $user['role'] ?>">
                        
                        <button type="submit" class="btn btn-bradesco">
                            <i class="fas fa-save me-2"></i>Atualizar Perfil
                        </button>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-lg-4 mb-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-chart-line me-2"></i>Estatísticas Rápidas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="stats-card">
                                <i class="fas fa-tasks stats-icon text-bradesco"></i>
                                <div class="stats-number text-bradesco">12</div>
                                <small class="text-muted">Tarefas Ativas</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stats-card">
                                <i class="fas fa-check-circle stats-icon text-success"></i>
                                <div class="stats-number text-success">8</div>
                                <small class="text-muted">Concluídas</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mt-3 text-center">
                        <div class="row">
                            <div class="col-12">
                                <div class="stats-card bg-light">
                                    <i class="fas fa-calendar stats-icon text-bradesco" style="font-size: 2rem;"></i>
                                    <div style="font-size: 1.2rem; font-weight: bold; color: #6c757d;">
                                        Membro desde
                                    </div>
                                    <small class="text-muted">
                                        <?= date('M Y', strtotime($user['created_at'])) ?>
                                    </small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-rocket me-2"></i>Ações Rápidas
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <a href="<?= isset($basePath) ? $basePath : '' ?>/tasks/kanban" 
                               class="btn btn-outline-bradesco w-100 py-3">
                                <i class="fas fa-tasks fa-2x d-block mb-2"></i>
                                <strong>Ir para o Quadro Kanban</strong>
                                <small class="d-block text-muted">Gerencie suas tarefas</small>
                            </a>
                        </div>
                        <?php if (Session::get('user_role') === 'admin'): ?>
                        <div class="col-md-4 mb-3">
                            <a href="<?= isset($basePath) ? $basePath : '' ?>/dashboard/users" 
                               class="btn btn-outline-success w-100 py-3">
                                <i class="fas fa-users fa-2x d-block mb-2"></i>
                                <strong>Gerenciar Usuários</strong>
                                <small class="d-block text-muted">Painel administrativo</small>
                            </a>
                        </div>
                        <?php endif; ?>
                        <div class="col-md-4 mb-3">
                            <button class="btn btn-outline-info w-100 py-3" 
                                    data-bs-toggle="modal" data-bs-target="#createTaskModal">
                                <i class="fas fa-plus fa-2x d-block mb-2"></i>
                                <strong>Criar Nova Tarefa</strong>
                                <small class="d-block text-muted">Adicionar ao seu quadro</small>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Criar Tarefa -->
<div class="modal fade" id="createTaskModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-bradesco text-white">
                <h5 class="modal-title">
                    <i class="fas fa-plus me-2"></i>Criar Nova Tarefa
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="<?= isset($basePath) ? $basePath : '' ?>/tasks/create">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="taskTitle" class="form-label">
                            <i class="fas fa-heading me-1 text-bradesco"></i>Título da Tarefa
                        </label>
                        <input type="text" class="form-control border-bradesco" id="taskTitle" name="title" 
                               placeholder="Digite o título da tarefa..." required>
                    </div>
                    <div class="mb-3">
                        <label for="taskDescription" class="form-label">
                            <i class="fas fa-align-left me-1 text-bradesco"></i>Descrição
                        </label>
                        <textarea class="form-control border-bradesco" id="taskDescription" name="description" 
                                  rows="3" placeholder="Digite a descrição da tarefa..."></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-bradesco">
                        <i class="fas fa-save me-2"></i>Criar Tarefa
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>