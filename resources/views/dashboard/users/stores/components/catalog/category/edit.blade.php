@extends('dashboard.layout.base')
@section('content')

    <div class="submit-property-area">
        <div class="container-fluid">
            <form class="submit-property-form" id="processForm" action="{{route('user.stores.catalog.category.edit.process',['id'=>$category->id])}}" method="post">
                <div class="row g-3">
                    <div class="col-md-6">
                        <label for="inputTitle" class="form-label">Category Name<sup class="text-danger">*</sup></label>
                        <input type="text" class="form-control" id="inputTitle" name="name" value="{{$category->categoryName}}">
                    </div>
                    <div class="col-md-6">
                        <label for="inputTitle" class="form-label">Category Status<sup class="text-danger">*</sup></label>
                        <select class="form-control selectize" id="inputTitle" name="status">
                            <option value="">Select an option</option>
                            <option value="1" {{($category->status==1)?'selected':''}}>Active</option>
                            <option value="2" {{($category->status==2)?'selected':''}}>Inactive</option>
                        </select>
                    </div>
                    <div class="col-12 text-center mt-3">
                        <button type="submit" class="default-btn submit">Update Category</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('js')
        <script src="{{asset('requests/dashboard/user/stores.js')}}"></script>
    @endpush
@endsection
