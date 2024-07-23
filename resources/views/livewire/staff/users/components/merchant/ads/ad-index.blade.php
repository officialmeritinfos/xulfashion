<div>
    @inject('option','App\Custom\Regular')
    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex flex-wrap align-items-center gap-3">

                <div class="d-flex flex-wrap align-items-center gap-3">
                    <select class="form-select form-select-sm w-auto" wire:model.live="show">
                        <option>5</option>
                        <option>10</option>
                        <option>15</option>
                        <option>20</option>
                        <option>50</option>
                        <option>100</option>
                    </select>
                </div>
                <div class="icon-field">
                    <input type="text" name="#0" class="form-control form-control-sm w-auto" placeholder="Search" wire:model.live="search">
                    <span class="icon">
                      <iconify-icon icon="ion:search-outline"></iconify-icon>
                    </span>
                </div>
            </div>
            <div class="d-flex flex-wrap align-items-center gap-3">
                <select class="form-select form-select-sm w-auto" wire:model.live="searchStatus">
                    <option value="all">All</option>
                    <option value="1">Active</option>
                    <option value="2">Under Review</option>
                    <option value="3">Deactivated</option>
                    <option value="4">Rejected</option>
                </select>
            </div>
        </div>
        <div class="card-body">
            @if($ads->isNotEmpty())
                <div class="table-responsive">
                    <table class="table bordered-table mb-0">
                        <thead>
                        <tr>
                            <th scope="col">
                                <div class="form-check style-check d-flex align-items-center">
                                    <label class="form-check-label" for="checkAll">
                                        S.L
                                    </label>
                                </div>
                            </th>
                            <th scope="col">Merchant</th>
                            <th scope="col">Title</th>
                            <th scope="col">Reference</th>
                            <th scope="col">Featured Image</th>
                            <th scope="col">Service Type</th>
                            <th scope="col">Date Created</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($ads as $index=>$ad)
                            <tr>
                                <td>
                                    <div class="form-check style-check d-flex align-items-center">
                                        <label class="form-check-label" for="check1">
                                            {{$ads->firstItem()+$index}}
                                        </label>
                                    </div>
                                </td>
                                <td>{{$option->userById($ad->user)->name??'N/A'}}</td>
                                <td>{{$ad->title}}</td>
                                <td>{{$ad->reference}}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{$ad->featuredImage}}" alt="" class="flex-shrink-0 me-12 radius-8 lightboxed w-72-px h-72-px radius-8 object-fit-cover"/>
                                    </div>
                                </td>
                                <td>{{$option->serviceTypeById($ad->serviceType)->name??'N/A'}}</td>
                                <td> {{$ad->created_at->format('d M Y, h:i:s a')}}</td>
                                <td>
                                    @switch($ad->status)
                                        @case(1)
                                            <li class="text-success" data-bs-toggle="tooltip" title="Active">
                                                <i class="ri-check-double-fill text-success" style="font-size: 20px;"></i>
                                            </li>
                                            @break
                                        @case(2)
                                            <li class="text-primary" data-bs-toggle="tooltip" title="Under-review">
                                                <i class="bx bx-loader-alt bx-spin text-primary" style="font-size: 20px;"></i>
                                            </li>
                                            @break
                                        @case(3)
                                            <li class="text-danger" data-bs-toggle="tooltip" title="Deactivated">
                                                <i class="ri-alert-fill text-danger" style="font-size: 20px;"></i>
                                            </li>
                                            @break
                                        @default
                                            <li class="text-danger" data-bs-toggle="tooltip" title="Rejected By support">
                                                <i class="ri-error-warning-fill text-danger" style="font-size: 20px;"></i>
                                            </li>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    <a href="{{route('staff.users.ads.details',['id'=>$option->userById($ad->user)->reference,'ad'=>$ad->reference])}}"
                                       class="w-32-px h-32-px bg-primary-light text-primary-600
                                    rounded-circle d-inline-flex align-items-center justify-content-center" wire:navigate>
                                        <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                                    </a>
                                    @can('delete UserAd')
                                        <button type="button" wire:click="deleteAd({{ $ad->id }})"  wire:loading.attr="disabled"
                                                class="w-32-px h-32-px bg-danger-focus text-danger-main rounded-circle d-inline-flex align-items-center justify-content-center">
                                            <iconify-icon icon="mingcute:delete-2-line"></iconify-icon>
                                        </button>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{$ads->links()}}
                    </div>
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
