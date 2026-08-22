<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $doctors = User::with('doctor')->whereHas('doctor')->get()->map(function ($u) {
            return [
                'id' => 'U' . str_pad($u->user_id, 5, '0', STR_PAD_LEFT),
                'name' => $u->name,
                'email' => $u->email,
                'status' => $u->active ? 'Active' : 'Inactive',
                'role' => 'Doctor',
            ];
        });

        $nurses = User::with('nurse')->whereHas('nurse')->get()->map(function ($u) {
            return [
                'id' => 'U' . str_pad($u->user_id, 5, '0', STR_PAD_LEFT),
                'name' => $u->name,
                'email' => $u->email,
                'status' => $u->active ? 'Active' : 'Inactive',
                'role' => 'Nurse',
            ];
        });

        $visitors = User::with('visitor')->whereHas('visitor')->get()->map(function ($u) {
            return [
                'id' => 'U' . str_pad($u->user_id, 5, '0', STR_PAD_LEFT),
                'name' => $u->name,
                'email' => $u->email,
                'status' => $u->active ? 'Active' : 'Inactive',
                'role' => 'Visitor',
            ];
        });

        $admins = Admin::all()->map(function ($a) {
            return [
                'id' => 'A' . str_pad($a->admin_id, 5, '0', STR_PAD_LEFT),
                'name' => $a->name,
                'email' => $a->email,
                'status' => $a->active ? 'Active' : 'Inactive',
                'role' => 'Administrator',
            ];
        });

        $users = collect()
            ->merge($doctors)
            ->merge($nurses)
            ->merge($visitors)
            ->merge($admins)
            ->sortBy('name')
            ->values();

        if ($search = $request->input('search')) {
            $search = mb_strtolower($search);
            $users = $users->filter(function ($u) use ($search) {
                return str_contains(mb_strtolower($u['name']), $search)
                    || str_contains(mb_strtolower($u['id']), $search)
                    || str_contains(mb_strtolower($u['email']), $search);
            });
        }

        if ($status = $request->input('status')) {
            $users = $users->filter(fn ($u) => strtolower($u['status']) === strtolower($status));
        }

        if ($role = $request->input('role')) {
            $users = $users->filter(fn ($u) => $u['role'] === $role);
        }

        $users = $users->values();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'role' => 'required|in:Doctor,Nurse,Visitor,Administrator',
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'email' => 'required|email|max:150|unique:users,email|unique:admin,email',
            'password' => 'required|string|min:8|confirmed',
            'active' => 'nullable|boolean',

            'doctor_license_number' => 'required_if:role,Doctor|nullable|string|max:50|unique:doctor,license_number',
            'doctor_specialty' => 'nullable|string|max:100',
            'doctor_institution' => 'nullable|string|max:150',

            'nurse_license_number' => 'required_if:role,Nurse|nullable|string|max:50|unique:nurse,license_number',
            'nurse_department' => 'nullable|string|max:100',
        ]);

        DB::transaction(function () use ($data, $request) {
            $active = $request->boolean('active', true);

            if ($data['role'] === 'Administrator') {
                Admin::create([
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'email' => $data['email'],
                    'password' => Hash::make($data['password']),
                    'active' => $active,
                ]);
                return;
            }

            $user = User::create([
                'first_name' => $data['first_name'],
                'last_name' => $data['last_name'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'active' => $active,
            ]);

            switch ($data['role']) {
                case 'Doctor':
                    Doctor::create([
                        'user_id' => $user->user_id,
                        'license_number' => $data['doctor_license_number'],
                        'specialty' => $data['doctor_specialty'] ?? null,
                        'institution' => $data['doctor_institution'] ?? null,
                    ]);
                    break;

                case 'Nurse':
                    Nurse::create([
                        'user_id' => $user->user_id,
                        'license_number' => $data['nurse_license_number'],
                        'department' => $data['nurse_department'] ?? null,
                    ]);
                    break;

                case 'Visitor':
                    Visitor::create([
                        'user_id' => $user->user_id,
                    ]);
                    break;
            }
        });

        return redirect()->route('users.index')->with('success', 'User created.');
    }

    /**
     * Resolve a display ID like "U00005" or "A00002" into
     * ['type' => 'user'|'admin', 'pk' => int].
     */
    private function resolveId(string $id): array
    {
        $prefix = strtoupper(substr($id, 0, 1));
        $pk = (int) ltrim(substr($id, 1), '0');

        return [
            'type' => $prefix === 'A' ? 'admin' : 'user',
            'pk' => $pk,
        ];
    }

    public function show(string $id)
    {
        $resolved = $this->resolveId($id);

        if ($resolved['type'] === 'admin') {
            $admin = Admin::findOrFail($resolved['pk']);

            $user = [
                'id' => $id,
                'name' => $admin->name,
                'email' => $admin->email,
                'status' => $admin->active ? 'Active' : 'Inactive',
                'role' => 'Administrator',
            ];
        } else {
            $u = User::with(['doctor', 'nurse', 'visitor'])->findOrFail($resolved['pk']);

            $role = 'Visitor';
            $extra = [];

            if ($u->doctor) {
                $role = 'Doctor';
                $extra = [
                    'License Number' => $u->doctor->license_number,
                    'Specialty' => $u->doctor->specialty,
                    'Institution' => $u->doctor->institution,
                ];
            } elseif ($u->nurse) {
                $role = 'Nurse';
                $extra = [
                    'License Number' => $u->nurse->license_number,
                    'Department' => $u->nurse->department,
                ];
            }

            $user = [
                'id' => $id,
                'name' => $u->name,
                'email' => $u->email,
                'status' => $u->active ? 'Active' : 'Inactive',
                'role' => $role,
                'extra' => $extra,
            ];
        }

        return view('users.show', compact('user'));
    }

    public function edit(string $id)
    {
        $resolved = $this->resolveId($id);

        if ($resolved['type'] === 'admin') {
            $admin = Admin::findOrFail($resolved['pk']);

            $user = [
                'id' => $id,
                'type' => 'admin',
                'first_name' => $admin->first_name,
                'last_name' => $admin->last_name,
                'email' => $admin->email,
                'active' => $admin->active,
                'role' => 'Administrator',
            ];
        } else {
            $u = User::with(['doctor', 'nurse'])->findOrFail($resolved['pk']);

            $role = 'Visitor';
            if ($u->doctor) {
                $role = 'Doctor';
            } elseif ($u->nurse) {
                $role = 'Nurse';
            }

            $user = [
                'id' => $id,
                'type' => 'user',
                'first_name' => $u->first_name,
                'last_name' => $u->last_name,
                'email' => $u->email,
                'active' => $u->active,
                'role' => $role,
                'doctor_license_number' => $u->doctor->license_number ?? '',
                'doctor_specialty' => $u->doctor->specialty ?? '',
                'doctor_institution' => $u->doctor->institution ?? '',
                'nurse_license_number' => $u->nurse->license_number ?? '',
                'nurse_department' => $u->nurse->department ?? '',
            ];
        }

        return view('users.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $resolved = $this->resolveId($id);

        if ($resolved['type'] === 'admin') {
            $admin = Admin::findOrFail($resolved['pk']);

            $data = $request->validate([
                'first_name' => 'required|string|max:100',
                'last_name' => 'required|string|max:100',
                'email' => 'required|email|max:150|unique:admin,email,' . $admin->admin_id . ',admin_id',
                'password' => 'nullable|string|min:8|confirmed',
                'active' => 'nullable|boolean',
            ]);

            $admin->first_name = $data['first_name'];
            $admin->last_name = $data['last_name'];
            $admin->email = $data['email'];
            $admin->active = $request->boolean('active', true);

            if (!empty($data['password'])) {
                $admin->password = Hash::make($data['password']);
            }

            $admin->save();
        } else {
            $u = User::with(['doctor', 'nurse'])->findOrFail($resolved['pk']);

            $data = $request->validate([
                'first_name' => 'required|string|max:100',
                'last_name' => 'required|string|max:100',
                'email' => 'required|email|max:150|unique:users,email,' . $u->user_id . ',user_id',
                'password' => 'nullable|string|min:8|confirmed',
                'active' => 'nullable|boolean',
                'doctor_license_number' => 'nullable|string|max:50',
                'doctor_specialty' => 'nullable|string|max:100',
                'doctor_institution' => 'nullable|string|max:150',
                'nurse_license_number' => 'nullable|string|max:50',
                'nurse_department' => 'nullable|string|max:100',
            ]);

            $u->first_name = $data['first_name'];
            $u->last_name = $data['last_name'];
            $u->email = $data['email'];
            $u->active = $request->boolean('active', true);

            if (!empty($data['password'])) {
                $u->password = Hash::make($data['password']);
            }

            $u->save();

            if ($u->doctor) {
                $u->doctor->update([
                    'license_number' => $data['doctor_license_number'] ?? $u->doctor->license_number,
                    'specialty' => $data['doctor_specialty'] ?? null,
                    'institution' => $data['doctor_institution'] ?? null,
                ]);
            } elseif ($u->nurse) {
                $u->nurse->update([
                    'license_number' => $data['nurse_license_number'] ?? $u->nurse->license_number,
                    'department' => $data['nurse_department'] ?? null,
                ]);
            }
        }

        return redirect()->route('users.index')->with('success', 'User updated.');
    }

    public function destroy(string $id)
    {
        $resolved = $this->resolveId($id);

        if ($resolved['type'] === 'admin') {
            Admin::findOrFail($resolved['pk'])->delete();
        } else {
            User::findOrFail($resolved['pk'])->delete();
        }

        return redirect()->route('users.index')->with('success', 'User deleted.');
    }
}