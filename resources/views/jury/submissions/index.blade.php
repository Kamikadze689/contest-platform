@extends('layouts.app')

@section('title', 'Работы на проверку')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Работы на проверку</h5>
    </div>
    <div class="card-body p-0">
        <!-- Фильтры -->
        <div class="p-3 border-bottom">
            <form method="GET" class="row g-3">
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control" placeholder="Поиск по названию" value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select">
                        <option value="">Все статусы</option>
                        <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>На проверке</option>
                        <option value="needs_fix" {{ request('status') == 'needs_fix' ? 'selected' : '' }}>Требуют доработки</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Применить</button>
                    <a href="{{ route('jury.submissions.index') }}" class="btn btn-secondary">Сброс</a>
                </div>
            </form>
        </div>

        <!-- Список работ -->
        @if($submissions->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-check2-square" style="font-size: 3rem; opacity: 0.3;"></i>
                <p class="mt-3 text-muted">Нет работ для проверки</p>
            </div>
        @else
            <div class="jury-submission-list">
                @foreach($submissions as $submission)
                    <a href="{{ route('jury.submissions.show', $submission) }}" class="jury-submission-item">
                        <div class="jury-submission-content">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <h6 class="submission-title">{{ $submission->title }}</h6>
                                    <div class="submission-meta">
                                        <span><i class="bi bi-person"></i> {{ $submission->user->name }}</span>
                                        <span><i class="bi bi-trophy"></i> {{ $submission->contest->title }}</span>
                                        <span><i class="bi bi-files"></i> {{ $submission->attachments->count() }} файлов</span>
                                        <span><i class="bi bi-calendar"></i> {{ $submission->created_at->format('d.m.Y') }}</span>
                                    </div>
                                </div>
                                <span class="badge {{ $submission->status == 'submitted' ? 'bg-warning' : 'bg-info' }}">
                                    {{ $submission->status == 'submitted' ? 'На проверке' : 'Доработка' }}
                                </span>
                            </div>
                            
                            @if($submission->comments->count() > 0)
                                <div class="mt-2 text-muted small">
                                    <i class="bi bi-chat"></i> Есть комментарии
                                </div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
            
            <div class="p-3">
                {{ $submissions->withQueryString()->links() }}
            </div>
        @endif
    </div>
</div>

<style>
.jury-submission-list {
    display: flex;
    flex-direction: column;
}

.jury-submission-item {
    display: block;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--gray-200);
    text-decoration: none;
    color: inherit;
    transition: all 0.2s;
    cursor: pointer;
}

.jury-submission-item:hover {
    background: var(--gray-50);
    transform: translateX(4px);
}

.jury-submission-item:last-child {
    border-bottom: none;
}

.submission-title {
    font-weight: 600;
    color: var(--gray-900);
    margin-bottom: 0.5rem;
    font-size: 1rem;
}

.submission-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1.25rem;
    color: var(--gray-600);
    font-size: 0.875rem;
}

.submission-meta i {
    margin-right: 0.375rem;
    color: var(--gray-400);
}

.badge {
    pointer-events: none;
}
</style>
@endsection