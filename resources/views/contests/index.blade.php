@extends('layouts.app')

@section('title', 'Конкурсы')

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Активные конкурсы</h5>
            </div>
            <div class="card-body p-0">
                @if($contests->isEmpty())
                    <div class="text-muted text-center py-5">
                        <i class="bi bi-trophy" style="font-size: 3rem; opacity: 0.3;"></i>
                        <p class="mt-3">Нет активных конкурсов</p>
                    </div>
                @else
                    <div class="contest-list">
                        @foreach($contests as $contest)
                            <a href="{{ route('contests.show', $contest) }}" class="contest-item">
                                <div class="contest-item-content">
                                    <h6 class="contest-title">{{ $contest->title }}</h6>
                                    <div class="contest-meta">
                                        <span><i class="bi bi-calendar"></i> Дедлайн: {{ $contest->deadline_at->format('d.m.Y H:i') }}</span>
                                        <span><i class="bi bi-people"></i> Участников: {{ $contest->submissions->count() }}</span>
                                    </div>
                                    <p class="contest-description">{{ Str::limit($contest->description, 200) }}</p>
                                </div>
                                <div class="contest-action">
                                    @auth
                                        @if(auth()->user()->isParticipant())
                                            <span class="btn btn-sm btn-primary">Участвовать</span>
                                        @endif
                                    @else
                                        <span class="btn btn-sm btn-secondary">Войти для участия</span>
                                    @endauth
                                </div>
                            </a>
                        @endforeach
                    </div>
                    
                    <div class="p-3">
                        {{ $contests->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<style>
.contest-list {
    display: flex;
    flex-direction: column;
}

.contest-item {
    display: flex;
    align-items: center;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--gray-200);
    text-decoration: none;
    color: inherit;
    transition: all 0.2s;
    cursor: pointer;
}

.contest-item:hover {
    background: var(--gray-50);
    transform: translateX(4px);
}

.contest-item:last-child {
    border-bottom: none;
}

.contest-item-content {
    flex: 1;
}

.contest-title {
    font-weight: 600;
    color: var(--gray-900);
    margin-bottom: 0.5rem;
    font-size: 1.1rem;
}

.contest-meta {
    display: flex;
    gap: 1.5rem;
    color: var(--gray-600);
    font-size: 0.875rem;
    margin-bottom: 0.5rem;
}

.contest-meta i {
    margin-right: 0.375rem;
    color: var(--gray-400);
}

.contest-description {
    color: var(--gray-700);
    font-size: 0.9375rem;
    margin: 0;
}

.contest-action {
    margin-left: 1.5rem;
}

.contest-action .btn {
    pointer-events: none; /* Чтобы кнопка не перехватывала клик у ссылки */
}
</style>
@endsection