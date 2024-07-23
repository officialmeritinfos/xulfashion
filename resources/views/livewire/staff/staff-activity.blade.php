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

            </div>
        </div>
        <div class="card-body">
            @if($activities->isNotEmpty())
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
                            <th scope="col">Staff</th>
                            <th scope="col">Title</th>
                            <th scope="col">Model</th>
                            <th scope="col">Model ID</th>
                            <th scope="col">Date Created</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($activities as $index=>$activity)
                            <tr>
                                <td>
                                    <div class="form-check style-check d-flex align-items-center">
                                        <label class="form-check-label" for="check1">
                                            {{$activities->firstItem()+$index}}
                                        </label>
                                    </div>
                                </td>
                                <td>{{$option->fetchStaffById($activity->staff)->name??'N/A'}}</td>
                                <td>{{$activity->action}}</td>
                                <td>{{$activity->model}}</td>
                                <td>{{$activity->model_id}}</td>
                                <td>
                                    {{$activity->created_at->format('d/m/Y h:i:s a')}}
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="mt-3">
                        {{$activities->links()}}
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
