@extends('layouts.app')

@section('title', 'Моя страница')

@section('content')
<div class="row mb-4">
    <div class="col-12">
        <h1 class="h2 mb-4">Моя страница</h1>
    </div>
</div>

<!-- Статистика -->
<div class="row g-4 mb-5">
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(37, 99, 235, 0.1); color: #2563eb;">
                <i class="bi bi-files"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label">Всего работ</span>
                <span class="stat-value">{{ $stats['total'] }}</span>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(107, 114, 128, 0.1); color: #6b7280;">
                <i class="bi bi-pencil"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label">Черновики</span>
                <span class="stat-value">{{ $stats['draft'] }}</span>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(245, 158, 11, 0.1); color: #f59e0b;">
                <i class="bi bi-hourglass-split"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label">На проверке</span>
                <span class="stat-value">{{ $stats['submitted'] }}</span>
            </div>
        </div>
    </div>
    
    <div class="col-md-3">
        <div class="stat-card">
            <div class="stat-icon" style="background: rgba(5, 150, 105, 0.1); color: #059669;">
                <i class="bi bi-check-circle"></i>
            </div>
            <div class="stat-content">
                <span class="stat-label">Принято</span>
                <span class="stat-value">{{ $stats['accepted'] }}</span>
            </div>
        </div>
    </div>
</div>

<!-- Детальная статистика -->
<div class="row g-4 mb-5">
    <div class="col-md-6">
        <div class="chart-card">
            <div class="card-header">
                <h5 class="mb-0">Распределение работ</h5>
                <span class="badge bg-secondary">всего {{ $stats['total'] }}</span>
            </div>
            <div class="card-body">
                <div class="stat-item mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Черновики</span>
                        <span class="fw-semibold">{{ $stats['draft'] }}</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        @php $draftPercent = $stats['total'] > 0 ? ($stats['draft'] / $stats['total']) * 100 : 0; @endphp
                        <div class="progress-bar bg-secondary" style="width: {{ $draftPercent }}%"></div>
                    </div>
                </div>
                
                <div class="stat-item mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span>На проверке</span>
                        <span class="fw-semibold">{{ $stats['submitted'] }}</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        @php $submittedPercent = $stats['total'] > 0 ? ($stats['submitted'] / $stats['total']) * 100 : 0; @endphp
                        <div class="progress-bar bg-warning" style="width: {{ $submittedPercent }}%"></div>
                    </div>
                </div>
                
                <div class="stat-item mb-4">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Принято</span>
                        <span class="fw-semibold">{{ $stats['accepted'] }}</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        @php $acceptedPercent = $stats['total'] > 0 ? ($stats['accepted'] / $stats['total']) * 100 : 0; @endphp
                        <div class="progress-bar bg-success" style="width: {{ $acceptedPercent }}%"></div>
                    </div>
                </div>
                
                <div class="stat-item">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Требуют доработки</span>
                        <span class="fw-semibold">{{ $stats['needs_fix'] }}</span>
                    </div>
                    <div class="progress" style="height: 8px;">
                        @php $needsFixPercent = $stats['total'] > 0 ? ($stats['needs_fix'] / $stats['total']) * 100 : 0; @endphp
                        <div class="progress-bar" style="background: #f59e0b; width: {{ $needsFixPercent }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-md-6">
        <div class="chart-card">
            <div class="card-header">
                <h5 class="mb-0">Статистика по статусам</h5>
            </div>
            <div class="card-body">
                <div class="stats-grid">
                    <div class="stats-row">
                        <div class="stats-label">Отклонено</div>
                        <div class="stats-bar">
                            <div class="progress" style="height: 8px;">
                                @php $rejectedPercent = $stats['total'] > 0 ? ($stats['rejected'] / $stats['total']) * 100 : 0; @endphp
                                <div class="progress-bar bg-danger" style="width: {{ $rejectedPercent }}%"></div>
                            </div>
                        </div>
                        <div class="stats-value">{{ $stats['rejected'] }}</div>
                    </div>
                    
                    <div class="stats-row">
                        <div class="stats-label">На доработке</div>
                        <div class="stats-bar">
                            <div class="progress" style="height: 8px;">
                                @php $needsFixPercent = $stats['total'] > 0 ? ($stats['needs_fix'] / $stats['total']) * 100 : 0; @endphp
                                <div class="progress-bar" style="background: #f59e0b; width: {{ $needsFixPercent }}%"></div>
                            </div>
                        </div>
                        <div class="stats-value">{{ $stats['needs_fix'] }}</div>
                    </div>
                    
                    <div class="stats-row">
                        <div class="stats-label">На проверке</div>
                        <div class="stats-bar">
                            <div class="progress" style="height: 8px;">
                                @php $submittedPercent = $stats['total'] > 0 ? ($stats['submitted'] / $stats['total']) * 100 : 0; @endphp
                                <div class="progress-bar bg-warning" style="width: {{ $submittedPercent }}%"></div>
                            </div>
                        </div>
                        <div class="stats-value">{{ $stats['submitted'] }}</div>
                    </div>
                    
                    <div class="stats-row">
                        <div class="stats-label">Принято</div>
                        <div class="stats-bar">
                            <div class="progress" style="height: 8px;">
                                @php $acceptedPercent = $stats['total'] > 0 ? ($stats['accepted'] / $stats['total']) * 100 : 0; @endphp
                                <div class="progress-bar bg-success" style="width: {{ $acceptedPercent }}%"></div>
                            </div>
                        </div>
                        <div class="stats-value">{{ $stats['accepted'] }}</div>
                    </div>
                </div>
                
                <div class="success-rate mt-4 pt-3 border-top">
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="text-muted">Процент успешных работ</span>
                        <span class="fw-semibold fs-4">
                            @php $successRate = $stats['total'] > 0 ? round(($stats['accepted'] / $stats['total']) * 100) : 0; @endphp
                            {{ $successRate }}%
                        </span>
                    </div>
                    <div class="progress mt-2" style="height: 8px;">
                        <div class="progress-bar bg-success" style="width: {{ $successRate }}%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Последние работы -->
<div class="row">
    <div class="col-12">
        <div class="list-card">
            <div class="card-header">
                <h5 class="mb-0">Последние работы</h5>
                <a href="{{ route('participant.submissions.index') }}" class="btn btn-sm btn-secondary">
                    Все работы
                </a>
            </div>
            <div class="card-body p-0">
                @forelse($recentSubmissions as $submission)
                    <div class="list-item">
                        <div class="list-item-content">
                            <div class="list-item-title">
                                <a href="{{ route('participant.submissions.show', $submission) }}">
                                    {{ $submission->title }}
                                </a>
                            </div>
                            <div class="list-item-meta">
                                <span><i class="bi bi-trophy"></i> {{ $submission->contest->title }}</span>
                                <span><i class="bi bi-calendar"></i> {{ $submission->created_at->format('d.m.Y') }}</span>
                                <span><i class="bi bi-files"></i> {{ $submission->attachments->count() }} файлов</span>
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
                    <div class="list-item text-muted">У вас пока нет работ</div>
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
                <a href="{{ route('participant.submissions.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Новая работа
                </a>
                <a href="{{ route('contests.index') }}" class="btn btn-success">
                    <i class="bi bi-trophy"></i> Все конкурсы
                </a>
            </div>
        </div>
    </div>
</div>
@endsection