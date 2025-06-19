<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aplicação PHP MVC</title>
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }
        
        .navbar-brand {
            font-weight: bold;
            color: white !important;
            display: flex;
            align-items: center;
        }
        
        .bradesco-logo-navbar {
            max-height: 32px;
            width: auto;
            margin-right: 10px;
            transition: transform 0.3s ease;
            filter: brightness(0) invert(1); /* Makes logo white */
        }
        
        .bradesco-logo-navbar:hover {
            transform: scale(1.05);
        }
        
        .sidebar {
            height: 100vh;
            background: var(--bradesco-gradient);
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            padding-top: 70px;
            z-index: 1000;
            overflow-y: auto;
            box-shadow: 4px 0 15px var(--bradesco-shadow);
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.9);
            padding: 15px 20px;
            border-radius: 0;
            transition: all 0.3s ease;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            margin: 2px 0;
        }
        
        .sidebar .nav-link:hover {
            background-color: rgba(255, 255, 255, 0.15);
            color: white;
            transform: translateX(5px);
            border-left: 4px solid white;
        }
        
        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.2);
            color: white;
            border-left: 4px solid white;
            font-weight: 600;
        }
        
        .main-content {
            margin-left: 250px;
            margin-top: 60px;
            padding: 30px;
            min-height: calc(100vh - 60px);
            background-color: #f8f9fa;
        }
        
        .page-title {
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 3px solid var(--bradesco-red);
            color: #2c3e50;
            display: flex;
            align-items: center;
        }
        
        .page-title .bradesco-logo-title {
            max-height: 40px;
            width: auto;
            margin-right: 15px;
            transition: transform 0.3s ease;
            filter: drop-shadow(0 2px 4px rgba(204, 9, 47, 0.3));
        }
        
        .page-title:hover .bradesco-logo-title {
            transform: scale(1.05);
        }
        
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            margin-bottom: 20px;
        }
        
        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(204, 9, 47, 0.15);
        }
        
        .card-header {
            background: var(--bradesco-gradient);
            color: white;
            border-radius: 15px 15px 0 0 !important;
            border: none;
            font-weight: 600;
        }
        
        .kanban-column {
            background-color: #f8f9fa;
            border-radius: 15px;
            padding: 20px;
            margin: 10px;
            min-height: 400px;
            border: 2px solid #e9ecef;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }
        
        .kanban-card {
            background: white;
            border-radius: 12px;
            padding: 15px;
            margin-bottom: 15px;
            cursor: move;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            border-left: 4px solid var(--bradesco-red);
        }
        
        .kanban-card:hover {
            box-shadow: 0 6px 20px rgba(204, 9, 47, 0.2);
            transform: translateY(-2px);
        }
        
        .kanban-card.dragging {
            opacity: 0.7;
            transform: rotate(3deg);
            box-shadow: 0 8px 25px var(--bradesco-shadow);
        }
        
        .kanban-column.drag-over {
            background-color: #fff5f5;
            border: 2px dashed var(--bradesco-red);
            transform: scale(1.02);
        }
        
        .btn-bradesco {
            background: var(--bradesco-gradient);
            border: none;
            color: white;
            transition: all 0.3s ease;
            font-weight: 600;
            box-shadow: 0 3px 10px var(--bradesco-shadow);
        }
        
        .btn-bradesco:hover {
            background: linear-gradient(135deg, #A91E1E 0%, #CC092F 50%, #A91E1E 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px var(--bradesco-shadow);
        }
        
        .btn-outline-bradesco {
            border: 2px solid var(--bradesco-red);
            color: var(--bradesco-red);
            background: transparent;
            font-weight: 600;
            transition: all 0.3s ease;
        }
        
        .btn-outline-bradesco:hover {
            background: var(--bradesco-gradient);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 6px 20px var(--bradesco-shadow);
        }
        
        .login-container {
            min-height: 100vh;
            background: var(--bradesco-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        .login-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 1000"><polygon fill="rgba(255,255,255,0.05)" points="0,1000 1000,800 1000,1000"/></svg>');
            background-size: cover;
        }
        
        .login-card {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 40px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
        }
        
        .stats-card {
            text-align: center;
            padding: 25px;
            border-radius: 15px;
            background: white;
            margin-bottom: 15px;
            border: 2px solid #f8f9fa;
            transition: all 0.3s ease;
        }
        
        .stats-card:hover {
            border-color: var(--bradesco-red);
            transform: translateY(-3px);
            box-shadow: 0 8px 25px var(--bradesco-shadow);
        }
        
        .stats-number {
            font-size: 2.5rem;
            font-weight: bold;
            margin: 10px 0;
        }
        
        .stats-icon {
            font-size: 3rem;
            margin-bottom: 10px;
        }
        
        .navbar-dark {
            background: var(--bradesco-gradient) !important;
            box-shadow: 0 2px 10px var(--bradesco-shadow);
        }
        
        .text-bradesco {
            color: var(--bradesco-red) !important;
        }
        
        .bg-bradesco {
            background: var(--bradesco-gradient) !important;
        }
        
        .border-bradesco {
            border-color: var(--bradesco-red) !important;
        }
        
        .badge.bg-primary {
            background: var(--bradesco-gradient) !important;
        }
        
        .alert-info {
            background-color: #fff5f5;
            border-color: var(--bradesco-red);
            color: var(--bradesco-red-dark);
        }
        
        .alert-success {
            background-color: #f0f9ff;
            border-color: #0ea5e9;
            color: #0c4a6e;
        }
        
        .table-dark {
            background: var(--bradesco-gradient) !important;
        }
        
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
                padding: 20px 15px;
            }
            
            .page-title {
                font-size: 1.5rem;
                flex-direction: column;
                text-align: center;
            }
            
            .page-title .bradesco-logo-title {
                margin-right: 0;
                margin-bottom: 10px;
            }
            
            .bradesco-logo-navbar {
                max-height: 28px;
            }
        }
        
        /* Animações personalizadas */
        @keyframes pulse-bradesco {
            0% { box-shadow: 0 0 0 0 var(--bradesco-shadow); }
            70% { box-shadow: 0 0 0 10px rgba(204, 9, 47, 0); }
            100% { box-shadow: 0 0 0 0 rgba(204, 9, 47, 0); }
        }
        
        .pulse-bradesco {
            animation: pulse-bradesco 2s infinite;
        }
        
        /* Customização do scrollbar */
        .sidebar::-webkit-scrollbar {
            width: 6px;
        }
        
        .sidebar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.1);
        }
        
        .sidebar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.3);
            border-radius: 3px;
        }
        
        .sidebar::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 255, 255, 0.5);
        }
    </style>
