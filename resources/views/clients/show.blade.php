@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Dettagli Cliente</h1>
        <a href="{{ route('clients.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Torna alla lista
        </a>
    </div>

    <div class="card">
        <div class="card-body">
            <dl class="row">
                <dt class="col-sm-3">Nome</dt>
                <dd class="col-sm-9">{{ $client->name }}</dd>

                <dt class="col-sm-3">Email</dt>
                <dd class="col-sm-9">{{ $client->email }}</dd>

                <dt class="col-sm-3">Telefono</dt>
                <dd class="col-sm-9">{{ $client->phone ?: 'Non specificato' }}</dd>

                <dt class="col-sm-3">Indirizzo</dt>
                <dd class="col-sm-9">{{ $client->address ?: 'Non specificato' }}</dd>

                <dt class="col-sm-3">Note</dt>
                <dd class="col-sm-9">{{ $client->notes ?: 'Nessuna nota' }}</dd>

                <dt class="col-sm-3">Creato il</dt>
                <dd class="col-sm-9">{{ $client->created_at->format('d/m/Y H:i') }}</dd>

                <dt class="col-sm-3">Modificato il</dt>
                <dd class="col-sm-9">{{ $client->updated_at->format('d/m/Y H:i') }}</dd>
            </dl>
        </div>
        <div class="card-footer">
            <button class="btn btn-info" data-bs-toggle="modal" data-bs-target="#editClientModal{{ $client->id }}">
                <i class="fas fa-edit me-1"></i> Modifica
            </button>
            <form action="{{ route('clients.destroy', $client) }}" method="POST" class="d-inline">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Sei sicuro di voler eliminare questo cliente?')">
                    <i class="fas fa-trash me-1"></i> Elimina
                </button>
            </form>
        </div>
    </div>
</div>

<!-- Edit Client Modal -->
<div class="modal fade" id="editClientModal{{ $client->id }}" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Modifica Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('clients.update', $client) }}" method="POST">
                <div class="modal-body">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $client->name }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $client->email }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Telefono</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $client->phone }}">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Indirizzo</label>
                        <textarea class="form-control" id="address" name="address" rows="2">{{ $client->address }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Note</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3">{{ $client->notes }}</textarea>
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