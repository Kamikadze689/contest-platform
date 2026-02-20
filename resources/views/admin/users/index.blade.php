@extends('layouts.app')

@section('title', 'Пользователи')

@section('content')
<div class="card">
    <div class="card-header">
        <h5 class="mb-0">Пользователи</h5>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary btn-sm">
            <i class="bi bi-plus"></i> Новый пользователь
        </a>
    </div>
    <div class="card-body p-0">
        <div class="users-list">
            @foreach($users as $user)
                <a href="{{ route('admin.users.edit', $user) }}" class="user-item">
                    <div class="user-avatar">
                        <i class="bi bi-person-circle"></i>
                    </div>
                    <div class="user-content">
                        <div class="d-flex align-items-center gap-3">
                            <h6 class="user-name">{{ $user->name }}</h6>
                            <span class="badge" style="background: {{ 
                                $user->isAdmin() ? '#dc2626' : ($user->isJury() ? '#f59e0b' : '#059669') 
                            }}">{{ $user->role == 'admin' ? 'Администратор' : ($user->role == 'jury' ? 'Жюри' : 'Участник') }}</span>
                        </div>
                        <div class="user-meta">
                            <span><i class="bi bi-envelope"></i> {{ $user->email }}</span>
                            <span><i class="bi bi-calendar"></i> Зарегистрирован: {{ $user->created_at->format('d.m.Y') }}</span>
                            <span><i class="bi bi-files"></i> Работ: {{ $user->submissions->count() }}</span>
                        </div>
                    </div>
                    <div class="user-action">
                        <span class="btn btn-sm btn-secondary">Редактировать</span>
                    </div>
                </a>
            @endforeach
        </div>
        
        <div class="p-3">
            {{ $users->links() }}
        </div>
    </div>
</div>

<style>
.users-list {
    display: flex;
    flex-direction: column;
}

.user-item {
    display: flex;
    align-items: center;
    padding: 1.25rem 1.5rem;
    border-bottom: 1px solid var(--gray-200);
    text-decoration: none;
    color: inherit;
    transition: all 0.2s;
    cursor: pointer;
    gap: 1rem;
}

.user-item:hover {
    background: var(--gray-50);
    transform: translateX(4px);
}

.user-item:last-child {
    border-bottom: none;
}

.user-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: var(--gray-100);
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--gray-500);
    font-size: 1.5rem;
}

.user-content {
    flex: 1;
}

.user-name {
    font-weight: 600;
    color: var(--gray-900);
    margin: 0;
    font-size: 1rem;
}

.user-meta {
    display: flex;
    flex-wrap: wrap;
    gap: 1.25rem;
    color: var(--gray-600);
    font-size: 0.875rem;
    margin-top: 0.375rem;
}

.user-meta i {
    margin-right: 0.375rem;
    color: var(--gray-400);
}

.user-action .btn {
    pointer-events: none;
}
</style>
@endsection