</head>
<body>
    <?php if (Session::isLoggedIn()): ?>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid">
            <button class="btn btn-outline-light d-md-none me-2" type="button" id="sidebarToggle">
                <i class="fas fa-bars"></i>
            </button>
            <a class="navbar-brand" href="<?= isset($basePath) ? $basePath : '' ?>/dashboard">
                <!-- Bradesco Logo Image -->
                <img src="https://upload.wikimedia.org/wikipedia/commons/a/a6/Banco_Bradesco_logo_%28horizontal%29.png" 
                     alt="Bradesco" 
                     class="bradesco-logo-navbar">
                Sistema MVC
            </a>
            <div class="navbar-nav ms-auto">
                <span class="navbar-text me-3">
                    <i class="fas fa-user me-1"></i>Bem-vindo(a), <?= Session::get('user_name') ?>
                </span>
                <a href="<?= isset($basePath) ? $basePath : '' ?>/auth/logout" class="btn btn-outline-light btn-sm">
                    <i class="fas fa-sign-out-alt me-1"></i>Sair
                </a>
            </div>
        </div>
    </nav>
    
    <div class="sidebar" id="sidebar">
        <nav class="nav flex-column">
            <a class="nav-link" href="<?= isset($basePath) ? $basePath : '' ?>/dashboard">
                <i class="fas fa-tachometer-alt me-2"></i>Painel de Controle
            </a>
            <?php if (Session::get('user_role') === 'admin'): ?>
            <a class="nav-link" href="<?= isset($basePath) ? $basePath : '' ?>/dashboard/users">
                <i class="fas fa-users me-2"></i>Gerenciar Usuários
            </a>
            <?php endif; ?>
            <a class="nav-link" href="<?= isset($basePath) ? $basePath : '' ?>/tasks/kanban">
                <i class="fas fa-tasks me-2"></i>Quadro Kanban
            </a>
        </nav>
    </div>
    
    <div class="main-content">
    <?php endif; ?>