@extends('layouts.app')

@section('title', 'Панель управления')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1 class="h2 mb-4">Панель управления</h1>
    </div>
</div>

<!-- Статистика пользователей -->
<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(37, 99, 235, 0.1); color: #2563eb;">
                <i class="bi bi-people"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label">Всего пользователей</span>
                <span class="stat-value">{{ $stats['users']['total'] }}</span>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(220, 38, 38, 0.1); color: #dc2626;">
                <i class="bi bi-shield-lock"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label">Администраторы</span>
                <span class="stat-value">{{ $stats['users']['admin'] }}</span>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                <i class="bi bi-gavel"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label">Члены жюри</span>
                <span class="stat-value">{{ $stats['users']['jury'] }}</span>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(5, 150, 105, 0.1); color: #059669;">
                <i class="bi bi-person-workspace"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label">Участники</span>
                <span class="stat-value">{{ $stats['users']['participant'] }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Статистика конкурсов и работ -->
<div class="row g-4 mb-5">
    <div class="col-md-5">
        <div class="chart-card">
            <div class="card-header">
                <h5 class="mb-0">Конкурсы</h5>
                <span class="badge bg-secondary">всего {{ $stats['contests']['total'] }}</span>
            </div>
            <div class="card-body">
                <div class="stat-item mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Активные конкурсы</span>
                        <span class="fw-semibold">{{ $stats['contests']['active'] }}</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        @php $activePercent = $stats['contests']['total'] > 0 ? ($stats['contests']['active'] / $stats['contests']['total']) * 100 : 0; @endphp
                        <div class="progress-bar bg-success" style="width: {{ $activePercent }}%"></div>
                    </div>
                </div>
                
                <div class="stat-item mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Завершенные конкурсы</span>
                        <span class="fw-semibold">{{ $stats['contests']['ended'] }}</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        @php $endedPercent = $stats['contests']['total'] > 0 ? ($stats['contests']['ended'] / $stats['contests']['total']) * 100 : 0; @endphp
                        <div class="progress-bar bg-secondary" style="width: {{ $endedPercent }}%"></div>
                    </div>
                </div>
                
                <div class="mt-4 pt-3 border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Новых за сегодня</span>
                        <span class="fw-semibold">{{ $stats['contests']['new_today'] }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-7">
        <div class="chart-card">
            <div class="card-header">
                <h5 class="mb-0">Работы участников</h5>
                <span class="badge bg-secondary">всего {{ $stats['submissions']['total'] }}</span>
            </div>
            <div class="card-body">
                <div class="row g-4 mb-4">
                    <div class="col-4">
                        <div class="stats-mini">
                            <span class="stats-mini-label">На проверке</span>
                            <span class="stats-mini-value">{{ $stats['submissions']['submitted'] }}</span>
                            <div class="stats-mini-trend warning">
                                {{ $stats['submissions']['total'] > 0 ? round(($stats['submissions']['submitted'] / $stats['submissions']['total']) * 100) : 0 }}%
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stats-mini">
                            <span class="stats-mini-label">Принято</span>
                            <span class="stats-mini-value">{{ $stats['submissions']['accepted'] }}</span>
                            <div class="stats-mini-trend success">
                                {{ $stats['submissions']['total'] > 0 ? round(($stats['submissions']['accepted'] / $stats['submissions']['total']) * 100) : 0 }}%
                            </div>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="stats-mini">
                            <span class="stats-mini-label">Отклонено</span>
                            <span class="stats-mini-value">{{ $stats['submissions']['rejected'] }}</span>
                            <div class="stats-mini-trend danger">
                                {{ $stats['submissions']['total'] > 0 ? round(($stats['submissions']['rejected'] / $stats['submissions']['total']) * 100) : 0 }}%
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="progress-stacked">
                    @php
                        $submittedPercent = $stats['submissions']['total'] > 0 ? ($stats['submissions']['submitted'] / $stats['submissions']['total']) * 100 : 0;
                        $acceptedPercent = $stats['submissions']['total'] > 0 ? ($stats['submissions']['accepted'] / $stats['submissions']['total']) * 100 : 0;
                        $rejectedPercent = $stats['submissions']['total'] > 0 ? ($stats['submissions']['rejected'] / $stats['submissions']['total']) * 100 : 0;
                        $needsFixPercent = $stats['submissions']['total'] > 0 ? ($stats['submissions']['needs_fix'] / $stats['submissions']['total']) * 100 : 0;
                        $draftPercent = $stats['submissions']['total'] > 0 ? ($stats['submissions']['draft'] / $stats['submissions']['total']) * 100 : 0;
                    @endphp
                    <div class="progress-bar bg-warning" style="width: {{ $submittedPercent }}%" title="На проверке: {{ $stats['submissions']['submitted'] }}"></div>
                    <div class="progress-bar bg-success" style="width: {{ $acceptedPercent }}%" title="Принято: {{ $stats['submissions']['accepted'] }}"></div>
                    <div class="progress-bar bg-danger" style="width: {{ $rejectedPercent }}%" title="Отклонено: {{ $stats['submissions']['rejected'] }}"></div>
                    <div class="progress-bar" style="background: #f59e0b; width: {{ $needsFixPercent }}%" title="На доработке: {{ $stats['submissions']['needs_fix'] }}"></div>
                    <div class="progress-bar bg-secondary" style="width: {{ $draftPercent }}%" title="Черновики: {{ $stats['submissions']['draft'] }}"></div>
                </div>
                
                <div class="legend-list mt-4">
                    <div class="legend-item">
                        <span class="legend-color bg-warning"></span>
                        <span>На проверке ({{ $stats['submissions']['submitted'] }})</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-color bg-success"></span>
                        <span>Принято ({{ $stats['submissions']['accepted'] }})</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-color bg-danger"></span>
                        <span>Отклонено ({{ $stats['submissions']['rejected'] }})</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-color" style="background: #f59e0b;"></span>
                        <span>На доработке ({{ $stats['submissions']['needs_fix'] }})</span>
                    </div>
                    <div class="legend-item">
                        <span class="legend-color bg-secondary"></span>
                        <span>Черновики ({{ $stats['submissions']['draft'] }})</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Последние записи -->
<div class="row g-4">
    <div class="col-md-4">
        <div class="list-card">
            <div class="card-header">
                <h5 class="mb-0">Последние конкурсы</h5>
                <a href="{{ route('admin.contests.index') }}" class="btn btn-sm btn-secondary">Все</a>
            </div>
            <div class="card-body p-0">
                @forelse($recentContests as $contest)
                    <div class="list-item">
                        <div class="list-item-content">
                            <div class="list-item-title">
                                <a href="{{ route('admin.contests.edit', $contest) }}">{{ $contest->title }}</a>
                            </div>
                            <div class="list-item-meta">
                                <span><i class="bi bi-calendar"></i> до {{ $contest->deadline_at->format('d.m.Y') }}</span>
                                @if($contest->is_active)
                                    <span class="badge bg-success">Активен</span>
                                @else
                                    <span class="badge bg-secondary">Завершен</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="list-item text-muted">Нет конкурсов</div>
                @endforelse
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="list-card">
            <div class="card-header">
                <h5 class="mb-0">Новые пользователи</h5>
                <a href="{{ route('admin.users.index') }}" class="btn btn-sm btn-secondary">Все</a>
            </div>
            <div class="card-body p-0">
                @forelse($recentUsers as $user)
                    <div class="list-item">
                        <div class="list-item-content">
                            <div class="list-item-title">{{ $user->name }}</div>
                            <div class="list-item-meta">
                                <span><i class="bi bi-envelope"></i> {{ $user->email }}</span>
                                <span class="badge" style="background: {{ 
                                    $user->isAdmin() ? '#dc2626' : ($user->isJury() ? '#f59e0b' : '#059669') 
                                }}">{{ $user->role == 'admin' ? 'Админ' : ($user->role == 'jury' ? 'Жюри' : 'Участник') }}</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="list-item text-muted">Нет пользователей</div>
                @endforelse
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="list-card">
            <div class="card-header">
                <h5 class="mb-0">Последние работы</h5>
                <span class="badge bg-secondary">всего {{ $stats['submissions']['total'] }}</span>
            </div>
            <div class="card-body p-0">
                @forelse($recentSubmissions as $submission)
                    <div class="list-item">
                        <div class="list-item-content">
                            <div class="list-item-title">{{ $submission->title }}</div>
                            <div class="list-item-meta">
                                <span><i class="bi bi-person"></i> {{ $submission->user->name }}</span>
                                <span><i class="bi bi-trophy"></i> {{ $submission->contest->title }}</span>
                            </div>
                            <div class="mt-2">
                                <span class="badge badge-{{ $submission->status }}">
                                    @switch($submission->status)
                                        @case('draft') Черновик @break
                                        @case('submitted') На проверке @break
                                        @case('needs_fix') Доработка @break
                                        @case('accepted') Принята @break
                                        @case('rejected') Отклонена @break
                                    @endswitch
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="list-item text-muted">Нет работ</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Быстрые действия -->
<div class="row mt-4">
    <div class="col-12">
        <div class="actions-card">
            <div class="card-header">
                <h5 class="mb-0">Быстрые действия</h5>
            </div>
            <div class="card-body">
                <a href="{{ route('admin.contests.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Новый конкурс
                </a>
                <a href="{{ route('admin.users.create') }}" class="btn btn-success">
                    <i class="bi bi-person-plus"></i> Новый пользователь
                </a>
            </div>
        </div>
    </div>
</div>
@endsection