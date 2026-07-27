<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    private function roles(): array
    {
        return User::roles();
    }

    private function departments(): array
    {
        return [
            'Administration',
            'Construction',
            'Inventory',
            'Finance',
            'Human Resources',
            'Production',
            'Maintenance',
            'Sales',
            'Support',
        ];
    }

    public function index(Request $request)
    {
        $users = User::query()
            ->when($request->search, function ($query, $search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('mobile', 'like', "%{$search}%");
                });
            })
            ->when($request->role, function ($query, $role) {
                $query->where('role', $role);
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.users.index', [
            'users' => $users,
            'roles' => $this->roles(),
        ]);
    }

    public function create()
    {
        return view('admin.users.create', [
            'roles' => $this->roles(),
            'departments' => $this->departments(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'not_in:nan,NaN,NAN,null,NULL,undefined,N/A,n/a'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'mobile' => ['nullable', 'string', 'max:20'],
            'password' => ['required', 'confirmed', 'min:8'],
            'role' => ['required', Rule::in(array_keys($this->roles()))],
            'department' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'address' => ['nullable', 'string'],
            'remarks' => ['nullable', 'string'],
        ]);

        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')
                ->store('users', 'public');
        }

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User created successfully.');
    }

    public function edit(User $user)
    {
        return view('admin.users.edit', [
            'user' => $user,
            'roles' => $this->roles(),
            'departments' => $this->departments(),
        ]);
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'not_in:nan,NaN,NAN,null,NULL,undefined,N/A,n/a'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'mobile' => ['nullable', 'string', 'max:20'],
            'password' => ['nullable', 'confirmed', 'min:8'],
            'role' => ['required', Rule::in(array_keys($this->roles()))],
            'department' => ['nullable', 'string', 'max:255'],
            'status' => ['required', Rule::in(['active', 'inactive'])],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'address' => ['nullable', 'string'],
            'remarks' => ['nullable', 'string'],
        ]);

        if ($request->hasFile('photo')) {
            if ($user->photo) {
                \Storage::disk('public')->delete($user->photo);
            }

            $validated['photo'] = $request->file('photo')
                ->store('users', 'public');
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User updated successfully.');
    }

    public function destroy(User $user)
    {
        if (auth()->id() === $user->id) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        if ($user->photo) {
            \Storage::disk('public')->delete($user->photo);
        }

        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', 'User deleted successfully.');
    }
}