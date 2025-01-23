<div>
    <div class="card h-100 p-0 radius-12 mb-5">
        <div class="card-body p-24">
            <div class="row gy-4">

                <div class="col">
                    <div class="card shadow-none border bg-gradient-start-5">
                        <div class="card-body p-20">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <div>
                                    <p class="fw-medium text-primary-light mb-1">Total Verifications</p>
                                    <h6 class="mb-0">{{ $totalVerificationSubmissions }}</h6>
                                </div>
                                <div
                                    class="w-50-px h-50-px bg-primary rounded-circle d-flex justify-content-center align-items-center">
                                    <iconify-icon icon="mingcute:user-follow-fill" class="text-base text-2xl mb-0">
                                    </iconify-icon>
                                </div>
                            </div>
                        </div>
                    </div><!-- card end -->
                </div>
                <div class="col">
                    <div class="card shadow-none border bg-gradient-start-5">
                        <div class="card-body p-20">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <div>
                                    <p class="fw-medium text-primary-light mb-1">Completed Verifications</p>
                                    <h6 class="mb-0">{{ $completedVerifications }}</h6>
                                </div>
                                <div
                                    class="w-50-px h-50-px bg-success rounded-circle d-flex justify-content-center align-items-center">
                                    <iconify-icon icon="mingcute:user-follow-fill" class="text-base text-2xl mb-0">
                                    </iconify-icon>
                                </div>
                            </div>
                        </div>
                    </div><!-- card end -->
                </div>
                <div class="col">
                    <div class="card shadow-none border bg-gradient-start-5">
                        <div class="card-body p-20">
                            <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                                <div>
                                    <p class="fw-medium text-primary-light mb-1"> Pending Verifications</p>
                                    <h6 class="mb-0">{{ $pendingVerifications }}</h6>
                                </div>
                                <div
                                    class="w-50-px h-50-px bg-info rounded-circle d-flex justify-content-center align-items-center">
                                    <iconify-icon icon="mingcute:user-follow-fill" class="text-base text-2xl mb-0">
                                    </iconify-icon>
                                </div>
                            </div>
                        </div>
                    </div><!-- card end -->
                </div>

            </div>
        </div>
    </div>

    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex flex-wrap align-items-center gap-3">
                <div class="icon-field">
                    <input type="text" class="form-control form-control-sm w-auto"
                           placeholder="Search Table" wire:model.live.debounce.250ms="search">
                    <span class="icon">
                        <iconify-icon icon="ion:search-outline"></iconify-icon>
                    </span>
                </div>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-3">
                <select class="form-select form-select-sm w-auto" wire:model.live="perPage">
                    <option>1</option>
                    <option>5</option>
                    <option>10</option>
                    <option>15</option>
                    <option>20</option>
                    <option>50</option>
                    <option>75</option>
                    <option>100</option>
                </select>
            </div>
        </div>
        <div class="card-body">

            @if($verifications->isNotEmpty())
                <div class="table-responsive">
                    <table class="table bordered-table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">
                                    S.L
                                </th>
                                <th scope="col">Merchant</th>
                                <th scope="col">Reference</th>
                                <th scope="col">Document Type</th>
                                <th scope="col">Status</th>
                                <th scope="col">Date Created</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($verifications as $index=>$document)
                                <tr>
                                    <td>
                                        <div class="form-check style-check d-flex align-items-center">
                                            {{ $index+1 }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                           {{ $document->users->name }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                           {{ $document->reference }}
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                           {{ $document->docTypes->name }}
                                        </div>
                                    </td>
                                    <td>
                                        @switch($document->status)
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
                                    <td>{{ date('F d, Y h:i:s', strtotime($document->created_at)) }}</td>
                                    <td>
                                        @can('read UserVerification')
                                            <a href="{{route('staff.users.kyc.submission',['id'=>$document->users->reference])}}"
                                               class="bg-primary-50 text-primary-600 bg-hover-primary-600 hover-text-white p-10 text-sm
                                                   btn-sm px-12 py-12 radius-8 d-flex align-items-center justify-content-center
                                                   mt-16 fw-medium gap-2 w-100" wire:navigate>
                                                View Submission
                                                <iconify-icon icon="solar:alt-arrow-right-linear" class="icon text-xl line-height-1"></iconify-icon>
                                            </a>
                                        @else
                                            <h6 class="text-primary-light text-md mb-8 text-center">
                                                You do not have the permission.
                                            </h6>
                                        @endcan
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-5">
                    {{ $verifications->links() }}

                </div>

            @else
                <div class="row gy-4">
                    <div class="col-lg-12 col-sm-12">
                        <div
                            class="p-16 bg-info-50 radius-8 border-start-width-3-px border-info border-top-0 border-end-0 border-bottom-0">
                            <h6 class="text-primary-light text-md mb-8 text-center">No Data found.</h6>
                        </div>
                    </div>
                </div>
            @endif
        </div>

    </div>

</div>
