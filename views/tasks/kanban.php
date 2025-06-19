<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="page-title">
                    <i class="fas fa-tasks me-3 text-bradesco"></i>Quadro Kanban
                </h1>
                <button class="btn btn-bradesco pulse-bradesco" data-bs-toggle="modal" data-bs-target="#createTaskModal">
                    <i class="fas fa-plus me-2"></i>Adicionar Tarefa
                </button>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-4">
            <div class="kanban-column" data-status="todo">
                <h5 class="text-center mb-3">
                    <i class="fas fa-clipboard-list me-2 text-bradesco"></i>A Fazer
                    <span class="badge bg-bradesco ms-2" id="todo-count">0</span>
                </h5>
                <div class="kanban-tasks" id="todo-tasks">
                    <!-- Tarefas serão populadas pelo JavaScript -->
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="kanban-column" data-status="in_progress">
                <h5 class="text-center mb-3">
                    <i class="fas fa-spinner me-2 text-warning"></i>Em Progresso
                    <span class="badge bg-warning ms-2" id="in_progress-count">0</span>
                </h5>
                <div class="kanban-tasks" id="in_progress-tasks">
                    <!-- Tarefas serão populadas pelo JavaScript -->
                </div>
            </div>
        </div>
        
        <div class="col-lg-4">
            <div class="kanban-column" data-status="done">
                <h5 class="text-center mb-3">
                    <i class="fas fa-check-circle me-2 text-success"></i>Concluído
                    <span class="badge bg-success ms-2" id="done-count">0</span>
                </h5>
                <div class="kanban-tasks" id="done-tasks">
                    <!-- Tarefas serão populadas pelo JavaScript -->
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

<script>
// JavaScript do Quadro Kanban
document.addEventListener('DOMContentLoaded', function() {
    const tasks = <?= json_encode($tasks) ?>;
    
    // Inicializar o quadro kanban
    initializeKanban(tasks);
    
    // Configurar drag and drop
    setupDragAndDrop();
});

function initializeKanban(tasks) {
    // Limpar tarefas existentes
    document.getElementById('todo-tasks').innerHTML = '';
    document.getElementById('in_progress-tasks').innerHTML = '';
    document.getElementById('done-tasks').innerHTML = '';
    
    // Agrupar tarefas por status
    const tasksByStatus = {
        todo: [],
        in_progress: [],
        done: []
    };
    
    tasks.forEach(task => {
        tasksByStatus[task.status].push(task);
    });
    
    // Renderizar tarefas em cada coluna
    Object.keys(tasksByStatus).forEach(status => {
        const container = document.getElementById(status + '-tasks');
        const tasks = tasksByStatus[status];
        
        tasks.forEach(task => {
            container.appendChild(createTaskElement(task));
        });
        
        // Atualizar contadores
        document.getElementById(status + '-count').textContent = tasks.length;
    });
}

function createTaskElement(task) {
    const taskDiv = document.createElement('div');
    taskDiv.className = 'kanban-card';
    taskDiv.draggable = true;
    taskDiv.dataset.taskId = task.id;
    
    // Formatear data para formato brasileiro
    const taskDate = new Date(task.created_at);
    const formattedDate = taskDate.toLocaleDateString('pt-BR');
    
    taskDiv.innerHTML = `
        <div class="d-flex justify-content-between align-items-start mb-2">
            <h6 class="mb-0 text-dark fw-semibold">${escapeHtml(task.title)}</h6>
            <small class="text-muted">#${task.id}</small>
        </div>
        ${task.description ? `<p class="small text-muted mb-2">${escapeHtml(task.description)}</p>` : ''}
        <div class="d-flex justify-content-between align-items-center">
            <small class="text-muted">
                <i class="fas fa-clock me-1"></i>
                ${formattedDate}
            </small>
            <div class="btn-group btn-group-sm">
                <button class="btn btn-outline-primary btn-sm" onclick="editTask(${task.id})"
                        data-bs-toggle="tooltip" title="Editar tarefa">
                    <i class="fas fa-edit"></i>
                </button>
                <button class="btn btn-outline-danger btn-sm" onclick="deleteTask(${task.id})"
                        data-bs-toggle="tooltip" title="Excluir tarefa">
                    <i class="fas fa-trash"></i>
                </button>
            </div>
        </div>
    `;
    
    return taskDiv;
}

function setupDragAndDrop() {
    const columns = document.querySelectorAll('.kanban-tasks');
    
    columns.forEach(column => {
        new Sortable(column, {
            group: 'kanban',
            animation: 200,
            ghostClass: 'kanban-ghost',
            chosenClass: 'kanban-chosen',
            dragClass: 'kanban-drag',
            onStart: function(evt) {
                evt.item.classList.add('dragging');
                document.body.style.cursor = 'grabbing';
            },
            onEnd: function(evt) {
                evt.item.classList.remove('dragging');
                document.body.style.cursor = 'default';
                
                const taskId = evt.item.dataset.taskId;
                const newStatus = evt.to.id.replace('-tasks', '');
                const newPosition = evt.newIndex;
                
                updateTaskStatus(taskId, newStatus, newPosition);
            }
        });
    });
}

function updateTaskStatus(taskId, status, position) {
    fetch('<?= isset($basePath) ? $basePath : '' ?>/tasks/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            id: taskId,
            status: status,
            position: position
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Atualizar contadores
            updateCounts();
            
            // Mostrar mensagem de sucesso
            showNotification('Tarefa atualizada com sucesso!', 'success');
        } else {
            showNotification('Falha ao atualizar tarefa', 'error');
        }
    })
    .catch(error => {
        console.error('Erro:', error);
        showNotification('Ocorreu um erro', 'error');
    });
}

function updateCounts() {
    ['todo', 'in_progress', 'done'].forEach(status => {
        const count = document.getElementById(status + '-tasks').children.length;
        document.getElementById(status + '-count').textContent = count;
    });
}

function editTask(taskId) {
    // Implementar funcionalidade de edição
    showNotification('Funcionalidade de edição em breve!', 'info');
}

function deleteTask(taskId) {
    if (confirm('Tem certeza de que deseja excluir esta tarefa?')) {
        // Implementar funcionalidade de exclusão
        showNotification('Funcionalidade de exclusão em breve!', 'info');
    }
}

function showNotification(message, type) {
    const alertClass = type === 'success' ? 'alert-success' : 
                      type === 'error' ? 'alert-danger' : 'alert-info';
    
    const iconClass = type === 'success' ? 'fa-check-circle' : 
                     type === 'error' ? 'fa-times-circle' : 'fa-info-circle';
    
    const notification = document.createElement('div');
    notification.className = `alert ${alertClass} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 80px; right: 20px; z-index: 9999; min-width: 350px; box-shadow: 0 6px 20px rgba(204, 9, 47, 0.3);';
    notification.innerHTML = `
        <i class="fas ${iconClass} me-2"></i>
        <strong>${message}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;
    
    document.body.appendChild(notification);
    
    // Auto remover após 5 segundos
    setTimeout(() => {
        if (notification.parentNode) {
            notification.classList.remove('show');
            setTimeout(() => {
                if (notification.parentNode) {
                    notification.parentNode.removeChild(notification);
                }
            }, 150);
        }
    }, 5000);
}

function escapeHtml(text) {
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}
</script>