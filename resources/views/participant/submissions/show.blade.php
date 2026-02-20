@extends('layouts.app')

@section('title', $submission->title)

@section('content')
<div class="container">
    <div class="mb-3">
        <a href="{{ route('participant.submissions.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Назад к списку
        </a>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card mb-4">
                <div class="card-header">
                    <div class="d-flex justify-content-between align-items-center">
                        <h4 class="mb-0">{{ $submission->title }}</h4>
                        <span class="badge badge-{{ $submission->status }}">
                            @switch($submission->status)
                                @case('draft') Черновик @break
                                @case('submitted') На проверке @break
                                @case('needs_fix') Требуется доработка @break
                                @case('accepted') Принята @break
                                @case('rejected') Отклонена @break
                            @endswitch
                        </span>
                    </div>
                </div>
                <div class="card-body">
                    <h6 class="text-muted mb-3">
                        <i class="bi bi-trophy"></i> Конкурс: {{ $submission->contest->title }}
                    </h6>
                    
                    <h6>Описание:</h6>
                    <p>{{ $submission->description }}</p>
                    
                    <h6 class="mt-4">Файлы:</h6>
                    <div class="files-list" id="filesList">
                        @foreach($submission->attachments as $attachment)
                            <div class="file-item" data-id="{{ $attachment->id }}">
                                <div class="file-info">
                                    <i class="bi bi-file-earmark"></i>
                                    <div>
                                        <div class="file-name">{{ $attachment->original_name }}</div>
                                        <div class="file-meta">
                                            {{ round($attachment->size / 1024, 1) }} KB
                                            @if($attachment->status == 'scanned')
                                                <span class="badge bg-success">Проверен</span>
                                            @elseif($attachment->status == 'rejected')
                                                <span class="badge bg-danger">Отклонен</span>
                                                @if($attachment->rejection_reason)
                                                    <div class="text-danger small">{{ $attachment->rejection_reason }}</div>
                                                @endif
                                            @else
                                                <span class="badge bg-warning text-dark">В очереди</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <a href="{{ route('attachments.download', $attachment) }}" class="btn btn-sm btn-primary" title="Скачать файл">
                                        <i class="bi bi-download"></i>
                                    </a>
                                    @if($submission->canBeEdited() && $attachment->status != 'scanned')
                                        <button class="btn btn-sm btn-danger delete-file" data-id="{{ $attachment->id }}" title="Удалить файл">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>

                    @if($submission->canBeEdited())
                        <div class="upload-section mt-3">
                            <h6>Загрузить файл:</h6>
                            <form id="uploadForm" enctype="multipart/form-data">
                                @csrf
                                <input type="file" name="file" id="file" class="form-control" accept=".pdf,.zip,.png,.jpg">
                                <div class="progress mt-2 d-none">
                                    <div class="progress-bar" role="progressbar" style="width: 0%"></div>
                                </div>
                            </form>
                            <small class="text-muted">Максимум 3 файла, не более 10MB каждый</small>
                        </div>
                    @endif
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Комментарии</h5>
                </div>
                <div class="card-body">
                    <div class="comments-list mb-4">
                        @forelse($submission->comments as $comment)
                            <div class="comment">
                                <div class="comment-header">
                                    <span class="comment-author">{{ $comment->user->name }}</span>
                                    <span class="comment-date">{{ $comment->created_at->format('d.m.Y H:i') }}</span>
                                </div>
                                <p class="mb-0">{{ $comment->body }}</p>
                            </div>
                        @empty
                            <p class="text-muted text-center">Нет комментариев</p>
                        @endforelse
                    </div>

                    @if($submission->canBeEdited())
                        <form action="{{ route('participant.submissions.comment', $submission) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="comment" class="form-label">Добавить комментарий</label>
                                <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-chat"></i> Отправить
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Действия</h5>
                </div>
                <div class="card-body">
                    @if($submission->canBeEdited())
                        <a href="{{ route('participant.submissions.edit', $submission) }}" class="btn btn-outline-primary w-100 mb-2">
                            <i class="bi bi-pencil"></i> Редактировать
                        </a>
                        
                        @if($submission->hasScannedAttachments())
                            <form action="{{ route('participant.submissions.submit', $submission) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="bi bi-send"></i> Отправить на проверку
                                </button>
                            </form>
                        @else
                            <button class="btn btn-secondary w-100" disabled>
                                <i class="bi bi-send"></i> Нужен проверенный файл
                            </button>
                        @endif
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.file-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.75rem;
    background: var(--gray-50);
    border: 1px solid var(--gray-200);
    border-radius: 0.5rem;
    margin-bottom: 0.5rem;
}

.file-info {
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.file-info i {
    color: var(--gray-400);
    font-size: 1.25rem;
}

.file-name {
    font-weight: 500;
    color: var(--gray-900);
}

.file-meta {
    font-size: 0.875rem;
    color: var(--gray-500);
}

.comment {
    background: var(--gray-50);
    border-radius: 0.5rem;
    padding: 1rem;
    margin-bottom: 1rem;
}

.comment-header {
    display: flex;
    justify-content: space-between;
    margin-bottom: 0.5rem;
    font-size: 0.875rem;
}

.comment-author {
    font-weight: 600;
    color: var(--gray-900);
}

.comment-date {
    color: var(--gray-500);
}

.progress {
    height: 6px;
    border-radius: 3px;
}
</style>

@push('scripts')
<script>
$(document).ready(function() {
    $('#file').on('change', function() {
        let file = this.files[0];
        if (!file) return;
        
        // Проверка на клиенте
        if (file.size > 10 * 1024 * 1024) {
            alert('Файл не должен превышать 10MB');
            this.value = '';
            return;
        }
        
        let formData = new FormData();
        formData.append('file', file);
        
        $.ajax({
            url: '{{ route("attachments.upload", $submission) }}',
            type: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            beforeSend: function() {
                $('.progress').removeClass('d-none');
                $('.progress-bar').css('width', '0%');
            },
            xhr: function() {
                let xhr = new window.XMLHttpRequest();
                xhr.upload.addEventListener('progress', function(e) {
                    if (e.lengthComputable) {
                        let percent = Math.round((e.loaded / e.total) * 100);
                        $('.progress-bar').css('width', percent + '%');
                    }
                });
                return xhr;
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                } else {
                    alert(response.error || 'Ошибка загрузки');
                }
            },
            error: function(xhr) {
                let errorMsg = 'Ошибка загрузки файла';
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMsg = xhr.responseJSON.error;
                } else if (xhr.status === 413) {
                    errorMsg = 'Файл слишком большой';
                } else if (xhr.status === 500) {
                    errorMsg = 'Ошибка сервера. Проверьте логи.';
                }
                alert(errorMsg);
                
                $('.progress').addClass('d-none');
                $('.progress-bar').css('width', '0%');
                $('#file').val('');
            }
        });
    });

    $('.delete-file').on('click', function() {
        if (!confirm('Удалить файл?')) return;
        
        let fileId = $(this).data('id');
        
        $.ajax({
            url: '/attachments/' + fileId,
            type: 'DELETE',
            data: {
                _token: '{{ csrf_token() }}'
            },
            success: function() {
                location.reload();
            },
            error: function(xhr) {
                let errorMsg = 'Ошибка удаления файла';
                if (xhr.responseJSON && xhr.responseJSON.error) {
                    errorMsg = xhr.responseJSON.error;
                }
                alert(errorMsg);
            }
        });
    });
});
</script>
@endpush
@endsection