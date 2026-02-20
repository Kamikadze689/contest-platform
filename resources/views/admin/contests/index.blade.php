@extends('layouts.app')

@section('title', 'Конкурсы')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Конкурсы</h5>
        <a href="{{ route('admin.contests.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus"></i> Новый конкурс
        </a>
    </div>
    <div class="card-body p-0">
        <div class="admin-contest-list">
            @foreach($contests as $contest)
                <a href="{{ route('admin.contests.edit', $contest) }}" class="admin-contest-item">
                    <div class="admin-contest-content">
                        <div class="d-flex align-items-start justify-content-between">
                            <div>
                                <h6 class="contest-name">{{ $contest->title }}</h6>
                                <div class="contest-meta">
                                    <span><i class="bi bi-calendar"></i> Дедлайн: {{ $contest->deadline_at->format('d.m.Y H:i') }}</span>
                                    <span><i class="bi bi-people"></i> Работ: {{ $contest->submissions->count() }}</span>
                                    <span><i class="bi bi-clock"></i> Создан: {{ $contest->created_at->format('d.m.Y') }}</span>
                                </div>
                            </div>
                            @if($contest->is_active)
                                <span class="badge bg-success">Активен</span>
                            @else
                                <span class="badge bg-secondary">Неактивен</span>
                            @endif
                        </div>
                        <p class="contest-description mt-2">{{ Str::limit($contest->description, 150) }}</p>
                    </div>
                    <div class="contest-action">
                        <span class="btn btn-sm btn-secondary">Редактировать</span>
                    </div>
                </a>
            @endforeach
        </div>
        
        <div class="p-3">
            {{ $contests->links() }}
        </div>
    </div>
</div>

<style>
.admin-contest-list {
    display: flex;
    flex-direction: column;
}

.admin-contest-item {
    display: flex;
    align-items: center;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--gray-200);
    text-decoration: none;
    color: inherit;
    transition: all 0.2s;
    cursor: pointer;
}

.admin-contest-item:hover {
    background: var(--gray-50);
    transform: translateX(4px);
}

.admin-contest-item:last-child {
    border-bottom: none;
}

.admin-contest-content {
    flex: 1;
}

.contest-name {
    font-weight: 600;
    color: var(--gray-900);
    margin-bottom: 0.5rem;
    font-size: 1rem;
}

.contest-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1.25rem;
    color: var(--gray-600);
    font-size: 0.875rem;
}

.contest-meta i {
    margin-right: 0.375rem;
    color: var(--gray-400);
}

.contest-description {
    color: var(--gray-700);
    font-size: 0.9375rem;
    margin: 0.5rem 0 0 0;
}

.contest-action .btn {
    pointer-events: none;
}

.badge {
    pointer-events: none;
}
</style>
@endsection