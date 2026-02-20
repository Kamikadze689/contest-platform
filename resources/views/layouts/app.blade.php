<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Конкурс работ') — Платформа</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz@14..32&display=swap" rel="stylesheet">
    
    <!-- Bootstrap Icons (только иконки, без лишнего) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <!-- Bootstrap (только сетка и компоненты) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <style>
        /* CSS Reset */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --primary: #2563eb;
            --primary-dark: #1d4ed8;
            --secondary: #64748b;
            --success: #059669;
            --danger: #dc2626;
            --warning: #d97706;
            --info: #0891b2;
            
            --gray-50: #f8fafc;
            --gray-100: #f1f5f9;
            --gray-200: #e2e8f0;
            --gray-300: #cbd5e1;
            --gray-400: #94a3b8;
            --gray-500: #64748b;
            --gray-600: #475569;
            --gray-700: #334155;
            --gray-800: #1e293b;
            --gray-900: #0f172a;
            
            --shadow-sm: 0 1px 2px 0 rgb(0 0 0 / 0.05);
            --shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1), 0 1px 2px -1px rgb(0 0 0 / 0.1);
            --shadow-md: 0 4px 6px -1px rgb(0 0 0 / 0.1), 0 2px 4px -2px rgb(0 0 0 / 0.1);
            --shadow-lg: 0 10px 15px -3px rgb(0 0 0 / 0.1), 0 4px 6px -4px rgb(0 0 0 / 0.1);
        }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background-color: var(--gray-50);
            color: var(--gray-900);
            line-height: 1.5;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Typography */
        h1, h2, h3, h4, h5, h6 {
            font-weight: 600;
            letter-spacing: -0.025em;
            color: var(--gray-900);
        }

        h1 { font-size: 2.25rem; }
        h2 { font-size: 1.875rem; }
        h3 { font-size: 1.5rem; }
        h4 { font-size: 1.25rem; }

        /* Navigation */
        .navbar {
            background-color: white;
            border-bottom: 1px solid var(--gray-200);
            padding: 1rem 0;
            box-shadow: var(--shadow-sm);
        }

        .navbar-brand {
            font-weight: 600;
            font-size: 1.25rem;
            color: var(--gray-900);
            text-decoration: none;
        }

        .navbar-brand:hover {
            color: var(--primary);
        }

        .nav-link {
            color: var(--gray-600);
            font-weight: 500;
            padding: 0.5rem 1rem;
            border-radius: 0.375rem;
            transition: all 0.2s;
        }

        .nav-link:hover {
            color: var(--gray-900);
            background-color: var(--gray-100);
        }

        .nav-link.active {
            color: var(--primary);
            background-color: var(--gray-100);
        }

        /* Main content */
        main {
            flex: 1;
            padding: 2rem 0;
        }

        /* Cards */
        .card {
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: 0.75rem;
            box-shadow: var(--shadow-sm);
            transition: box-shadow 0.2s;
        }

        .card:hover {
            box-shadow: var(--shadow-md);
        }

        .stat-card:hover {
            border-color: var(--primary);
            box-shadow: var(--shadow-lg);
            transform: translateY(-2px);
        }

        .stat-icon {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
        }

        .stat-content {
            flex: 1;
        }

        .stat-label {
            display: block;
            color: var(--gray-600);
            font-size: 0.875rem;
            margin-bottom: 0.25rem;
            letter-spacing: 0.02em;
        }

        .stat-value {
            display: block;
            font-size: 2rem;
            font-weight: 700;
            color: var(--gray-900);
            line-height: 1.2;
            margin-bottom: 0.25rem;
        }

        .stat-trend {
            font-size: 0.75rem;
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            padding: 0.125rem 0.5rem;
            border-radius: 999px;
            background: var(--gray-50);
        }

        .stat-trend.positive {
            color: var(--success);
            background: rgba(5, 150, 105, 0.1);
        }

        .stat-trend.warning {
            color: var(--warning);
            background: rgba(245, 158, 11, 0.1);
        }

        .stat-trend.negative {
            color: var(--danger);
            background: rgba(220, 38, 38, 0.1);
        }

        .stat-meta {
            font-size: 0.75rem;
            color: var(--gray-500);
            margin-top: 0.25rem;
        }

        .chart-card, .list-card, .actions-card {
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: 16px;
            overflow: hidden;
            box-shadow: var(--shadow-sm);
        }

        .card-header {
            background: white;
            border-bottom: 1px solid var(--gray-200);
            padding: 1.25rem 1.5rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .card-header h5 {
            margin: 0;
            font-size: 1rem;
            font-weight: 600;
            color: var(--gray-900);
        }

        .card-body {
            padding: 1.5rem;
        }

        .card-footer {
            background: var(--gray-50);
            border-top: 1px solid var(--gray-200);
            padding: 1rem 1.5rem;
            border-radius: 0 0 0.75rem 0.75rem;
        }

        .stat-item {
            margin-bottom: 1.25rem;
        }

        .stat-item:last-child {
            margin-bottom: 0;
        }

        .progress-stacked {
            display: flex;
            height: 12px;
            border-radius: 999px;
            overflow: hidden;
            background: var(--gray-100);
        }

        .legend-list {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .legend-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.875rem;
            color: var(--gray-600);
        }

        .legend-color {
            width: 12px;
            height: 12px;
            border-radius: 4px;
        }

        .list-item {
            display: flex;
            align-items: center;
            padding: 1.25rem 1.5rem;
            border-bottom: 1px solid var(--gray-200);
            transition: background 0.2s;
        }

        .list-item:hover {
            background: var(--gray-50);
        }

        .list-item:last-child {
            border-bottom: none;
        }

        .list-item-content {
            flex: 1;
        }

        .list-item-title {
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 0.5rem;
        }

        .list-item-title a {
            color: inherit;
            text-decoration: none;
        }

        .list-item-title a:hover {
            color: var(--primary);
        }

        .list-item-meta {
            display: flex;
            gap: 1.5rem;
            color: var(--gray-600);
            font-size: 0.875rem;
        }

        .list-item-meta i {
            margin-right: 0.375rem;
            color: var(--gray-400);
        }

        .list-item-action {
            margin-left: 1rem;
        }

        .stats-mini-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: 16px;
            padding: 1.5rem;
        }

        .stats-mini-item {
            text-align: center;
            padding: 0 1rem;
            border-right: 1px solid var(--gray-200);
        }

        .stats-mini-item:last-child {
            border-right: none;
        }

        .stats-mini-label {
            display: block;
            color: var(--gray-600);
            font-size: 0.75rem;
            margin-bottom: 0.5rem;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .stats-mini-number {
            display: block;
            font-size: 1.75rem;
            font-weight: 700;
            color: var(--gray-900);
            line-height: 1.2;
            margin-bottom: 0.5rem;
        }

        .stats-mini-trend {
            font-size: 0.75rem;
        }

        .stats-mini-trend.success { color: var(--success); }
        .stats-mini-trend.danger { color: var(--danger); }
        .stats-mini-trend.warning { color: var(--warning); }
        .stats-mini-trend.info { color: var(--info); }

        .stats-grid {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .stats-row {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .stats-label {
            width: 100px;
            color: var(--gray-600);
            font-size: 0.875rem;
        }

        .stats-bar {
            flex: 1;
        }

        .stats-value {
            width: 50px;
            text-align: right;
            font-weight: 600;
            color: var(--gray-900);
        }

        .success-rate {
            margin-top: 1.5rem;
            padding-top: 1.5rem;
        }

        /* Buttons */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.625rem 1.25rem;
            font-weight: 500;
            border-radius: 0.5rem;
            transition: all 0.2s;
            border: 1px solid transparent;
            cursor: pointer;
            font-size: 0.9375rem;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: white;
            border-color: var(--gray-300);
            color: var(--gray-700);
        }

        .btn-secondary:hover {
            background: var(--gray-50);
            border-color: var(--gray-400);
        }

        .btn-success {
            background: var(--success);
            color: white;
        }

        .btn-danger {
            background: var(--danger);
            color: white;
        }

        .btn-warning {
            background: var(--warning);
            color: white;
        }

        .btn-sm {
            padding: 0.375rem 0.75rem;
            font-size: 0.875rem;
        }

        .btn:disabled {
            opacity: 0.5;
            cursor: not-allowed;
        }

        /* Tables */
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            text-align: left;
            padding: 0.875rem 1rem;
            background: var(--gray-50);
            color: var(--gray-600);
            font-weight: 500;
            font-size: 0.875rem;
            border-bottom: 1px solid var(--gray-200);
        }

        .table td {
            padding: 1rem;
            border-bottom: 1px solid var(--gray-200);
            color: var(--gray-700);
        }

        .table tr:hover td {
            background: var(--gray-50);
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 0.25rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 500;
            line-height: 1.5;
        }

        .badge-draft {
            background: var(--gray-200);
            color: var(--gray-700);
        }

        .badge-submitted {
            background: #dbeafe;
            color: var(--primary-dark);
        }

        .badge-needs_fix {
            background: #fed7aa;
            color: #9a3412;
        }

        .badge-accepted {
            background: #d1fae5;
            color: #065f46;
        }

        .badge-rejected {
            background: #fee2e2;
            color: #991b1b;
        }

        /* Forms */
        .form-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--gray-700);
            font-size: 0.9375rem;
        }

        .form-control, .form-select {
            width: 100%;
            padding: 0.625rem 1rem;
            border: 1px solid var(--gray-300);
            border-radius: 0.5rem;
            font-size: 0.9375rem;
            transition: all 0.2s;
            background: white;
        }

        .form-control:focus, .form-select:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }

        .form-control.is-invalid, .form-select.is-invalid {
            border-color: var(--danger);
        }

        .invalid-feedback {
            color: var(--danger);
            font-size: 0.875rem;
            margin-top: 0.375rem;
        }

        /* Alerts */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: 0.5rem;
            margin-bottom: 1.5rem;
            border: 1px solid transparent;
        }

        .alert-success {
            background: #d1fae5;
            border-color: #a7f3d0;
            color: #065f46;
        }

        .alert-danger {
            background: #fee2e2;
            border-color: #fecaca;
            color: #991b1b;
        }

        .alert-warning {
            background: #fed7aa;
            border-color: #fdba74;
            color: #9a3412;
        }

        .alert-info {
            background: #dbeafe;
            border-color: #bfdbfe;
            color: #1e40af;
        }

        /* Pagination */
        .pagination {
            display: flex;
            gap: 0.375rem;
            list-style: none;
            justify-content: center;
        }

        .page-item .page-link {
            display: block;
            padding: 0.5rem 0.875rem;
            background: white;
            border: 1px solid var(--gray-300);
            border-radius: 0.5rem;
            color: var(--gray-700);
            text-decoration: none;
            transition: all 0.2s;
        }

        .page-item.active .page-link {
            background: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        .page-item.disabled .page-link {
            opacity: 0.5;
            pointer-events: none;
        }

        .page-item:not(.active):not(.disabled) .page-link:hover {
            background: var(--gray-50);
            border-color: var(--gray-400);
        }

        /* Stats cards */
        .stat-card {
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: 16px;
            padding: 1.5rem;
            display: flex;
            align-items: center;
            gap: 1rem;
            transition: all 0.2s;
            box-shadow: var(--shadow-sm);
        }

        .stat-card-label {
            color: var(--gray-600);
            font-size: 0.9375rem;
            margin-bottom: 0.5rem;
        }

        .stat-card-value {
            font-size: 2rem;
            font-weight: 600;
            color: var(--gray-900);
            line-height: 1;
        }

        /* Progress bar */
        .progress {
            background: var(--gray-200);
            border-radius: 9999px;
            height: 0.5rem;
            overflow: hidden;
        }

        .progress-bar {
            background: var(--primary);
            height: 100%;
            transition: width 0.3s;
        }

        /* Footer */
        .footer {
            background: white;
            border-top: 1px solid var(--gray-200);
            padding: 1.5rem 0;
            color: var(--gray-600);
            font-size: 0.875rem;
            margin-top: auto;
        }

        /* Grid */
        .container {
            max-width: 1280px;
            margin: 0 auto;
            padding: 0 1.5rem;
        }

        /* Item cards for lists */
        .item-card {
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: 0.5rem;
            padding: 1.25rem;
            margin-bottom: 0.75rem;
            transition: all 0.2s;
        }

        .item-card:hover {
            border-color: var(--gray-300);
            box-shadow: var(--shadow-sm);
        }

        .item-title {
            font-weight: 600;
            color: var(--gray-900);
            margin-bottom: 0.375rem;
        }

        .item-title a {
            color: inherit;
            text-decoration: none;
        }

        .item-title a:hover {
            color: var(--primary);
        }

        .item-meta {
            color: var(--gray-600);
            font-size: 0.875rem;
        }

        .item-meta i {
            margin-right: 0.25rem;
            color: var(--gray-400);
        }

        /* Comments */
        .comment {
            background: var(--gray-50);
            border-radius: 0.5rem;
            padding: 1rem;
            margin-bottom: 1rem;
        }

        .comment-header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
            font-size: 0.875rem;
        }

        .comment-author {
            font-weight: 600;
            color: var(--gray-900);
        }

        .comment-date {
            color: var(--gray-500);
        }

        .comment-body {
            color: var(--gray-700);
            font-size: 0.9375rem;
        }

        /* Files */
        .file-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.75rem;
            background: var(--gray-50);
            border: 1px solid var(--gray-200);
            border-radius: 0.5rem;
            margin-bottom: 0.5rem;
        }

        .file-info {
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .file-info i {
            color: var(--gray-400);
        }

        .file-name {
            font-weight: 500;
            color: var(--gray-900);
        }

        .file-meta {
            font-size: 0.875rem;
            color: var(--gray-500);
        }

        /* Utilities */
        .text-muted {
            color: var(--gray-600);
        }

        .text-success {
            color: var(--success);
        }

        .text-danger {
            color: var(--danger);
        }

        .text-warning {
            color: var(--warning);
        }

        .text-primary {
            color: var(--primary);
        }

        .bg-white {
            background: white;
        }

        .border {
            border: 1px solid var(--gray-200);
        }

        .shadow {
            box-shadow: var(--shadow);
        }

        .shadow-md {
            box-shadow: var(--shadow-md);
        }

        .rounded {
            border-radius: 0.5rem;
        }

        .rounded-lg {
            border-radius: 0.75rem;
        }

        /* Dropdown */
        .dropdown-menu {
            background: white;
            border: 1px solid var(--gray-200);
            border-radius: 0.5rem;
            box-shadow: var(--shadow-lg);
            padding: 0.375rem 0;
        }

        .dropdown-item {
            display: block;
            padding: 0.5rem 1rem;
            color: var(--gray-700);
            text-decoration: none;
            transition: all 0.2s;
        }

        .dropdown-item:hover {
            background: var(--gray-50);
            color: var(--gray-900);
        }

                /* Анимации */
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideIn {
            from {
                transform: translateX(-10px);
                opacity: 0;
            }
            to {
                transform: translateX(0);
                opacity: 1;
            }
        }

        @keyframes scaleIn {
            from {
                transform: scale(0.95);
                opacity: 0;
            }
            to {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes pulse {
            0%, 100% {
                transform: scale(1);
            }
            50% {
                transform: scale(1.02);
            }
        }

        /* Применяем анимации */
        .animate-fade-in {
            animation: fadeIn 0.4s ease-out forwards;
        }

        .animate-slide-in {
            animation: slideIn 0.3s ease-out forwards;
        }

        .animate-scale-in {
            animation: scaleIn 0.3s ease-out forwards;
        }

        .card {
            animation: fadeIn 0.4s ease-out;
            animation-fill-mode: both;
        }

        .card:nth-child(1) { animation-delay: 0.05s; }
        .card:nth-child(2) { animation-delay: 0.1s; }
        .card:nth-child(3) { animation-delay: 0.15s; }
        .card:nth-child(4) { animation-delay: 0.2s; }
        .card:nth-child(5) { animation-delay: 0.25s; }
        .card:nth-child(6) { animation-delay: 0.3s; }

        .stat-card {
            transition: all 0.2s ease;
        }

        .stat-card:hover {
            border-color: var(--primary);
            box-shadow: var(--shadow-lg);
            transform: translateY(-2px);
        }

        .btn {
            transition: all 0.2s ease;
        }

        .btn:hover {
            transform: translateY(-1px);
        }

        .btn:active {
            transform: translateY(0);
        }

        .item-card {
            transition: all 0.2s ease;
            animation: slideIn 0.3s ease-out;
            animation-fill-mode: both;
        }

        .item-card:hover {
            transform: translateX(4px);
            border-color: var(--primary);
        }

        .badge {
            transition: all 0.2s ease;
        }

        /* Анимация для загрузки */
        .skeleton {
            background: linear-gradient(
                90deg,
                var(--gray-200) 25%,
                var(--gray-100) 37%,
                var(--gray-200) 63%
            );
            background-size: 400% 100%;
            animation: skeleton-loading 1.4s ease infinite;
        }

        @keyframes skeleton-loading {
            0% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0 50%;
            }
        }

        /* Анимация для уведомлений */
        .alert {
            animation: slideIn 0.3s ease-out;
        }

        .alert.fade-out {
            animation: fadeOut 0.3s ease-out forwards;
        }

        @keyframes fadeOut {
            from {
                opacity: 1;
                transform: translateY(0);
            }
            to {
                opacity: 0;
                transform: translateY(-10px);
            }
        }

        /* Плавные переходы для всех интерактивных элементов */
        a, button, .nav-link, .dropdown-item, .page-link {
            transition: all 0.2s ease;
        }

        /* Анимация появления для модальных окон */
        .modal.fade .modal-dialog {
            transition: transform 0.3s ease-out;
            transform: scale(0.95);
        }

        .modal.show .modal-dialog {
            transform: scale(1);
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <a class="navbar-brand" href="{{ url('/') }}">
                Конкурс работ
            </a>
            
            <div class="d-flex align-items-center gap-3">
                @auth
                    @if(auth()->user()->isAdmin())
                        <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" 
                           href="{{ route('admin.dashboard') }}">Главная</a>
                        <a class="nav-link {{ request()->routeIs('admin.contests*') ? 'active' : '' }}" 
                           href="{{ route('admin.contests.index') }}">Конкурсы</a>
                        <a class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}" 
                           href="{{ route('admin.users.index') }}">Пользователи</a>
                    @elseif(auth()->user()->isJury())
                        <a class="nav-link {{ request()->routeIs('jury.dashboard') ? 'active' : '' }}" 
                           href="{{ route('jury.dashboard') }}">Главная</a>
                        <a class="nav-link {{ request()->routeIs('jury.submissions*') ? 'active' : '' }}" 
                           href="{{ route('jury.submissions.index') }}">На проверку</a>
                    @else
                        <a class="nav-link {{ request()->routeIs('participant.dashboard') ? 'active' : '' }}" 
                           href="{{ route('participant.dashboard') }}">Главная</a>
                        <a class="nav-link {{ request()->routeIs('participant.submissions*') ? 'active' : '' }}" 
                           href="{{ route('participant.submissions.index') }}">Мои работы</a>
                    @endif

                    <div class="dropdown">
                        <button class="btn btn-secondary btn-sm dropdown-toggle" type="button" 
                                data-bs-toggle="dropdown" style="gap: 0.25rem;">
                            {{ auth()->user()->name }}
                        </button>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="dropdown-item" style="border: none; background: none; width: 100%; text-align: left;">
                                        Выйти
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                @else
                    <a class="nav-link" href="{{ route('login') }}">Вход</a>
                    <a class="btn btn-primary btn-sm" href="{{ route('register') }}">Регистрация</a>
                @endauth
            </div>
        </div>
    </nav>

    <main>
        <div class="container">
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')
        </div>
    </main>

    <footer class="footer">
        <div class="container text-center">
            <p>© {{ date('Y') }} Платформа для проведения конкурсов. Все права защищены.</p>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>