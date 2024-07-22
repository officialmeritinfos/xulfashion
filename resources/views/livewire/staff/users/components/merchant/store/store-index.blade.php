<div>
    @inject('option','App\Custom\Regular')
    <div class="card basic-data-table">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex flex-wrap align-items-center gap-3">
                <div class="d-flex align-items-center gap-2">
                    <span>Show</span>
                    <select class="form-select form-select-sm w-auto" wire:model.live="show">
                        <option>10</option>
                        <option>20</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                </div>
                <div class="icon-field">
                    <input type="text" wire:model.live="search" class="form-control form-control-sm w-auto" placeholder="Search">
                    <span class="icon">
              <iconify-icon icon="ion:search-outline"></iconify-icon>
            </span>
                </div>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-3">
                <select class="form-select form-select-sm w-auto" wire:model.live="kycStatus">
                    <option value="">KYC Status</option>
                    <option value="all">All</option>
                    <option value="1">Completed</option>
                    <option value="4">Under Review</option>
                    <option value="2">Pending/Rejected</option>
                </select>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table bordered-table mb-0" id="dataTable" data-page-length='10'>
                    <thead>
                    <tr>
                        <th scope="col">
                            <div class="form-check style-check d-flex align-items-center">
                                <label class="form-check-label">
                                    S.L
                                </label>
                            </div>
                        </th>
                        <th scope="col">Merchant</th>
                        <th scope="col">Name</th>
                        <th scope="col">Reference</th>
                        <th scope="col">Service Type</th>
                        <th scope="col">Country</th>
                        <th scope="col">KYC Status</th>
                        <th scope="col">Status</th>
                        <th scope="col">Date</th>
                        <th scope="col">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($stores as $index=> $store)
                        <tr>
                            <td>
                                <div class="form-check style-check d-flex align-items-center">
                                    <label class="form-check-label">
                                        {{$stores->firstItem()+$index}}
                                    </label>
                                </div>
                            </td>
                            <td>
                                {{$option->userById($store->user)->name??'N/A'}}
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    {{$store->name}}
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center">
                                    {{$store->reference}}
                                </div>
                            </td>
                            <td>
                                {{$option->serviceTypeById($store->service)->name}}
                            </td>
                            <td>
                                {{$option->fetchCountryIso2($store->country)->name}}
                            </td>
                            <td>
                                @switch($store->isVerified)
                                    @case(1)
                                        <span class="badge text-sm fw-semibold bg-dark-success-gradient px-20 py-9 radius-4 text-white">
                                                        Verified
                                                    </span>
                                        @break
                                    @case(4)
                                        <span class="badge text-sm fw-semibold bg-dark-primary-gradient px-20 py-9 radius-4 text-white">Under Review</span>
                                        @break
                                    @default
                                        <span class="badge text-sm fw-semibold bg-dark-lilac-gradient px-20 py-9 radius-4 text-white">Pending Submission/Rejected</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                @switch($store->status)
                                    @case(1)
                                        <span class="badge text-sm fw-semibold bg-dark-success-gradient px-20 py-9 radius-4 text-white">
                                                        Active
                                                    </span>
                                        @break
                                    @default
                                        <span class="badge text-sm fw-semibold bg-dark-lilac-gradient px-20 py-9 radius-4 text-white">Inactive</span>
                                        @break
                                @endswitch
                            </td>
                            <td>
                                {{$store->created_at->format('d-m-Y-h-i-s a')}}
                            </td>
                            <td>
                                <a href="{{route('staff.users.store',['id'=>$option->userById($store->user)->reference])}}" class="w-32-px h-32-px bg-primary-light text-primary-600
                                rounded-circle d-inline-flex align-items-center justify-content-center" wire:navigate>
                                    <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <div class="mt-3">
                    {{$stores->links()}}
                </div>
            </div>
        </div>
    </div>
</div>
