<div>

    @if(!$showAddPermission)
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
                        <option>150</option>
                        <option>200</option>
                    </select>
                    <form class="navbar-search">
                        <input type="text" class="bg-base h-40-px w-auto" name="search" placeholder="Search" wire:model.live="search">
                        <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
                    </form>
                </div>
                <div class="d-flex align-items-center flex-wrap gap-3">
                    <button type="button" class="btn btn-secondary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2"
                            wire:click="addNewPermission"
                            data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                        Add New Permission
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
                                <th>Model</th>
                                <th>Action</th>
                                <th>Roles</th>
                            </tr>
                        </thead>
                        <tbody>
                        @forelse ($groupedPermissions as $model => $data)
                            @foreach ($data['actions'] as $action => $roles)
                                <tr>
                                    @if ($loop->first)
                                        <td rowspan="{{ count($data['actions']) }}" class="align-middle fw-bold">{{ $model }}</td>
                                    @endif
                                    <td>{{ ucfirst($action) }}</td>
                                    <td>
                                        @if (empty($roles))
                                            <span class="badge bg-danger text-white">No roles assigned</span>
                                        @else
                                            <div class="d-flex flex-wrap gap-2">
                                                @foreach ($roles as $role)
                                                    <span class="badge bg-primary text-white">{{ $role }}</span>
                                                @endforeach
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        @empty
                            <tr>
                                <td colspan="3" class="text-center text-muted">
                                    No permissions found
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-5 d-flex justify-content-center">
                    <div wire:loading wire:target="nextPage, previousPage, gotoPage" class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <div class="mt-4">
                        @if ($totalPages > 1)
                            <nav>
                                <ul class="pagination">
                                    @for ($page = 1; $page <= $totalPages; $page++)
                                        <li class="page-item {{ $page == $this->getPage() ? 'active' : '' }}">
                                            <a href="#" class="page-link" wire:click.prevent="gotoPage({{ $page }})">{{ $page }}</a>
                                        </li>
                                    @endfor
                                </ul>
                            </nav>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    @endif


    @if($showAddPermission)
        <div class="card">
            <div class="card-body">
                <h6 class="text-md text-primary-light mb-16">Add New Permission</h6>

                <form wire:submit.prevent="addPermission">
                    <!-- Role Name -->
                    <div class="mb-3">
                        <label for="roleName" class="form-label">Permission Name</label>
                        <input type="text" wire:model="newPermissionName" id="roleName" class="form-control radius-8" placeholder="Enter Role Name">
                        @error('newPermissionName') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>

                    <div class="d-flex align-items-center justify-content-center gap-3">
                        <button type="submit" class="btn btn-primary-600" wire:loading.attr="disabled">
                            <span wire:loading.remove>Add Permission</span>
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
