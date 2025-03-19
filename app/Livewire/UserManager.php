<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class UserManager extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $password = '';
    public $password_confirmation = '';
    public $editingUserId = null;
    public $isEditing = false;
    public $search = '';

    protected $rules = [
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|confirmed',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function create()
    {
        $this->resetValidation();
        $this->reset(['first_name', 'last_name', 'email', 'password', 'password_confirmation', 'editingUserId']);
        $this->isEditing = false;
    }

    public function save()
    {
        if ($this->editingUserId) {
            $this->update();
        } else {
            $this->store();
        }
    }

    public function store()
    {
        $this->validate();

        User::create([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
        ]);

        $this->reset();
        session()->flash('success', __('users.created_successfully'));
    }

    public function edit(User $user)
    {
        $this->editingUserId = $user->id;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->isEditing = true;
        $this->resetValidation();

        $this->rules['email'] = 'required|email|max:255|unique:users,email,' . $user->id;
        $this->rules['password'] = 'nullable|confirmed';
    }

    public function update()
    {
        $this->validate();

        $user = User::find($this->editingUserId);
        
        $data = [
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
        ];

        if ($this->password) {
            $data['password'] = Hash::make($this->password);
        }

        $user->update($data);

        $this->reset();
        session()->flash('success', __('users.updated_successfully'));
    }

    public function delete(User $user)
    {
        if ($user->id === auth()->id()) {
            session()->flash('error', __('users.cannot_delete_self'));
            return;
        }

        $user->delete();
        session()->flash('success', __('users.deleted_successfully'));
    }

    public function render()
    {
        $users = User::where(function($query) {
            $query->where('first_name', 'like', '%' . $this->search . '%')
                  ->orWhere('last_name', 'like', '%' . $this->search . '%')
                  ->orWhere('email', 'like', '%' . $this->search . '%');
        })->latest()->paginate(10);

        return view('livewire.user-manager', [
            'users' => $users
        ]);
    }
} 