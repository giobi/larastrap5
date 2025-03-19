@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>Clienti</h1>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createClientModal">
            <i class="fas fa-plus me-1"></i> Nuovo Cliente
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nome</th>
                            <th>Email</th>
                            <th>Telefono</th>
                            <th>Indirizzo</th>
                            <th>Azioni</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clients as $client)
                            <tr>
                                <td>{{ $client->name }}</td>
                                <td>{{ $client->email }}</td>
                                <td>{{ $client->phone }}</td>
                                <td>{{ Str::limit($client->address, 30) }}</td>
                                <td>
                                    <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#editClientModal{{ $client->id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#showClientModal{{ $client->id }}">
                                        <i class="fas fa-eye"></i>
                                    </button>
                                    <form action="{{ route('clients.destroy', $client) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Sei sicuro di voler eliminare questo cliente?')">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{ $clients->links() }}
        </div>
    </div>
</div>

<!-- Create Client Modal -->
<div class="modal fade" id="createClientModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nuovo Cliente</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="{{ route('clients.store') }}" method="POST">
                <div class="modal-body">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Nome</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="form-label">Telefono</label>
                        <input type="text" class="form-control" id="phone" name="phone">
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Indirizzo</label>
                        <textarea class="form-control" id="address" name="address" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">Note</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>
                    <button type="submit" class="btn btn-primary">Salva</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Client Modals -->
@foreach($clients as $client)
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
                            <label for="name{{ $client->id }}" class="form-label">Nome</label>
                            <input type="text" class="form-control" id="name{{ $client->id }}" name="name" value="{{ $client->name }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="email{{ $client->id }}" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email{{ $client->id }}" name="email" value="{{ $client->email }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="phone{{ $client->id }}" class="form-label">Telefono</label>
                            <input type="text" class="form-control" id="phone{{ $client->id }}" name="phone" value="{{ $client->phone }}">
                        </div>
                        <div class="mb-3">
                            <label for="address{{ $client->id }}" class="form-label">Indirizzo</label>
                            <textarea class="form-control" id="address{{ $client->id }}" name="address" rows="2">{{ $client->address }}</textarea>
                        </div>
                        <div class="mb-3">
                            <label for="notes{{ $client->id }}" class="form-label">Note</label>
                            <textarea class="form-control" id="notes{{ $client->id }}" name="notes" rows="3">{{ $client->notes }}</textarea>
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

    <!-- Show Client Modal -->
    <div class="modal fade" id="showClientModal{{ $client->id }}" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Dettagli Cliente</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
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
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Chiudi</button>
                </div>
            </div>
        </div>
    </div>
@endforeach
@endsection 