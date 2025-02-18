<div>

    @if(!$showAddRole && !$showEditRole)
        <div class="card h-100 p-0 radius-12">
            <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
                <div class="d-flex align-items-center flex-wrap gap-3">
                    <span class="text-md fw-medium text-secondary-light mb-0">Show</span>
                    <select class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px" wire:model.live="perPage">
                        <option>1</option>
                        <option>5</option>
                        <option>10</option>
                        <option>20</option>
                        <option>50</option>
                        <option>75</option>
                        <option>100</option>
                    </select>
                    <form class="navbar-search">
                        <input type="text" class="bg-base h-40-px w-auto" name="search" placeholder="Search" wire:model.live="search">
                        <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                    </form>
                </div>
                <div class="d-flex align-items-center flex-wrap gap-3">
                    <button type="button" class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2"  wire:click="addNewRole"
                            data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                        Add New Role
                    </button>
                    <div wire:loading wire:target="search,perPage,addNewRole, addNewPermission"
                         class="spinner-border text-primary" role="status" style="width: 1.5rem; height: 1.5rem;">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>

            <div class="card-body p-24">
                <div class="table-responsive">
                    <table class="table bordered-table sm-table mb-0">
                        <thead>
                        <tr>
                            <th scope="col">
                                <div class="d-flex align-items-center gap-10">
                                    S.L
                                </div>
                            </th>
                            <th>Role Name</th>
                            <th>Permissions</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($roles as $index => $role)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center gap-10">
                                        <div class="form-check style-check d-flex align-items-center">
                                            <input class="form-check-input radius-4 border border-neutral-400" type="checkbox" name="checkbox">
                                        </div>
                                        {{ $index+1 }}
                                    </div>
                                </td>
                                <td>{{ ucwords(str_replace('-',' ',$role->name)) }}</td>
                                <td>
                                    <div class="mb-3">
                                        <div class="permissions-list">
                                            <div class="mb-4">
                                                <div class="d-flex flex-wrap gap-2">

                                                    @foreach ($role->permissions as $permission)
                                                        <div class="form-check p-2 bg-primary text-white rounded border d-flex align-items-center gap-2"
                                                             style="min-width: 200px;">
                                                        <span class="form-check-label mb-0">
                                                            {{ $permission->name }}
                                                        </span>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-10 justify-content-center">
                                        <button  wire:click="editRole({{ $role->id }})"
                                                 class="btn btn-outline-primary fw-medium d-flex justify-content-center align-items-center "
                                        ><iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
                                            <span wire:loading.remove> Assign Permission</span>
                                            <span wire:loading>Please wait...</span>
                                        </button>
                                        <button  wire:click="deleteARole({{ $role->id }})"
                                                 class="btn btn-outline-danger fw-medium d-flex justify-content-center align-items-center "
                                        ><iconify-icon icon="lucide:trash" class="menu-icon"></iconify-icon>
                                            <span wire:loading.remove> Delete Role</span>
                                            <span wire:loading>Please wait...</span>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
                <div class="mt-5 ">
                    <div wire:loading wire:target="nextPage, previousPage, gotoPage" class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    {{ $roles->links() }}

                </div>
            </div>
        </div>
    @endif

    <!-- Edit Role -->
        @if($showEditRole)
            <div class="card">
                <div class="card-body">
                    <div class="card">
                        <div class="card-body">
                            <h6 class="text-md text-primary-light mb-16">Edit Role</h6>

                            <form wire:submit.prevent="updatePermissions">
                                <!-- Role Name -->
                                <div class="mb-3">
                                    <label for="roleName" class="form-label">Role Name</label>
                                    <input type="text" wire:model="newRoleName" id="roleName" class="form-control radius-8" placeholder="Enter Role Name">
                                    @error('newRoleName') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <!-- Permissions -->
                                <div class="mb-3">
                                    <label for="permissions" class="form-label">Assign Permissions</label>
                                    <div class="permissions-list">
                                        <div class="mb-4">
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach ($permissions as $permission)
                                                    <div class="form-check p-2 bg-cream-dark text-white rounded border d-flex align-items-center gap-2" style="min-width: 200px;">
                                                        <input class="form-check-input" type="checkbox" id="permission-{{ $permission->id }}"
                                                               wire:model="selectedPermissions" value="{{ $permission->name }}"
                                                               @if(in_array($permission->name, $selectedPermissions)) checked @endif>
                                                        <label class="form-check-label mb-0" for="permission-{{ $permission->id }}">
                                                            {{ $permission->name }}
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    @error('selectedPermissions') <small class="text-danger">{{ $message }}</small> @enderror
                                </div>

                                <div class="d-flex align-items-center justify-content-center gap-3">
                                    <button type="submit" class="btn btn-primary-600" wire:loading.attr="disabled">
                                        <span wire:loading.remove>Update</span>
                                        <span wire:loading>Processing...</span>
                                    </button>
                                    <button wire:click.prevent="resetForm" class="btn btn-outline-dark" wire:loading.attr="disabled">
                                        <span wire:loading.remove>Cancel</span>
                                        <span wire:loading>Processing...</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        @if($showAddRole)
            <div class="card">
                <div class="card-body">
                    <h6 class="text-md text-primary-light mb-16">Add New Role</h6>

                    <form wire:submit.prevent="createRole">
                        <!-- Role Name -->
                        <div class="mb-3">
                            <label for="roleName" class="form-label">Role Name</label>
                            <input type="text" wire:model="newRoleName" id="roleName" class="form-control radius-8" placeholder="Enter Role Name">
                            @error('newRoleName') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <!-- Permissions -->
                        <div class="mb-3">
                            <label for="permissions" class="form-label">Assign Permissions</label>
                            <div class="permissions-list">
                                <div class="mb-4">
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach ($permissions as $permission)
                                            <div class="form-check p-2 bg-cream-dark rounded border d-flex align-items-center gap-2" style="min-width: 200px;">
                                                <input class="form-check-input" type="checkbox" id="permission-{{ $permission->id }}"
                                                       wire:model="selectedPermissions" value="{{ $permission->name }}">
                                                <label class="form-check-label mb-0" for="permission-{{ $permission->id }}">
                                                    {{ $permission->name }}
                                                </label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                            @error('selectedPermissions') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="d-flex align-items-center justify-content-center gap-3">
                            <button type="submit" class="btn btn-primary-600" wire:loading.attr="disabled">
                                <span wire:loading.remove>Add Role</span>
                                <span wire:loading>Processing...</span>
                            </button>
                            <button wire:click.prevent="resetForm" class="btn btn-outline-dark" wire:loading.attr="disabled">
                                <span wire:loading.remove>Cancel</span>
                                <span wire:loading>Processing...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif




</div>
