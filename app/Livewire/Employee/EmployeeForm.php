<?php

namespace App\Livewire\Employee;

use App\Models\Employee;
use App\Models\Position;
use Hash;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Spatie\Permission\Models\Role;
use Str;
use App\Models\User;
use Livewire\Attributes\On;

class EmployeeForm extends Component
{
    use LivewireAlert;
    public $employee;
    public $roles;
    public $positions;

    public $name,
        $username,
        $email,
        $password,
        $role,
        $position_id,
        $citizen_id,
        $leave_remaining,
        $join_date,
        $birth_date,
        $place_of_birth,
        $gender,
        $marital_status,
        $religion,
        $status = true; // Status aktif/tidak aktif

    public $user;
    public $type = 'create';

    public function mount($id = null)
    {
        $this->positions = Position::with('department.site')->get();
        $this->roles = Role::all();
        if ($id) {
            $this->employee = Employee::find($id);
            $this->user = $this->employee->user;

            $this->name = $this->user->name;
            $this->username = $this->user->username;
            $this->email = $this->user->email;
            $this->role = $this->user->getRoleNames()->first();
            $this->type = 'update';

            $this->citizen_id = $this->employee->citizen_id;
            $this->leave_remaining = $this->employee->leave_remaining;
            $this->join_date = $this->employee->join_date;
            $this->birth_date = $this->employee->birth_date;
            $this->place_of_birth = $this->employee->place_of_birth;
            $this->gender = $this->employee->gender;
            $this->marital_status = $this->employee->marital_status;
            $this->religion = $this->employee->religion;
            $this->position_id = $this->employee->position->id ?? null;
            $this->status = $this->user->status ?? true;

            $this->dispatch('change-select-form');
        }
    }

    public function save()
    {
        try {
            $rules = [
                'name' => 'required|string|max:255',
                'username' => 'required|string|max:255|unique:users,username,' . ($this->user->id ?? 'NULL'),
                'email' => 'required|email|max:255|unique:users,email,' . ($this->user->id ?? 'NULL'),
                'role' => 'required|exists:roles,name',
                'position_id' => 'nullable|exists:positions,id',
                'citizen_id' => 'nullable|string|max:255',
                'join_date' => 'nullable|date',
                'birth_date' => 'nullable|date',
                'place_of_birth' => 'nullable|string|max:255',
                'gender' => 'nullable|in:male,female',
                'marital_status' => 'nullable|string|max:255',
                'religion' => 'nullable|string|max:255',
            ];

            // Password wajib saat create, opsional saat update
            if ($this->type == 'create') {
                $rules['password'] = 'required|string|min:6';
            } else {
                $rules['password'] = 'nullable|string|min:6';
            }

            $this->validate($rules);

            // Convert status to boolean (after validation)
            $statusValue = $this->status === '1' || $this->status === 1 || $this->status === true;

            if ($this->type == 'create') {
                $this->user = User::create([
                    'username' => $this->username,
                    'name' => $this->name,
                    'email' => $this->email,
                    'password' => Hash::make($this->password),
                    'password_string' => $this->password,
                    'status' => $statusValue,
                ]);

                $this->user->employee()->create([
                    'id' => date('YmdH') . $this->user->id,
                    'leave_remaining' => $this->leave_remaining ?? 0,
                    'citizen_id' => $this->citizen_id,
                    'join_date' => $this->join_date,
                    'birth_date' => $this->birth_date,
                    'place_of_birth' => $this->place_of_birth,
                    'gender' => $this->gender,
                    'marital_status' => $this->marital_status,
                    'religion' => $this->religion,
                    'position_id' => $this->position_id,
                ]);

                $this->user->assignRole($this->role);
            } else {
                $updateData = [
                    'username' => $this->username,
                    'name' => $this->name,
                    'email' => $this->email,
                    'status' => $statusValue,
                ];
                
                // Update password only if provided
                if ($this->password) {
                    $updateData['password'] = Hash::make($this->password);
                    $updateData['password_string'] = $this->password;
                }
                
                $this->user->update($updateData);

                $this->employee->update([
                    'citizen_id' => $this->citizen_id,
                    'join_date' => $this->join_date,
                    'birth_date' => $this->birth_date,
                    'place_of_birth' => $this->place_of_birth,
                    'gender' => $this->gender,
                    'marital_status' => $this->marital_status,
                    'religion' => $this->religion,
                    'leave_remaining' => $this->leave_remaining,
                    'position_id' => $this->position_id,
                ]);

                $this->user->assignRole($this->role);
            }

            $this->alert('success', 'Employee ' . $this->type . ' successfully');
            return redirect()->route('employee.index');
        } catch (\Exception $e) {
            $this->alert('error', $e->getMessage());
        }
    }

    #[On('changeSelectForm')]
    public function changeSelectForm($param, $value)
    {
        $this->$param = $value;
    }

    public function render()
    {
        return view('livewire.employee.employee-form')->layout('layouts.app', ['title' => 'Employee']);
    }
}
