@extends('layouts.app')

@section('title', 'Создание работы')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <i class="bi bi-plus-circle"></i> Новая работа
            </div>
            <div class="card-body">
                <form method="POST" action="{{ route('participant.submissions.store') }}">
                    @csrf
                    
                    <div class="mb-3">
                        <label for="contest_id" class="form-label">Конкурс</label>
                        <select class="form-control @error('contest_id') is-invalid @enderror" 
                                id="contest_id" name="contest_id" required>
                            <option value="">Выберите конкурс</option>
                            @foreach($contests as $contest)
                                <option value="{{ $contest->id }}" 
                                    {{ (old('contest_id') == $contest->id || (isset($selectedContest) && $selectedContest?->id == $contest->id)) ? 'selected' : '' }}>
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
                               id="title" name="title" value="{{ old('title') }}" required>
                        @error('title')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Описание</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="alert alert-info">
                        <i class="bi bi-info-circle"></i>
                        После создания черновика вы сможете загрузить файлы (до 3 файлов, не более 10MB каждый).
                        Разрешены форматы: PDF, ZIP, PNG, JPG.
                    </div>

                    <div class="d-flex justify-content-between">
                        <a href="{{ route('participant.submissions.index') }}" class="btn btn-secondary">
                            Назад
                        </a>
                        <button type="submit" class="btn btn-primary">
                            Создать черновик
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection