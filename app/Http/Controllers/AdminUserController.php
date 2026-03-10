<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminUserController extends Controller
{
    public function index(Request $request)
    {
        $user         = $this->ensureAdmin();
        $isSuperAdmin = $this->isSuperAdmin($user);

        $query = User::query()->whereIn('role', [User::ROLE_PETUGAS, User::ROLE_ADMIN]);

        // Jika bukan super admin, hanya boleh melihat petugas user
        if (! $isSuperAdmin) {
            $query->where('role', User::ROLE_PETUGAS);
        }

        $search = trim((string) $request->query('q', ''));
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $roleFilter = $request->query('role');
        $allowedRoles = [User::ROLE_PETUGAS, User::ROLE_ADMIN];
        $activeRoleFilter = null;

        if ($roleFilter && in_array($roleFilter, $allowedRoles, true)) {
            // Petugas admin hanya boleh memfilter petugas user
            if ($isSuperAdmin || $roleFilter === User::ROLE_PETUGAS) {
                $query->where('role', $roleFilter);
                $activeRoleFilter = $roleFilter;
            }
        }

        $accounts = $query
            ->orderBy('name')
            ->paginate(20)
            ->appends([
                'q'    => $search !== '' ? $search : null,
                'role' => $activeRoleFilter,
            ]);

        return view('dashboard.admin-users.index', [
            'user'            => $user,
            'accounts'        => $accounts,
            'isSuperAdmin'    => $isSuperAdmin,
            'search'          => $search,
            'activeRoleFilter'=> $activeRoleFilter,
        ]);
    }

    public function create()
    {
        $user = $this->ensureAdmin();
        $isSuperAdmin = $this->isSuperAdmin($user);
        return view('dashboard.admin-users.create', compact('user', 'isSuperAdmin'));
    }

    public function store(Request $request)
    {
        $user = $this->ensureAdmin();
        $data = $this->validateData($request, null, $user);

        User::create([
            'name'        => $data['name'],
            'email'       => $data['email'],
            'password'    => Hash::make($data['password']),
            'role'        => $data['role'],
            'is_active'   => true,
            'status_kerja'=> User::STATUS_AKTIF,
        ]);

        return redirect()->route('dashboard.admin-users.index')
            ->with('success', 'Akun berhasil dibuat.');
    }

    public function edit(User $admin_user)
    {
        $user = $this->ensureAdmin();

        // Hanya super admin yang boleh mengelola akun admin
        if (
            ! in_array($admin_user->role, [User::ROLE_PETUGAS, User::ROLE_ADMIN]) ||
            ($admin_user->role === User::ROLE_ADMIN && ! $this->isSuperAdmin($user))
        ) {
            abort(404);
        }

        $isSuperAdmin = $this->isSuperAdmin($user);
        return view('dashboard.admin-users.edit', [
            'user'          => $user,
            'account'       => $admin_user,
            'isSuperAdmin'  => $isSuperAdmin,
        ]);
    }

    public function update(Request $request, User $admin_user)
    {
        $user = $this->ensureAdmin();

        if (
            ! in_array($admin_user->role, [User::ROLE_PETUGAS, User::ROLE_ADMIN]) ||
            ($admin_user->role === User::ROLE_ADMIN && ! $this->isSuperAdmin($user))
        ) {
            abort(404);
        }

        $data = $this->validateData($request, $admin_user, $user);

        $admin_user->name  = $data['name'];
        $admin_user->email = $data['email'];
        $admin_user->role  = $data['role'];
        if (! empty($data['password'])) {
            $admin_user->password = Hash::make($data['password']);
        }
        $admin_user->save();

        return redirect()->route('dashboard.admin-users.index')
            ->with('success', 'Akun berhasil diperbarui.');
    }

    public function updateProfile(Request $request, User $admin_user)
    {
        $user = $this->ensureAdmin();

        if (
            ! in_array($admin_user->role, [User::ROLE_PETUGAS, User::ROLE_ADMIN]) ||
            ($admin_user->role === User::ROLE_ADMIN && ! $this->isSuperAdmin($user))
        ) {
            abort(404);
        }

        $data = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($admin_user->id),
            ],
        ]);

        $admin_user->name  = $data['name'];
        $admin_user->email = $data['email'];
        $admin_user->save();

        return redirect()->route('dashboard.admin-users.edit', $admin_user)
            ->with('success', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request, User $admin_user)
    {
        $user = $this->ensureAdmin();

        if (
            ! in_array($admin_user->role, [User::ROLE_PETUGAS, User::ROLE_ADMIN]) ||
            ($admin_user->role === User::ROLE_ADMIN && ! $this->isSuperAdmin($user))
        ) {
            abort(404);
        }

        $data = $request->validate([
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $admin_user->password = Hash::make($data['password']);
        $admin_user->save();

        return redirect()->route('dashboard.admin-users.edit', $admin_user)
            ->with('success', 'Password berhasil diubah.');
    }

    public function updateRole(Request $request, User $admin_user)
    {
        $user = $this->ensureAdmin();

        if (
            ! in_array($admin_user->role, [User::ROLE_PETUGAS, User::ROLE_ADMIN]) ||
            ($admin_user->role === User::ROLE_ADMIN && ! $this->isSuperAdmin($user))
        ) {
            abort(404);
        }

        $allowedRoles = $this->isSuperAdmin($user)
            ? [User::ROLE_PETUGAS, User::ROLE_ADMIN]
            : [User::ROLE_PETUGAS];

        $data = $request->validate([
            'role' => ['required', Rule::in($allowedRoles)],
        ]);

        $admin_user->role = $data['role'];
        $admin_user->save();

        return redirect()->route('dashboard.admin-users.edit', $admin_user)
            ->with('success', 'Role berhasil diperbarui.');
    }

    public function destroy(User $admin_user)
    {
        $user = $this->ensureAdmin();

        if (
            ! in_array($admin_user->role, [User::ROLE_PETUGAS, User::ROLE_ADMIN]) ||
            ($admin_user->role === User::ROLE_ADMIN && ! $this->isSuperAdmin($user))
        ) {
            abort(404);
        }

        if ($admin_user->id === $user->id) {
            return redirect()->route('dashboard.admin-users.index')
                ->with('error', 'Anda tidak dapat menghapus akun Anda sendiri.');
        }

        $admin_user->delete();

        return redirect()->route('dashboard.admin-users.index')
            ->with('success', 'Akun berhasil dihapus.');
    }

    private function validateData(Request $request, ?User $target = null, ?User $currentUser = null): array
    {
        $currentUser ??= Auth::user();

        $rules = [
            'name'  => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($target?->id),
            ],
        ];

        // Penentuan role yang diperbolehkan
        if ($this->isSuperAdmin($currentUser)) {
            $rules['role'] = ['required', Rule::in([User::ROLE_PETUGAS, User::ROLE_ADMIN])];
        } else {
            // Petugas admin hanya boleh mengelola petugas user
            $rules['role'] = ['required', Rule::in([User::ROLE_PETUGAS])];
        }

        if ($target) {
            $rules['password'] = ['nullable', 'string', 'min:8', 'confirmed'];
        } else {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        }

        return $request->validate($rules);
    }

    private function ensureAdmin(): User
    {
        $user = Auth::user();
        if (! $user || ! $user->isAdmin()) {
            abort(403);
        }
        return $user;
    }

    private function isSuperAdmin(User $user): bool
    {
        return $user->email === 'admin@gmail.com';
    }
}

