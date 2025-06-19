<?php
// setup.php - Execute uma vez para criar dados de exemplo
require_once 'core/JsonDatabase.php';

// Cabeçalho HTML
echo '<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurar Sistema - Cores Bradesco</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --bradesco-red: #CC092F;
            --bradesco-red-dark: #A91E1E;
            --bradesco-red-light: #E31E3F;
            --bradesco-gradient: linear-gradient(135deg, #CC092F 0%, #E31E3F 50%, #CC092F 100%);
            --bradesco-shadow: rgba(204, 9, 47, 0.3);
        }
        
        body {
            background: var(--bradesco-gradient);
            min-height: 100vh;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
        }
        
        body::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url("data:image/svg+xml,<svg xmlns=\'http://www.w3.org/2000/svg\' viewBox=\'0 0 1000 1000\'><polygon fill=\'rgba(255,255,255,0.05)\' points=\'0,1000 1000,800 1000,1000\'/></svg>");
            background-size: cover;
        }
        
        .setup-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(15px);
            border-radius: 25px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
        }
        
        .progress-step {
            transition: all 0.4s ease;
            position: relative;
            z-index: 1;
        }
        
        .progress-step.active {
            transform: scale(1.02);
        }
        
        .btn-bradesco {
            background: var(--bradesco-gradient);
            border: none;
            color: white;
            transition: all 0.3s ease;
            font-weight: 600;
            box-shadow: 0 4px 15px var(--bradesco-shadow);
        }
        
        .btn-bradesco:hover {
            background: linear-gradient(135deg, #A91E1E 0%, #CC092F 50%, #A91E1E 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 8px 25px var(--bradesco-shadow);
        }
        
        .step-icon {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            margin: 0 auto 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }
        
        .animate-check {
            animation: checkScale 0.6s ease-in-out;
        }
        
        @keyframes checkScale {
            0% { transform: scale(0) rotate(0deg); }
            50% { transform: scale(1.3) rotate(180deg); }
            100% { transform: scale(1) rotate(360deg); }
        }
        
        .alert-bradesco {
            background: linear-gradient(135deg, rgba(204, 9, 47, 0.1) 0%, rgba(227, 30, 63, 0.1) 100%);
            border: 2px solid var(--bradesco-red);
            color: var(--bradesco-red-dark);
        }
        
        .text-bradesco {
            color: var(--bradesco-red) !important;
        }
        
        .bg-bradesco {
            background: var(--bradesco-gradient) !important;
        }
        
        .pulse-bradesco {
            animation: pulse-bradesco 2s infinite;
        }
        
        @keyframes pulse-bradesco {
            0% { box-shadow: 0 0 0 0 var(--bradesco-shadow); }
            70% { box-shadow: 0 0 0 15px rgba(204, 9, 47, 0); }
            100% { box-shadow: 0 0 0 0 rgba(204, 9, 47, 0); }
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
        
        .stat-card {
            background: white;
            border-radius: 15px;
            padding: 20px;
            text-align: center;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            border: 2px solid transparent;
            transition: all 0.3s ease;
        }
        
        .stat-card:hover {
            border-color: var(--bradesco-red);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px var(--bradesco-shadow);
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-10 col-lg-9">
                <div class="setup-card p-5">
                    <div class="text-center mb-5">
                        <i class="fas fa-shield-alt fa-5x text-bradesco mb-4"></i>
                        <h1 class="fw-bold text-dark mb-3">Sistema de Gerenciamento</h1>
                        <p class="text-muted fs-5">Inicializando banco de dados e criando estrutura do sistema</p>
                    </div>';

try {
    $db = new JsonDatabase();
    
    // Etapa 1: Criando diretório
    echo '<div class="progress-step active mb-4">
            <div class="step-icon bg-bradesco text-white">
                <i class="fas fa-database"></i>
            </div>
            <div class="alert alert-bradesco mb-0">
                <i class="fas fa-info-circle me-2"></i>
                <strong>Etapa 1:</strong> Configurando estrutura de dados...
            </div>
        </div>';
    
    // Dados de usuários de exemplo
    $users = [
        [
            'id' => 1,
            'name' => 'Administrador do Sistema',
            'email' => 'admin@example.com',
            'password' => password_hash('password', PASSWORD_DEFAULT),
            'role' => 'admin',
            'created_at' => date('Y-m-d H:i:s')
        ],
        [
            'id' => 2,
            'name' => 'João Silva Santos',
            'email' => 'joao@example.com',
            'password' => password_hash('password123', PASSWORD_DEFAULT),
            'role' => 'user',
            'created_at' => date('Y-m-d H:i:s')
        ],
        [
            'id' => 3,
            'name' => 'Maria Oliveira Costa',
            'email' => 'maria@example.com',
            'password' => password_hash('password123', PASSWORD_DEFAULT),
            'role' => 'user',
            'created_at' => date('Y-m-d H:i:s')
        ],
        [
            'id' => 4,
            'name' => 'Pedro Henrique Lima',
            'email' => 'pedro@example.com',
            'password' => password_hash('password123', PASSWORD_DEFAULT),
            'role' => 'user',
            'created_at' => date('Y-m-d H:i:s')
        ],
        [
            'id' => 5,
            'name' => 'Ana Carolina Ferreira',
            'email' => 'ana@example.com',
            'password' => password_hash('password123', PASSWORD_DEFAULT),
            'role' => 'user',
            'created_at' => date('Y-m-d H:i:s')
        ]
    ];
    
    // Dados de tarefas de exemplo
    $tasks = [
        [
            'id' => 1,
            'title' => 'Configurar Ambiente de Desenvolvimento',
            'description' => 'Instalar PHP, configurar servidor web e estrutura do projeto',
            'status' => 'done',
            'position' => 0,
            'user_id' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ],
        [
            'id' => 2,
            'title' => 'Implementar Sistema de Autenticação',
            'description' => 'Criar sistema de login seguro com gerenciamento de sessão',
            'status' => 'done',
            'position' => 1,
            'user_id' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ],
        [
            'id' => 3,
            'title' => 'Desenvolver Interface do Painel',
            'description' => 'Projetar painel responsivo com componentes Bootstrap e cores Bradesco',
            'status' => 'done',
            'position' => 2,
            'user_id' => 2,
            'created_at' => date('Y-m-d H:i:s')
        ],
        [
            'id' => 4,
            'title' => 'Criar Funcionalidade Drag & Drop',
            'description' => 'Implementar quadro Kanban interativo com SortableJS',
            'status' => 'in_progress',
            'position' => 0,
            'user_id' => 2,
            'created_at' => date('Y-m-d H:i:s')
        ],
        [
            'id' => 5,
            'title' => 'Desenvolver Gerenciamento de Usuários',
            'description' => 'Operações CRUD completas para administração de usuários',
            'status' => 'in_progress',
            'position' => 1,
            'user_id' => 3,
            'created_at' => date('Y-m-d H:i:s')
        ],
        [
            'id' => 6,
            'title' => 'Implementar Segurança Avançada',
            'description' => 'Adicionar proteção CSRF e validação abrangente de entrada',
            'status' => 'todo',
            'position' => 0,
            'user_id' => 3,
            'created_at' => date('Y-m-d H:i:s')
        ],
        [
            'id' => 7,
            'title' => 'Otimizar Performance do Sistema',
            'description' => 'Melhorar velocidade e responsividade da aplicação',
            'status' => 'todo',
            'position' => 1,
            'user_id' => 4,
            'created_at' => date('Y-m-d H:i:s')
        ],
        [
            'id' => 8,
            'title' => 'Documentar API e Funcionalidades',
            'description' => 'Criar documentação completa do sistema',
            'status' => 'todo',
            'position' => 2,
            'user_id' => 4,
            'created_at' => date('Y-m-d H:i:s')
        ],
        [
            'id' => 9,
            'title' => 'Implementar Relatórios',
            'description' => 'Adicionar sistema de relatórios e analytics',
            'status' => 'todo',
            'position' => 3,
            'user_id' => 5,
            'created_at' => date('Y-m-d H:i:s')
        ],
        [
            'id' => 10,
            'title' => 'Configurar Backup Automático',
            'description' => 'Sistema de backup automático dos dados JSON',
            'status' => 'todo',
            'position' => 4,
            'user_id' => 1,
            'created_at' => date('Y-m-d H:i:s')
        ]
    ];
    
    // Etapa 2: Criando usuários
    echo '<div class="progress-step active mb-4">
            <div class="step-icon bg-success text-white">
                <i class="fas fa-users"></i>
            </div>
            <div class="alert alert-success mb-0">
                <i class="fas fa-user-plus me-2"></i>
                <strong>Etapa 2:</strong> Criando usuários do sistema...
            </div>
        </div>';
    
    // Escrever dados de usuários
    if ($db->write('users', $users)) {
        echo '<div class="mb-4">
                <div class="alert alert-success animate-check">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Sucesso!</strong> Criados ' . count($users) . ' usuários com diferentes funções
                </div>
                <div class="stats-grid">
                    <div class="stat-card">
                        <i class="fas fa-crown fa-3x text-bradesco mb-3"></i>
                        <h4 class="text-bradesco mb-1">1</h4>
                        <small class="text-muted">Administrador</small>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-users fa-3x text-primary mb-3"></i>
                        <h4 class="text-primary mb-1">4</h4>
                        <small class="text-muted">Usuários</small>
                    </div>
                </div>
            </div>';
    } else {
        echo '<div class="alert alert-danger">
                <i class="fas fa-times-circle me-2"></i>
                <strong>Erro!</strong> Falha ao criar usuários
            </div>';
    }
    
    // Etapa 3: Criando tarefas
    echo '<div class="progress-step active mb-4">
            <div class="step-icon bg-warning text-white">
                <i class="fas fa-tasks"></i>
            </div>
            <div class="alert alert-warning mb-0">
                <i class="fas fa-clipboard-list me-2"></i>
                <strong>Etapa 3:</strong> Populando quadro Kanban...
            </div>
        </div>';
    
    // Escrever dados de tarefas
    if ($db->write('tasks', $tasks)) {
        $taskStats = [
            'done' => count(array_filter($tasks, fn($t) => $t['status'] === 'done')),
            'in_progress' => count(array_filter($tasks, fn($t) => $t['status'] === 'in_progress')),
            'todo' => count(array_filter($tasks, fn($t) => $t['status'] === 'todo'))
        ];
        
        echo '<div class="mb-4">
                <div class="alert alert-success animate-check">
                    <i class="fas fa-check-circle me-2"></i>
                    <strong>Sucesso!</strong> Criadas ' . count($tasks) . ' tarefas distribuídas no quadro Kanban
                </div>
                <div class="stats-grid">
                    <div class="stat-card">
                        <i class="fas fa-clipboard-list fa-3x text-bradesco mb-3"></i>
                        <h4 class="text-bradesco mb-1">' . $taskStats['todo'] . '</h4>
                        <small class="text-muted">A Fazer</small>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-spinner fa-3x text-warning mb-3"></i>
                        <h4 class="text-warning mb-1">' . $taskStats['in_progress'] . '</h4>
                        <small class="text-muted">Em Progresso</small>
                    </div>
                    <div class="stat-card">
                        <i class="fas fa-check-circle fa-3x text-success mb-3"></i>
                        <h4 class="text-success mb-1">' . $taskStats['done'] . '</h4>
                        <small class="text-muted">Concluído</small>
                    </div>
                </div>
            </div>';
    } else {
        echo '<div class="alert alert-danger">
                <i class="fas fa-times-circle me-2"></i>
                <strong>Erro!</strong> Falha ao criar tarefas
            </div>';
    }
    
    // Etapa Final: Sucesso
    echo '<div class="card border-0 shadow-lg bg-bradesco text-black">
            <div class="card-body p-5 text-center">
                <div class="step-icon bg-white text-bradesco mx-auto animate-check mb-4">
                    <i class="fas fa-check"></i>
                </div>
                <h2 class="fw-bold mb-4">🎉 Sistema Configurado com Sucesso!</h2>
                <p class="mb-4 fs-5">O sistema foi inicializado com o esquema de cores Bradesco e está pronto para uso.</p>
                
                <div class="row text-center mb-4">
                    <div class="col-md-6 mb-3">
                        <div class="bg-white bg-opacity-20 rounded-4 p-4">
                            <h5 class="fw-bold mb-3">
                                <i class="fas fa-key me-2"></i>Credenciais de Administrador
                            </h5>
                            <div class="bg-white bg-opacity-30 rounded p-3 font-monospace">
                                <div class="mb-2">
                                    <strong>E-mail:</strong><br>
                                    <code class="text-black">admin@example.com</code>
                                </div>
                                <div>
                                    <strong>Senha:</strong><br>
                                    <code class="text-black">password</code>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="bg-white bg-opacity-20 rounded-4 p-4">
                            <h5 class="fw-bold mb-3">
                                <i class="fas fa-users me-2"></i>Usuários de Teste
                            </h5>
                            <div class="bg-white bg-opacity-30 rounded p-3">
                                <small class="d-block">joao@example.com</small>
                                <small class="d-block">maria@example.com</small>
                                <small class="d-block">pedro@example.com</small>
                                <small class="d-block">ana@example.com</small>
                                <hr class="my-2">
                                <small><strong>Senha para todos:</strong> password123</small>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="alert alert-light text-dark mb-4">
                    <h6 class="alert-heading">
                        <i class="fas fa-star me-2 text-bradesco"></i>Funcionalidades Disponíveis
                    </h6>
                    <div class="row text-start">
                        <div class="col-md-6">
                            <ul class="list-unstyled mb-0">
                                <li><i class="fas fa-check text-success me-2"></i>Sistema de login seguro</li>
                                <li><i class="fas fa-check text-success me-2"></i>Painel administrativo completo</li>
                                <li><i class="fas fa-check text-success me-2"></i>Gerenciamento de usuários (CRUD)</li>
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-unstyled mb-0">
                                <li><i class="fas fa-check text-success me-2"></i>Quadro Kanban interativo</li>
                                <li><i class="fas fa-check text-success me-2"></i>Interface responsiva</li>
                                <li><i class="fas fa-check text-success me-2"></i>Esquema de cores Bradesco</li>
                            </ul>
                        </div>
                    </div>
                </div>
                
                <a href="\" class="btn btn-light btn-lg px-5 py-3 pulse-bradesco">
                    <i class="fas fa-rocket me-2 text-bradesco"></i>
                    <strong class="text-bradesco">Acessar o Sistema</strong>
                </a>
            </div>
        </div>';
    
} catch (Exception $e) {
    echo '<div class="alert alert-danger">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle fa-3x me-4 text-danger"></i>
                <div>
                    <h5 class="mb-2 text-danger">Erro durante a configuração</h5>
                    <p class="mb-2">' . htmlspecialchars($e->getMessage()) . '</p>
                    <button onclick="window.location.reload()" class="btn btn-outline-danger">
                        <i class="fas fa-redo me-2"></i>Tentar Novamente
                    </button>
                </div>
            </div>
        </div>';
}

echo '                </div>
            </div>
        </div>
    </div>
    
    <script>
        // Animações suaves e efeitos
        document.addEventListener("DOMContentLoaded", function() {
            // Animar steps sequencialmente
            const steps = document.querySelectorAll(".progress-step");
            steps.forEach((step, index) => {
                setTimeout(() => {
                    step.classList.add("active");
                    step.style.opacity = "1";
                    step.style.transform = "translateY(0)";
                }, index * 600);
            });
            
            // Efeito de digitação no título
            const title = document.querySelector("h1");
            if (title) {
                title.style.opacity = "0";
                setTimeout(() => {
                    title.style.opacity = "1";
                    title.style.animation = "fadeInUp 0.8s ease-out";
                }, 300);
            }
            
            // Hover effects nos cards
            const statCards = document.querySelectorAll(".stat-card");
            statCards.forEach(card => {
                card.addEventListener("mouseenter", function() {
                    this.style.transform = "translateY(-8px) scale(1.02)";
                });
                card.addEventListener("mouseleave", function() {
                    this.style.transform = "translateY(0) scale(1)";
                });
            });
        });
        
        // CSS animations
        const style = document.createElement("style");
        style.textContent = `
            @keyframes fadeInUp {
                from {
                    opacity: 0;
                    transform: translateY(30px);
                }
                to {
                    opacity: 1;
                    transform: translateY(0);
                }
            }
            
            .progress-step {
                opacity: 0;
                transform: translateY(20px);
                transition: all 0.6s ease;
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>';
?>