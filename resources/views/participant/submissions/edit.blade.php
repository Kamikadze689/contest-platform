@extends('layouts.app')

@section('title', 'Редактирование работы')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5 class="mb-0">Редактирование работы: {{ $submission->title }}</h5>
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('participant.submissions.update', $submission) }}">
                        @csrf
                        @method('PUT')
                        
                        <div class="mb-3">
                            <label for="contest_id" class="form-label">Конкурс</label>
                            <select class="form-select @error('contest_id') is-invalid @enderror" 
                                    id="contest_id" name="contest_id" required>
                                <option value="">Выберите конкурс</option>
                                @foreach($contests as $contest)
                                    <option value="{{ $contest->id }}" {{ ($submission->contest_id == $contest->id) ? 'selected' : '' }}>
                                        {{ $contest->title }} (до {{ $contest->deadline_at->format('d.m.Y') }})
                                    </option>
                                @endforeach
                            </select>
                            @error('contest_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="title" class="form-label">Название работы</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title', $submission->title) }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Описание</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="5" required>{{ old('description', $submission->description) }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('participant.submissions.show', $submission) }}" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Назад
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Сохранить
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection