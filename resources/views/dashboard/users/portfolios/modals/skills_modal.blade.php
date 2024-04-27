@push('css')
    <style>
        .slider-green {
            color: green;
        }
        .slider-red {
            color: red;
        }
    </style>
@endpush
<!-- Modal -->
<div class="modal fade" id="addSkill" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add Skills</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form  id="processAddSkills" method="post"
                       action="{{route('user.portfolios.skills.add')}}" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row g-2 ">
                            @csrf
                            <div class="col-md-6 mx-auto mt-3">
                                <label for="store" class="form-label">
                                    Skill <sup><span class="text-danger">*</span> </sup>
                                </label>
                                <div class="input-group">
                                    <button class="btn btn-outline-dark dropdown-toggle assetDropdown"
                                            type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <i class="ri-user-received-2-line"></i>
                                    </button>
                                    <input type="text" class="form-control"
                                           placeholder="Mathematics"
                                           aria-label="Example text with button addon"
                                           aria-describedby="button-addon1" name="title">
                                </div>
                            </div>
                            <div class="col-md-6 mx-auto mt-3">
                                <label for="store" class="form-label">
                                    Skill Level<sup><span class="text-danger">*</span> </sup>
                                </label>
                                <div class="input-group">
                                    <button class="btn btn-outline-dark dropdown-toggle assetDropdown"
                                            type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <i class="bx bx-slider-alt"></i>
                                    </button>
                                    <input type="range" class="form-control" min="1" max="10"
                                           aria-label="Example text with button addon"
                                           aria-describedby="button-addon1" name="level" value="1">
                                </div>
                                <span><strong>Level:</strong> <span id="levelIndicator"></span></span>
                            </div>


                            <button type="submit"
                                    class="btn btn-dark radius-15 mt-3 submit"
                                    id="submit">
                                Add Skill <i class="b bi-arrow-up-right-circle"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteSkills" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Delete Skill</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form  id="removeSkills" method="post"
                       action="{{route('user.portfolios.skills.delete')}}" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row g-2 ">
                            @csrf
                            <div class="col-md-12 mx-auto mt-3">
                                <p class="text-center text-danger">
                                    Do you really want to delete this Skill?
                                </p>
                            </div>
                            <div class="col-md-12 mx-auto mt-3" style="display: none;">
                                <label for="store" class="form-label">
                                    Skills ID <sup><span class="text-danger">*</span> </sup>
                                </label>
                                <div class="input-group">
                                    <button class="btn btn-outline-dark dropdown-toggle assetDropdown"
                                            type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <i class="ri-user-received-2-line"></i>
                                    </button>
                                    <input type="text" class="form-control"
                                           aria-label="Example text with button addon"
                                           aria-describedby="button-addon1" name="id">
                                </div>
                            </div>

                            <button type="submit"
                                    class="btn btn-outline-danger radius-15 mt-3 submit"
                                    id="submit">
                                Remove Skills
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="truncateSkills" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Delete all Skills</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form  id="processTruncateSkills" method="post"
                       action="{{route('user.portfolios.skills.truncate')}}" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row g-2 ">
                            @csrf
                            <div class="col-md-12 mx-auto mt-3">
                                <p class="text-center text-danger">
                                    Do you really want to truncate all your Skills?
                                </p>
                            </div>

                            <button type="submit"
                                    class="btn btn-outline-danger radius-15 mt-3 submit"
                                    id="submit">
                                Truncate Skills
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

