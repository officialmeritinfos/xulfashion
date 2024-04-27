@inject('injected','App\Custom\Regular')
<div class="container-fluid">
    <div class="ui-kit-card grid mb-24">
        <ul class="nav nav-pills nav-fill" id="pills-tab" role="tablist">
            <li class="nav-item" role="presentation">
                <a href="{{route('user.jobs.index')}}" class="nav-link {{url()->current()==route('user.jobs.index')?'active':''}}"
                   type="button" role="tab"
                   aria-controls="pills-home"
                   aria-selected="true">Home</a>
            </li>
            <li class="nav-item" role="presentation">
                <a href="{{route('user.jobs.employments')}}" class="nav-link {{url()->current()==route('user.jobs.employments')?'active':''}}"
                   type="button" role="tab"
                   aria-controls="pills-home"
                   aria-selected="true">Employments</a>
            </li>
        </ul>
    </div>
</div>
