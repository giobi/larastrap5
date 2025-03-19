<div>
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>{{ __('users.user_list') }}</h1>
        <button wire:click="create" class="btn btn-primary">
            {{ __('users.create_user') }}
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <div class="mb-3">
                <input type="text" class="form-control" placeholder="{{ __('users.search') }}"
                       wire:model.live="search">
            </div>

            @if($isEditing || !$editingUserId)
                <form wire:submit="save">
                    <div class="mb-3">
                        <label for="first_name" class="form-label">{{ __('auth.first_name') }}</label>
                        <input type="text" class="form-control @error('first_name') is-invalid @enderror" 
                               id="first_name" wire:model="first_name">
                        @error('first_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="last_name" class="form-label">{{ __('auth.last_name') }}</label>
                        <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                               id="last_name" wire:model="last_name">
                        @error('last_name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('auth.email') }}</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" 
                               id="email" wire:model="email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('auth.password') }}</label>
                        <input type="password" class="form-control @error('password') is-invalid @enderror" 
                               id="password" wire:model="password">
                        @if($isEditing)
                            <small class="form-text text-muted">
                                {{ __('users.leave_blank_to_keep_current_password') }}
                            </small>
                        @endif
                        @error('password')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="password_confirmation" class="form-label">{{ __('auth.confirm_password') }}</label>
                        <input type="password" class="form-control" 
                               id="password_confirmation" wire:model="password_confirmation">
                    </div>

                    <div class="d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary" wire:click="$set('isEditing', false)">
                            {{ __('users.cancel') }}
                        </button>
                        <button type="submit" class="btn btn-primary">
                            {{ __('users.save') }}
                        </button>
                    </div>
                </form>
            @endif
        </div>
    </div>

    <div class="card">
        <div class="card-body">
            @if($users->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>{{ __('auth.first_name') }}</th>
                                <th>{{ __('auth.last_name') }}</th>
                                <th>{{ __('auth.email') }}</th>
                                <th>{{ __('users.created_at') }}</th>
                                <th>{{ __('users.actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($users as $user)
                                <tr>
                                    <td>{{ $user->first_name }}</td>
                                    <td>{{ $user->last_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <button wire:click="edit({{ $user->id }})" 
                                                    class="btn btn-sm btn-primary">
                                                {{ __('users.edit') }}
                                            </button>
                                            @if($user->id !== auth()->id())
                                                <button wire:click="delete({{ $user->id }})"
                                                        wire:confirm="{{ __('users.confirm_delete') }}"
                                                        class="btn btn-sm btn-danger">
                                                    {{ __('users.delete') }}
                                                </button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $users->links() }}
                </div>
            @else
                <p class="text-center mb-0">{{ __('users.no_users_found') }}</p>
            @endif
        </div>
    </div>
</div> 