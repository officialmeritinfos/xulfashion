<?php

namespace App\Livewire\Staff\Staffs;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class Permissions extends Component
{
    use WithPagination;

    public $staff;

    public $newPermissionName;

    public $showAddPermission=false;

    #[Url]
    public $search;
    #[Url]
    public  $perPage=10;
    public $permissions;

    public function mount()
    {
        $this->staff = Auth::user();
        $this->fetchGroupedPermissions();
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
        $groupedPermissions = $this->fetchGroupedPermissions();

        // Extract models (keys of the grouped permissions array)
        $models = array_keys($groupedPermissions);

        $currentPage = $this->getPage();

        // Paginate the models using Livewire's pagination
        $paginatedModels = collect($models)->forPage($currentPage, $this->perPage);

        // Filter grouped permissions to include only paginated models
        $paginatedGroupedPermissions = array_intersect_key($groupedPermissions, array_flip($paginatedModels->toArray()));



        return view('livewire.staff.staffs.permissions',[
            'groupedPermissions' => $paginatedGroupedPermissions,
            'totalPages' => ceil(count($models) / $this->perPage)
        ]);
    }

    public function updatedSearch()
    {
        $this->fetchGroupedPermissions();
    }
    public function updatingSearch()
    {
        $this->resetPage();
    }


    public function fetchGroupedPermissions()
    {
        $permissions = Permission::query()
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })->orderBy("created_at", "DESC")
            ->get();

        $grouped = [];

        foreach ($permissions as $permission) {
            // Extract the model and action from the permission name
            [$action, $model] = explode(' ', $permission->name, 2);

            if (!isset($grouped[$model])) {
                $grouped[$model] = [
                    'actions' => [],
                ];
            }

            $roles = Role::whereHas('permissions', function ($query) use ($permission) {
                $query->where('id', $permission->id);
            })->pluck('name')->toArray();

            $grouped[$model]['actions'][$action] = $roles;
        }

        return $grouped;
    }

    public function addPermission()
    {
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

        // Validate the input
        $this->validate([
            'newPermissionName' => 'required|string|max:255|unique:permissions,name',
        ]);

        //actions
        $actions = ['read', 'create', 'update', 'delete'];

        try {
            // Create the new permission
            foreach ($actions as $action) {
                $permissionName = "{$action} {$this->newPermissionName}";

                // Check if the permission already exists
                if (!Permission::where('name', $permissionName)->exists()) {
                    // Create the permission
                    Permission::create([
                        'name' => $permissionName,
                        'guard_name' => 'staff',
                    ]);
                }
            }

            // Provide success feedback
            $this->alert('success', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'Permission added successfully',
                'width' => '400',
            ]);

            // Reset the input field
            $this->newPermissionName = '';

            $this->resetForm();
        } catch (\Exception $e) {
            // Handle errors
            $this->alert('error', '', [
                'position' => 'top-end',
                'timer' => 5000,
                'toast' => true,
                'text' => 'An error occurred: ' . $e->getMessage(),
                'width' => '400',
            ]);
        }
    }
    public function addNewPermission()
    {
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

        $this->showAddPermission = true;
    }
    public function resetForm()
    {
        $this->showAddPermission = false;
        $this->newPermissionName = '';
    }
}
