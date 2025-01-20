<div>
    @inject('option','App\Custom\Regular')
    <div class="card">
        <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
            <div class="d-flex flex-wrap align-items-center gap-3">
                <div class="icon-field">
                    <input type="text" name="#0" class="form-control form-control-sm w-auto" placeholder="Search" wire:model.blur="search">
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
            @if($events->isNotEmpty())
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
                            <th scope="col">User</th>
                            <th scope="col">Title</th>
                            <th scope="col">Reference</th>
                            <th scope="col">Featured Image</th>
                            <th scope="col">Category</th>
                            <th scope="col">Date Created</th>
                            <th scope="col">Status</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($events as $index=>$event)
                            <tr>
                                <td>
                                    <div class="form-check style-check d-flex align-items-center">
                                        <label class="form-check-label" for="check1">
                                            {{$events->firstItem()+$index}}
                                        </label>
                                    </div>
                                </td>
                                <td>{{$event->users->name}}</td>
                                <td>{{$event->title}}</td>
                                <td>{{$event->reference}}</td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{$event->featuredImage}}" alt="" class="flex-shrink-0 me-12 radius-8 lightboxed w-72-px h-72-px radius-8 object-fit-cover"/>
                                    </div>
                                </td>
                                <td>{{eventCategoryById($event->category)->name??'N/A'}}</td>
                                <td> {{$event->created_at->format('d M Y, h:i:s a')}}</td>
                                <td>
                                    @switch($event->status)
                                        @case(1)
                                            <span class="badge bg-success">
                                                <i class="fa fa-check-circle text-success" style="font-size: 14px;"
                                                   data-bs-toggle="tooltip" title="Active"></i>
                                                Active
                                            </span>
                                            @break
                                        @case(2)
                                           <span class="badge bg-primary">
                                                <i class="fa fa-rotate-270 fa-rotate text-primary" style="font-size: 14px;"
                                                   data-bs-toggle="tooltip" title="Review"></i>
                                               Under-Review
                                           </span>
                                            @break
                                        @case(3)
                                            <span class="badge bg-danger">
                                                <i class="fa fa-ban text-danger" style="font-size: 14px;"
                                                   data-bs-toggle="tooltip" title="Cancelled"></i>
                                                Cancelled
                                            </span>
                                            @break
                                        @case(5)
                                            <span class="badge bg-warning">
                                                <i class="fa fa-ban text-danger" style="font-size: 14px;"
                                                   data-bs-toggle="tooltip" title="Concluded"></i>
                                                Concluded
                                            </span>
                                            @break
                                        @default
                                                <span class="badge bg-danger">
                                                    <i class="fa fa-warning text-danger" style="font-size: 14px;"
                                                       data-bs-toggle="tooltip" title="Rejected"></i>
                                                    Rejected
                                                </span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    <a href="{{route('staff.events.detail',['event'=>$event->reference])}}"
                                       class="w-32-px h-32-px bg-primary-light text-primary-600
                                    rounded-circle d-inline-flex align-items-center justify-content-center" wire:navigate>
                                        <iconify-icon icon="iconamoon:eye-light"></iconify-icon>
                                    </a>
                                    @can('delete UserAd')
                                        <button type="button" wire:click="deleteEvent({{ $event->id }})"  wire:loading.attr="disabled"
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
                        {{$events->links()}}
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
