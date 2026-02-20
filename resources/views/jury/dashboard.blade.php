@extends('layouts.app')

@section('title', 'Панель жюри')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1 class="h2 mb-4">Панель жюри</h1>
    </div>
</div>

<!-- Статистика -->
<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(37, 99, 235, 0.1); color: #2563eb;">
                <i class="bi bi-clock-history"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label">Ожидают проверки</span>
                <span class="stat-value">{{ $stats['pending'] }}</span>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                <i class="bi bi-arrow-repeat"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label">На доработке</span>
                <span class="stat-value">{{ $stats['needs_fix'] }}</span>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(5, 150, 105, 0.1); color: #059669;">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label">Принято работ</span>
                <span class="stat-value">{{ $stats['accepted'] }}</span>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(220, 38, 38, 0.1); color: #dc2626;">
                <i class="bi bi-x-circle"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label">Отклонено работ</span>
                <span class="stat-value">{{ $stats['rejected'] }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Прогресс по конкурсам -->
<div class="row g-4 mb-5">
    <div class="col-12">
        <div class="chart-card">
            <div class="card-header">
                <h5 class="mb-0">Прогресс проверки по конкурсам</h5>
                <span class="badge bg-secondary">{{ count($contestStats) }} активных</span>
            </div>
            <div class="card-body">
                @forelse($contestStats as $stat)
                    <div class="stat-item mb-4">
                        <div class="d-flex justify-content-between mb-2">
                            <div>
                                <span class="fw-semibold">{{ $stat['name'] }}</span>
                                <span class="text-muted ms-2">(всего работ: {{ $stat['total'] }})</span>
                            </div>
                            <span class="badge bg-warning">{{ $stat['pending'] }} на проверке</span>
                        </div>
                        <div class="progress" style="height: 8px;">
                            @php $progress = $stat['total'] > 0 ? (($stat['total'] - $stat['pending']) / $stat['total']) * 100 : 0; @endphp
                            <div class="progress-bar bg-success" style="width: {{ $progress }}%"></div>
                            @if($stat['pending'] > 0)
                                <div class="progress-bar bg-warning" style="width: {{ ($stat['pending'] / $stat['total']) * 100 }}%"></div>
                            @endif
                        </div>
                        <div class="d-flex justify-content-between mt-2 small">
                            <span class="text-success">✓ Проверено: {{ $stat['total'] - $stat['pending'] }}</span>
                            <span class="text-warning">⏳ Осталось: {{ $stat['pending'] }}</span>
                        </div>
                    </div>
                @empty
                    <p class="text-muted text-center py-4">Нет активных конкурсов</p>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Списки работ -->
<div class="row g-4">
    <div class="col-md-6">
        <div class="list-card">
            <div class="card-header">
                <h5 class="mb-0">Ожидают проверки</h5>
                <a href="{{ route('jury.submissions.index', ['status' => 'submitted']) }}" class="btn btn-sm btn-primary">
                    Все {{ $stats['pending'] }}
                </a>
            </div>
            <div class="card-body p-0">
                @forelse($pendingSubmissions as $submission)
                    <div class="list-item">
                        <div class="list-item-content">
                            <div class="list-item-title">
                                <a href="{{ route('jury.submissions.show', $submission) }}">
                                    {{ $submission->title }}
                                </a>
                            </div>
                            <div class="list-item-meta">
                                <span><i class="bi bi-person"></i> {{ $submission->user->name }}</span>
                                <span><i class="bi bi-trophy"></i> {{ $submission->contest->title }}</span>
                                <span><i class="bi bi-clock"></i> {{ $submission->created_at->diffForHumans() }}</span>
                            </div>
                            <div class="mt-2">
                                <span class="badge bg-warning">Ожидает</span>
                            </div>
                        </div>
                        <div class="list-item-action">
                            <a href="{{ route('jury.submissions.show', $submission) }}" class="btn btn-sm btn-primary">
                                Проверить
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="list-item text-muted">Нет работ на проверке</div>
                @endforelse
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="list-card">
            <div class="card-header">
                <h5 class="mb-0">Требуют доработки</h5>
                <a href="{{ route('jury.submissions.index', ['status' => 'needs_fix']) }}" class="btn btn-sm btn-warning">
                    Все {{ $stats['needs_fix'] }}
                </a>
            </div>
            <div class="card-body p-0">
                @forelse($needsFixSubmissions as $submission)
                    <div class="list-item">
                        <div class="list-item-content">
                            <div class="list-item-title">
                                <a href="{{ route('jury.submissions.show', $submission) }}">
                                    {{ $submission->title }}
                                </a>
                            </div>
                            <div class="list-item-meta">
                                <span><i class="bi bi-person"></i> {{ $submission->user->name }}</span>
                                <span><i class="bi bi-trophy"></i> {{ $submission->contest->title }}</span>
                            </div>
                            <div class="mt-2">
                                <span class="badge" style="background: #f59e0b;">На доработке</span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="list-item text-muted">Нет работ на доработке</div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Моя статистика -->
<div class="row mt-4">
    <div class="col-12">
        <div class="stats-mini-grid">
            <div class="stats-mini-item">
                <span class="stats-mini-label">Принято мной</span>
                <span class="stats-mini-number">{{ $myStats['accepted'] }}</span>
            </div>
            <div class="stats-mini-item">
                <span class="stats-mini-label">Отклонено мной</span>
                <span class="stats-mini-number">{{ $myStats['rejected'] }}</span>
            </div>
            <div class="stats-mini-item">
                <span class="stats-mini-label">На доработку</span>
                <span class="stats-mini-number">{{ $myStats['needs_fix'] }}</span>
            </div>
            <div class="stats-mini-item">
                <span class="stats-mini-label">Всего проверено</span>
                <span class="stats-mini-number">{{ $myStats['accepted'] + $myStats['rejected'] + $myStats['needs_fix'] }}</span>
            </div>
        </div>
    </div>
</div>
@endsection