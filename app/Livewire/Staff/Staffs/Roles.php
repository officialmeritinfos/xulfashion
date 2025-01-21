<?php

namespace App\Livewire\Staff\Staffs;

use App\Models\SystemStaff;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Roles extends Component
{
    use LivewireAlert,WithPagination;


    public $newRoleName;
    public $selectedRoleId;
    public $selectedPermissions = [];

    #[Url]
    public $perPage=5;
    #[Url]
    public $search;


    public $showAddRole=false;
    public $showEditRole=false;

    public $selectedRole;

    public $staff;

    protected $listeners = [
        'deleteRole'
    ];

    public function mount()
    {
        $this->staff = Auth::guard('staff')->user();
    }

    public function placeholder()
    {
        return <<<'HTML'
        <div>
            <!-- Loading spinner... -->
           <svg width="100%" height="400px" viewBox="0 0 400 400" preserveAspectRatio="none">
                <defs>
                    <linearGradient id="skeleton-gradient">
                        <stop offset="0%" stop-color="#f0f0f0">
                            <animate attributeName="offset" values="-2; 1" dur="1.5s" repeatCount="indefinite" />
                        </stop>
                        <stop offset="50%" stop-color="#e0e0e0">
                            <animate attributeName="offset" values="-1.5; 1.5" dur="1.5s" repeatCount="indefinite" />
                        </stop>
                        <stop offset="100%" stop-color="#f0f0f0">
                            <animate attributeName="offset" values="-1; 2" dur="1.5s" repeatCount="indefinite" />
                        </stop>
                    </linearGradient>
                </defs>

                <!-- Card Placeholder 1 -->
                <rect x="10" y="10" rx="10" ry="10" width="380" height="100" fill="url(#skeleton-gradient)" />
                <rect x="20" y="25" rx="5" ry="5" width="340" height="20" fill="url(#skeleton-gradient)" />
                <rect x="20" y="55" rx="5" ry="5" width="300" height="15" fill="url(#skeleton-gradient)" />
                <rect x="20" y="75" rx="5" ry="5" width="250" height="15" fill="url(#skeleton-gradient)" />

                <!-- Card Placeholder 2 -->
                <rect x="10" y="130" rx="10" ry="10" width="380" height="100" fill="url(#skeleton-gradient)" />
                <rect x="20" y="145" rx="5" ry="5" width="340" height="20" fill="url(#skeleton-gradient)" />
                <rect x="20" y="175" rx="5" ry="5" width="300" height="15" fill="url(#skeleton-gradient)" />
                <rect x="20" y="195" rx="5" ry="5" width="250" height="15" fill="url(#skeleton-gradient)" />

                <!-- Card Placeholder 3 -->
                <rect x="10" y="250" rx="10" ry="10" width="380" height="100" fill="url(#skeleton-gradient)" />
                <rect x="20" y="265" rx="5" ry="5" width="340" height="20" fill="url(#skeleton-gradient)" />
                <rect x="20" y="295" rx="5" ry="5" width="300" height="15" fill="url(#skeleton-gradient)" />
                <rect x="20" y="315" rx="5" ry="5" width="250" height="15" fill="url(#skeleton-gradient)" />
            </svg>
        </div>
        HTML;
    }

    public function render()
    {
        return view('livewire.staff.staffs.roles',[
            'roles' => Role::with('permissions')->when($this->search,function ($query){
                $query->where('name','like','%'.$this->search.'%');
            }) ->paginate($this->perPage),
            'permissions' => Permission::all(),
        ]);
    }

    public function createRole()
    {
        $this->validate([
            'newRoleName' => 'required|unique:roles,name',
            'selectedPermissions' => 'required|array|min:1',
            'selectedPermissions.*' => 'exists:permissions,name',
        ]);
        DB::beginTransaction();
        try {
            // Create the role
            $role = Role::create(['name' => $this->newRoleName, 'guard_name' => 'staff']);
            // Assign permissions to the role
            if (!empty($this->selectedPermissions)) {
                $role->syncPermissions($this->selectedPermissions);
            }

            DB::commit();
            // Provide success feedback
            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Role and permissions added successfully',
                'width' => '400',
            ]);

            // Reset the form and refresh data
            $this->resetForm();
        }catch (\Exception $exception){
            DB::rollBack();
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred: '.$exception->getMessage(),
                'width' => '400',
            ]);
        }
    }

    public function addNewRole()
    {
       $this->showAddRole = true;
       $this->showEditRole = false;
    }


    public function updatePermissions()
    {
        // Fetch the role based on the selectedRoleId
        $role = Role::find($this->selectedRoleId);

        // Check if the role exists
        if (!$role) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Role not found',
                'width' => '400',
            ]);
            return;
        }

        // Ensure the staff has permission to update roles
        if (!$this->staff || !$this->staff->can('update SuperAdmin')) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to assign roles',
                'width' => '400',
            ]);
            return;
        }

        // Synchronize permissions with the selected ones
        if (!empty($this->selectedPermissions)) {
            $role->syncPermissions($this->selectedPermissions);
        }

        // Update the role name if it has changed
        if ($role->name !== $this->newRoleName) {
            $oldRoleName = $role->name; // Store the old name for reference
            $role->name = $this->newRoleName;
            $role->save();

            // Update the role name for staff members with the old role
            $staffWithFormerRoles = SystemStaff::where('role', $oldRoleName)->get();
            foreach ($staffWithFormerRoles as $staffWithFormerRole) {
                $staffWithFormerRole->update(['role' => $this->newRoleName]);
                $staffWithFormerRole->syncRoles($role);
            }
        }

        // Display success message
        $this->alert('success', '', [
            'position' => 'top-end',
            'timer' => 5000,
            'toast' => true,
            'text' => 'Permissions updated successfully',
            'width' => '400',
        ]);

        // Reset the form inputs
        $this->resetForm();
    }

    public function editRole($roleId)
    {
        $role = Role::with('permissions')->find($roleId);
        if (!$role){
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Role not found',
                'width' => '400'
            ]);
            return;
        }

        if (!$this->staff->can('update SuperAdmin')) {
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'You do not have permission to assign roles',
                'width' => '400',
            ]);
            return;
        }

        $this->selectedRoleId = $role->id;
        $this->newRoleName = $role->name;
        $this->selectedPermissions = $role->permissions->pluck('name')->toArray();
        $this->showAddRole=false;
        $this->showEditRole = true;

        return;
    }


    public function resetForm()
    {
        $this->selectedRoleId = null;
        $this->newRoleName = '';
        $this->selectedPermissions = [];
        $this->showEditRole = false;
        $this->showAddRole = false;
    }
    //delete role
    public function deleteARole($id)
    {
        try {

            $role = Role::findOrFail($id);

            //open a dialog to confirm action
            $this->alert('warning', '', [
                'text' => 'Do you want to delete ' . $role->name,
                'showConfirmButton' => true,
                'confirmButtonText' => 'Yes',
                'showCancelButton' => true,
                'cancelButtonText' => 'Cancel',
                'onConfirmed' => 'deleteRole',
                'data' => [
                    'id' => $id
                ],
                'timer' => null
            ]);
        } catch (\Exception $exception) {
            Log::info('An error occurred while trying to delete an ad');
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred while creating an ad for merchant.s',
                'width' => '400',
            ]);
            return;
        }
    }
    //confirmed delete role
    public function deleteRole($data)
    {
        try {
            $roleId = $data['id'] ?? null;
            // Find the role by its ID
            $role = Role::findOrFail($roleId);

            // Detach all permissions assigned to the role
            $role->permissions()->detach();

            // Delete the role
            $role->delete();

            // Provide success feedback
            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Role and its permissions have been deleted successfully',
                'width' => '400',
            ]);
        } catch (\Exception $e) {
            // Handle errors gracefully
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred: ' . $e->getMessage(),
                'width' => '400',
            ]);
        }
    }
}
