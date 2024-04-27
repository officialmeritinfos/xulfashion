@inject('injected','App\Custom\Regular')
<div class="ui-kit-card grid mb-24">
    <ul class="nav nav-pills nav-fill" id="pills-tab" role="tablist">
        <li class="nav-item" role="presentation">
            <a href="{{route('user.applications.index')}}" class="nav-link {{url()->current()==route('user.applications.index')?'active':''}}"
               type="button" role="tab"
               aria-controls="pills-home"
               aria-selected="true">Home</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{route('user.applications.active')}}" class="nav-link {{url()->current()==route('user.applications.active')?'active':''}}"
               type="button" role="tab"
               aria-controls="pills-home"
               aria-selected="true">Active</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{route('user.applications.interviewing')}}" class="nav-link {{url()->current()==route('user.applications.interviewing')?'active':''}}"
               type="button" role="tab"
               aria-controls="pills-home"
               aria-selected="true">Interviewing</a>
        </li>
        <li class="nav-item" role="presentation">
            <a href="{{route('user.applications.closed')}}" class="nav-link {{url()->current()==route('user.applications.closed')?'active':''}}"
               type="button" role="tab"
               aria-controls="pills-home"
               aria-selected="true">Closed</a>
        </li>
    </ul>
</div>
