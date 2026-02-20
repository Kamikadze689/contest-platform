@extends('layouts.app')

@section('title', $contest->title)

@section('content')
<div class="row">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-trophy"></i> {{ $contest->title }}
            </div>
            <div class="card-body">
                <p class="text-muted mb-3">
                    <i class="bi bi-calendar"></i> Дедлайн: {{ $contest->deadline_at->format('d.m.Y H:i') }}
                    @if($contest->is_active)
                        <span class="badge bg-success ms-2">Активен</span>
                    @else
                        <span class="badge bg-secondary ms-2">Завершен</span>
                    @endif
                </p>
                
                <h6>Описание конкурса:</h6>
                <p>{{ $contest->description }}</p>
                
                <hr>
                
                <h6>Участники: {{ $contest->submissions->count() }}</h6>
                
                @auth
                    @if(auth()->user()->isParticipant() && $contest->is_active)
                        <a href="{{ route('participant.submissions.create', ['contest_id' => $contest->id]) }}" 
                           class="btn btn-primary mt-3">
                            <i class="bi bi-plus"></i> Участвовать в конкурсе
                        </a>
                    @endif
                @endauth
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-info-circle"></i> Информация
            </div>
            <div class="card-body">
                <ul class="list-unstyled">
                    <li class="mb-2">
                        <i class="bi bi-calendar-check"></i>
                        <strong>Дата создания:</strong><br>
                        {{ $contest->created_at->format('d.m.Y') }}
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-clock"></i>
                        <strong>Дедлайн:</strong><br>
                        {{ $contest->deadline_at->format('d.m.Y H:i') }}
                    </li>
                    <li>
                        <i class="bi bi-people"></i>
                        <strong>Участников:</strong><br>
                        {{ $contest->submissions->count() }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection