<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="page-title">
                    <i class="fas fa-users me-3 text-bradesco"></i>Gerenciamento de Usuários
                </h1>
                <button class="btn btn-bradesco pulse-bradesco" data-bs-toggle="modal" data-bs-target="#createUserModal">
                    <i class="fas fa-user-plus me-2"></i>Adicionar Novo Usuário
                </button>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-list me-2"></i>Lista de Usuários
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-dark">
                                <tr>
                                    <th>ID</th>
                                    <th>Nome</th>
                                    <th>E-mail</th>
                                    <th>Função</th>
                                    <th>Criado em</th>
                                    <th>Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><span class="badge bg-light text-dark"><?= $user['id'] ?></span></td>
                                    <td>
                                        <i class="fas fa-user-circle me-2 text-bradesco"></i>
                                        <strong><?= htmlspecialchars($user['name']) ?></strong>
                                    </td>
                                    <td>
                                        <i class="fas fa-envelope me-1 text-muted"></i>
                                        <?= htmlspecialchars($user['email']) ?>
                                    </td>
                                    <td>
                                        <span class="badge <?= $user['role'] === 'admin' ? 'bg-bradesco' : 'bg-secondary' ?>">
                                            <i class="fas fa-<?= $user['role'] === 'admin' ? 'crown' : 'user' ?> me-1"></i>
                                            <?= $user['role'] === 'admin' ? 'Administrador' : 'Usuário' ?>
                                        </span>
                                    </td>
                                    <td>
                                        <i class="fas fa-calendar me-1 text-muted"></i>
                                        <?= date('d/m/Y', strtotime($user['created_at'])) ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button class="btn btn-sm btn-outline-primary" 
                                                    onclick="editUser(<?= htmlspecialchars(json_encode($user)) ?>)"
                                                    data-bs-toggle="tooltip" title="Editar usuário">
                                                <i class="fas fa-edit"></i>
                                            </button>
                                            <?php if ($user['id'] != Session::get('user_id')): ?>
                                            <button class="btn btn-sm btn-outline-danger" 
                                                    onclick="confirmDeleteUser(<?= $user['id'] ?>, '<?= htmlspecialchars($user['name']) ?>')"
                                                    data-bs-toggle="tooltip" title="Excluir usuário">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                            <?php else: ?>
                                            <button class="btn btn-sm btn-outline-secondary" disabled
                                                    data-bs-toggle="tooltip" title="Você não pode excluir sua própria conta">
                                                <i class="fas fa-ban"></i>
                                            </button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Criar Usuário -->
