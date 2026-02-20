@extends('layouts.app')

@section('title', $submission->title)

@section('content')
<div class="container">
    <div class="mb-3">
        <a href="{{ route('jury.submissions.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Назад к списку
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ $submission->title }}</h4>
                        <span class="status-badge status-{{ $submission->status }}">
                            @switch($submission->status)
                                @case('submitted') На проверке @break
                                @case('needs_fix') Требуется доработка @break
                                @case('accepted') Принята @break
                                @case('rejected') Отклонена @break
                            @endswitch
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h6 class="text-muted">Информация об участнике:</h6>
                            <p>
                                <strong>Имя:</strong> {{ $submission->user->name }}<br>
                                <strong>Email:</strong> {{ $submission->user->email }}<br>
                                <strong>Участник с:</strong> {{ $submission->user->created_at->format('d.m.Y') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <h6 class="text-muted">Информация о конкурсе:</h6>
                            <p>
                                <strong>Название:</strong> {{ $submission->contest->title }}<br>
                                <strong>Дедлайн:</strong> {{ $submission->contest->deadline_at->format('d.m.Y H:i') }}<br>
                                <strong>Статус:</strong> 
                                @if($submission->contest->is_active)
                                    <span class="badge bg-success">Активен</span>
                                @else
                                    <span class="badge bg-secondary">Неактивен</span>
                                @endif
                            </p>
                        </div>
                    </div>

                    <h6>Описание работы:</h6>
                    <p class="mb-4">{{ $submission->description }}</p>
                    
                    <h6 class="mb-3">Прикрепленные файлы:</h6>
                    <div class="files-list">
                        @foreach($submission->attachments as $attachment)
                            <div class="file-item p-3 mb-2 border rounded">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <i class="bi bi-file-earmark"></i>
                                        {{ $attachment->original_name }}
                                        <span class="text-muted small">({{ round($attachment->size / 1024, 1) }} KB)</span>
                                        @if($attachment->status === 'scanned')
                                            <span class="badge bg-success ms-2">Проверен</span>
                                        @elseif($attachment->status === 'rejected')
                                            <span class="badge bg-danger ms-2">Отклонен</span>
                                            <small class="text-danger d-block">{{ $attachment->rejection_reason }}</small>
                                        @else
                                            <span class="badge bg-warning ms-2">В очереди</span>
                                        @endif
                                    </div>
                                    <!-- Замените существующую ссылку на скачивание -->
                                    <a href="{{ route('attachments.download', $attachment) }}" class="btn btn-sm btn-primary">
                                        <i class="bi bi-download"></i> Скачать
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="card mb-4">
                <div class="card-header">
                    <h5 class="mb-0">Комментарии</h5>
                </div>
                <div class="card-body">
                    <div class="comments-list mb-4">
                        @forelse($submission->comments as $comment)
                            <div class="comment mb-3 p-3 bg-light rounded">
                                <div class="d-flex justify-content-between">
                                    <strong>{{ $comment->user->name }}</strong>
                                    <small class="text-muted">{{ $comment->created_at->format('d.m.Y H:i') }}</small>
                                </div>
                                <p class="mb-0 mt-2">{{ $comment->body }}</p>
                            </div>
                        @empty
                            <p class="text-muted text-center">Пока нет комментариев</p>
                        @endforelse
                    </div>

                    <form action="{{ route('jury.submissions.comment', $submission) }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="comment" class="form-label">Добавить комментарий</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-chat"></i> Отправить
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Действия жюри</h5>
                </div>
                <div class="card-body">
                    @if(in_array($submission->status, ['submitted', 'needs_fix']))
                        <form action="{{ route('jury.submissions.status', $submission) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="accepted">
                            <button type="submit" class="btn btn-success w-100 mb-2" 
                                    onclick="return confirm('Принять работу?')">
                                <i class="bi bi-check-circle"></i> Принять
                            </button>
                        </form>

                        <form action="{{ route('jury.submissions.status', $submission) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="needs_fix">
                            <button type="submit" class="btn btn-warning w-100 mb-2" 
                                    onclick="return confirm('Запросить доработку?')">
                                <i class="bi bi-arrow-repeat"></i> Запросить доработку
                            </button>
                        </form>

                        <form action="{{ route('jury.submissions.status', $submission) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="rejected">
                            <button type="submit" class="btn btn-danger w-100 mb-2" 
                                    onclick="return confirm('Отклонить работу?')">
                                <i class="bi bi-x-circle"></i> Отклонить
                            </button>
                        </form>
                    @else
                        <p class="text-muted">Работа уже обработана</p>
                        <a href="{{ route('jury.submissions.index') }}" class="btn btn-primary w-100">
                            <i class="bi bi-arrow-left"></i> К списку
                        </a>
                    @endif
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-header">
                    <h5 class="mb-0">Информация</h5>
                </div>
                <div class="card-body">
                    <ul class="list-unstyled">
                        <li class="mb-2">
                            <i class="bi bi-calendar"></i>
                            <strong>Создана:</strong><br>
                            {{ $submission->created_at->format('d.m.Y H:i') }}
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-clock-history"></i>
                            <strong>Последнее обновление:</strong><br>
                            {{ $submission->updated_at->format('d.m.Y H:i') }}
                        </li>
                        <li>
                            <i class="bi bi-files"></i>
                            <strong>Всего файлов:</strong>
                            {{ $submission->attachments->count() }}
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection