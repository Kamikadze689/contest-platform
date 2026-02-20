@extends('layouts.app')

@section('title', 'Мои работы')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Мои работы</h5>
        <a href="{{ route('participant.submissions.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus"></i> Новая работа
        </a>
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
                        <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Черновики</option>
                        <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>На проверке</option>
                        <option value="needs_fix" {{ request('status') == 'needs_fix' ? 'selected' : '' }}>Доработка</option>
                        <option value="accepted" {{ request('status') == 'accepted' ? 'selected' : '' }}>Принятые</option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Отклоненные</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary">Применить</button>
                    <a href="{{ route('participant.submissions.index') }}" class="btn btn-secondary">Сброс</a>
                </div>
            </form>
        </div>

        <!-- Список работ -->
        @if($submissions->isEmpty())
            <div class="text-center py-5">
                <i class="bi bi-file-earmark-text" style="font-size: 3rem; opacity: 0.3;"></i>
                <p class="mt-3 text-muted">У вас пока нет работ</p>
                <a href="{{ route('participant.submissions.create') }}" class="btn btn-primary">
                    Создать первую работу
                </a>
            </div>
        @else
            <div class="submission-list">
                @foreach($submissions as $submission)
                    <a href="{{ route('participant.submissions.show', $submission) }}" class="submission-item">
                        <div class="submission-item-content">
                            <div class="d-flex align-items-start justify-content-between">
                                <div>
                                    <h6 class="submission-title">{{ $submission->title }}</h6>
                                    <div class="submission-meta">
                                        <span><i class="bi bi-trophy"></i> {{ $submission->contest->title }}</span>
                                        <span><i class="bi bi-files"></i> {{ $submission->attachments->count() }}/3 файлов</span>
                                        <span><i class="bi bi-chat"></i> {{ $submission->comments->count() }} комментариев</span>
                                        <span><i class="bi bi-calendar"></i> {{ $submission->created_at->format('d.m.Y') }}</span>
                                    </div>
                                </div>
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
                            
                            @if($submission->status == 'needs_fix')
                                <div class="mt-2 text-warning small">
                                    <i class="bi bi-exclamation-triangle"></i> Требуется доработка
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
.submission-list {
    display: flex;
    flex-direction: column;
}

.submission-item {
    display: block;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--gray-200);
    text-decoration: none;
    color: inherit;
    transition: all 0.2s;
    cursor: pointer;
}

.submission-item:hover {
    background: var(--gray-50);
    transform: translateX(4px);
}

.submission-item:last-child {
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
    pointer-events: none; /* Чтобы бейдж не мешал клику */
}
</style>
@endsection