<div class="modal fade" id="createUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-bradesco text-white">
                <h5 class="modal-title">
                    <i class="fas fa-user-plus me-2"></i>Adicionar Novo Usuário
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="<?= isset($basePath) ? $basePath : '' ?>/dashboard/user/create">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="createName" class="form-label">
                            <i class="fas fa-user me-1 text-bradesco"></i>Nome Completo
                        </label>
                        <input type="text" class="form-control border-bradesco" id="createName" name="name" 
                               placeholder="Digite o nome completo" required>
                    </div>
                    <div class="mb-3">
                        <label for="createEmail" class="form-label">
                            <i class="fas fa-envelope me-1 text-bradesco"></i>Endereço de E-mail
                        </label>
                        <input type="email" class="form-control border-bradesco" id="createEmail" name="email" 
                               placeholder="Digite o e-mail" required>
                    </div>
                    <div class="mb-3">
                        <label for="createPassword" class="form-label">
                            <i class="fas fa-lock me-1 text-bradesco"></i>Senha
                        </label>
                        <input type="password" class="form-control border-bradesco" id="createPassword" name="password" 
                               placeholder="Digite a senha" required>
                    </div>
                    <div class="mb-3">
                        <label for="createRole" class="form-label">
                            <i class="fas fa-user-tag me-1 text-bradesco"></i>Função
                        </label>
                        <select class="form-select border-bradesco" id="createRole" name="role" required>
                            <option value="">Selecione uma função</option>
                            <option value="user">Usuário</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-bradesco">
                        <i class="fas fa-save me-2"></i>Criar Usuário
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Editar Usuário -->
<div class="modal fade" id="editUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-bradesco text-white">
                <h5 class="modal-title">
                    <i class="fas fa-user-edit me-2"></i>Editar Usuário
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <form method="POST" action="<?= isset($basePath) ? $basePath : '' ?>/dashboard/user/edit">
                <div class="modal-body">
                    <input type="hidden" id="editId" name="id">
                    <div class="mb-3">
                        <label for="editName" class="form-label">
                            <i class="fas fa-user me-1 text-bradesco"></i>Nome Completo
                        </label>
                        <input type="text" class="form-control border-bradesco" id="editName" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="editEmail" class="form-label">
                            <i class="fas fa-envelope me-1 text-bradesco"></i>Endereço de E-mail
                        </label>
                        <input type="email" class="form-control border-bradesco" id="editEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="editPassword" class="form-label">
                            <i class="fas fa-lock me-1 text-bradesco"></i>Nova Senha 
                            <small class="text-muted">(deixe em branco para manter a atual)</small>
                        </label>
                        <input type="password" class="form-control border-bradesco" id="editPassword" name="password"
                               placeholder="Digite nova senha ou deixe em branco">
                    </div>
                    <div class="mb-3">
                        <label for="editRole" class="form-label">
                            <i class="fas fa-user-tag me-1 text-bradesco"></i>Função
                        </label>
                        <select class="form-select border-bradesco" id="editRole" name="role" required>
                            <option value="user">Usuário</option>
                            <option value="admin">Administrador</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>Cancelar
                    </button>
                    <button type="submit" class="btn btn-bradesco">
                        <i class="fas fa-save me-2"></i>Atualizar Usuário
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Excluir Usuário -->
<div class="modal fade" id="deleteUserModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle me-2"></i>Confirmar Exclusão
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="fas fa-exclamation-triangle fa-4x text-danger"></i>
                </div>
                <div class="alert alert-warning border-0">
                    <h6 class="alert-heading">
                        <i class="fas fa-warning me-2"></i>Atenção!
                    </h6>
                    <p class="mb-0">
                        Tem certeza de que deseja excluir o usuário <strong><span id="deleteUserName">N/A</span></strong>?
                    </p>
                </div>
                <div class="alert alert-danger border-0">
                    <small>
                        <i class="fas fa-info-circle me-1"></i>
                        Esta ação não pode ser desfeita e todos os dados relacionados serão perdidos.
                    </small>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                    <i class="fas fa-times me-1"></i>Cancelar
                </button>
                <form method="POST" action="<?= isset($basePath) ? $basePath : '' ?>/dashboard/user/delete" style="display: inline;">
                    <input type="hidden" id="deleteUserId" name="id">
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash me-2"></i>Excluir Usuário
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function editUser(user) {
    // Ensure all elements exist before setting values
    const editIdField = document.getElementById('editId');
    const editNameField = document.getElementById('editName');
    const editEmailField = document.getElementById('editEmail');
    const editRoleField = document.getElementById('editRole');
    
    if (editIdField && editNameField && editEmailField && editRoleField) {
        editIdField.value = user.id;
        editNameField.value = user.name;
        editEmailField.value = user.email;
        editRoleField.value = user.role;
        
        const editModal = new bootstrap.Modal(document.getElementById('editUserModal'));
        editModal.show();
    } else {
        console.error('Edit user modal elements not found');
        alert('Erro ao carregar modal de edição. Recarregue a página e tente novamente.');
    }
}

function confirmDeleteUser(id, name) {
    // Ensure all elements exist before setting values
    const deleteUserIdField = document.getElementById('deleteUserId');
    const deleteUserNameField = document.getElementById('deleteUserName');
    
    if (deleteUserIdField && deleteUserNameField) {
        deleteUserIdField.value = id;
        deleteUserNameField.textContent = name;
        
        const deleteModal = new bootstrap.Modal(document.getElementById('deleteUserModal'));
        deleteModal.show();
    } else {
        console.error('Delete user modal elements not found:', {
            deleteUserIdField: !!deleteUserIdField,
            deleteUserNameField: !!deleteUserNameField
        });
        
        // Fallback confirmation
        if (confirm(`Tem certeza de que deseja excluir o usuário "${name}"?\n\nEsta ação não pode ser desfeita.`)) {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '<?= isset($basePath) ? $basePath : '' ?>/dashboard/user/delete';
            
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'id';
            input.value = id;
            
            form.appendChild(input);
            document.body.appendChild(form);
            form.submit();
        }
    }
}

// Legacy function for backwards compatibility
function deleteUser(id, name) {
    confirmDeleteUser(id, name);
}

// Initialize tooltips when document is ready
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Bootstrap tooltips
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });
    
    // Verify modal elements exist
    const requiredElements = [
        'deleteUserModal',
        'deleteUserName', 
        'deleteUserId',
        'editUserModal',
        'editId',
        'editName',
        'editEmail',
        'editRole'
    ];
    
    const missingElements = requiredElements.filter(id => !document.getElementById(id));
    
    if (missingElements.length > 0) {
        console.warn('Missing required elements:', missingElements);
    }
});
</script>