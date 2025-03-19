@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Dettagli Progetto</h1>
        <a href="{{ route('projects.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Torna alla lista
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Titolo</dt>
                <dd class="col-sm-9">{{ $project->title }}</dd>

                <dt class="col-sm-3">Cliente</dt>
                <dd class="col-sm-9">
                    <a href="{{ route('clients.show', $project->client) }}">
                        {{ $project->client->name }}
                    </a>
                </dd>

                <dt class="col-sm-3">Stato</dt>
                <dd class="col-sm-9">
                    @switch($project->status)
                        @case('pending')
                            <span class="badge bg-warning">In Attesa</span>
                            @break
                        @case('in_progress')
                            <span class="badge bg-info">In Corso</span>
                            @break
                        @case('completed')
                            <span class="badge bg-success">Completato</span>
                            @break
                        @case('cancelled')
                            <span class="badge bg-danger">Annullato</span>
                            @break
                    @endswitch
                </dd>

                <dt class="col-sm-3">Descrizione</dt>
                <dd class="col-sm-9">{{ $project->description }}</dd>

                <dt class="col-sm-3">Data Inizio</dt>
                <dd class="col-sm-9">{{ $project->start_date ? $project->start_date->format('d/m/Y') : 'Non specificata' }}</dd>

                <dt class="col-sm-3">Data Fine</dt>
                <dd class="col-sm-9">{{ $project->end_date ? $project->end_date->format('d/m/Y') : 'Non specificata' }}</dd>

                <dt class="col-sm-3">Creato il</dt>
                <dd class="col-sm-9">{{ $project->created_at->format('d/m/Y H:i') }}</dd>

                <dt class="col-sm-3">Modificato il</dt>
                <dd class="col-sm-9">{{ $project->updated_at->format('d/m/Y H:i') }}</dd>
            </dl>
        </div>
        <div class="card-footer">
            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editProjectModal{{ $project->id }}">
                <i class="fas fa-edit me-1"></i> Modifica
            </button>
            <form action="{{ route('projects.destroy', $project) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Sei sicuro di voler eliminare questo progetto?')">
                    <i class="fas fa-trash me-1"></i> Elimina
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Edit Project Modal -->
<div class="modal fade" id="editProjectModal{{ $project->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifica Progetto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('projects.update', $project) }}" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="title" class="form-label">Titolo</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{ $project->title }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="client_id" class="form-label">Cliente</label>
                        <select class="form-select" id="client_id" name="client_id" required>
                            @foreach($clients as $client)
                                <option value="{{ $client->id }}" {{ $project->client_id == $client->id ? 'selected' : '' }}>
                                    {{ $client->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Descrizione</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required>{{ $project->description }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Stato</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="pending" {{ $project->status == 'pending' ? 'selected' : '' }}>In Attesa</option>
                            <option value="in_progress" {{ $project->status == 'in_progress' ? 'selected' : '' }}>In Corso</option>
                            <option value="completed" {{ $project->status == 'completed' ? 'selected' : '' }}>Completato</option>
                            <option value="cancelled" {{ $project->status == 'cancelled' ? 'selected' : '' }}>Annullato</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Data Inizio</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="{{ $project->start_date ? $project->start_date->format('Y-m-d') : '' }}">
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">Data Fine</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="{{ $project->end_date ? $project->end_date->format('Y-m-d') : '' }}">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                    <button type="submit" class="btn btn-primary">Salva modifiche</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection 