<!-- Modal -->
<div class="modal fade" id="addExperience" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add Experience</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form  id="processAddExperience" method="post"
                       action="{{route('user.portfolios.experience.add')}}" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row g-2 ">
                            @csrf
                            <div class="col-md-12 mx-auto mt-3">
                                <label for="store" class="form-label">
                                    Title <sup><span class="text-danger">*</span> </sup>
                                </label>
                                <div class="input-group">
                                    <button class="btn btn-outline-dark dropdown-toggle assetDropdown"
                                            type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <i class="ri-user-received-2-line"></i>
                                    </button>
                                    <input type="text" class="form-control"
                                           placeholder="Mathematics Teacher"
                                           aria-label="Example text with button addon"
                                           aria-describedby="button-addon1" name="title">
                                </div>
                            </div>
                            <div class="col-md-12 mx-auto mt-3">
                                <label for="store" class="form-label">
                                    Employer <sup><span class="text-danger">*</span> </sup>
                                </label>
                                <div class="input-group">
                                    <button class="btn btn-outline-dark dropdown-toggle assetDropdown"
                                            type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <i class="ri-user-received-2-line"></i>
                                    </button>
                                    <input type="text" class="form-control"
                                           placeholder="ABC LLC"
                                           aria-label="Example text with button addon"
                                           aria-describedby="button-addon1" name="employer">
                                </div>
                            </div>
                            <div class="col-md-12 mx-auto mt-3">
                                <label for="store" class="form-label">
                                    Location of Employment <sup><span class="text-danger">*</span> </sup>
                                </label>
                                <div class="input-group">
                                    <button class="btn btn-outline-dark dropdown-toggle assetDropdown"
                                            type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <i class="ri-map-pin-2-fill"></i>
                                    </button>
                                    <input type="text" class="form-control"
                                           placeholder="CA"
                                           aria-label="Example text with button addon"
                                           aria-describedby="button-addon1" name="location">
                                </div>
                            </div>
                            <div class="col-md-12 mx-auto mt-3">
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label for="store" class="form-label">
                                            Date Started <sup><span class="text-danger">*</span> </sup>
                                        </label>
                                        <div class="input-group">
                                            <button class="btn btn-outline-dark dropdown-toggle assetDropdown"
                                                    type="button" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                <i class="ri-calendar-2-fill"></i>
                                            </button>
                                            <input type="date" class="form-control"
                                                   placeholder="Time Started"
                                                   aria-label="Example text with button addon"
                                                   aria-describedby="button-addon1" name="dateStart">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="store" class="form-label">
                                            Date Completed <sup><span class="text-danger">*</span> </sup>
                                        </label>
                                        <div class="input-group">
                                            <button class="btn btn-outline-dark dropdown-toggle assetDropdown"
                                                    type="button" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                <i class="ri-calendar-2-fill"></i>
                                            </button>
                                            <input type="date" class="form-control"
                                                   placeholder="JavaScript Library"
                                                   aria-label="Example text with button addon"
                                                   aria-describedby="button-addon1" name="dateFinish">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mx-auto mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="gridCheck" name="current" value="1">
                                    <label class="form-check-label" for="gridCheck">
                                        Currently employed here
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-12 mx-auto mt-3">
                                <label for="store" class="form-label">
                                    Describe your work here <sup><span class="text-danger">*</span> </sup>
                                </label>
                                <div class="input-group">
                                    <textarea class="form-control summernote"  id="textInput"
                                              placeholder="Describe your project."
                                              aria-label="Example text with button addon"
                                              aria-describedby="button-addon1" name="description"
                                              rows="5" maxlength="2000"></textarea>
                                </div>
                            </div>


                            <button type="submit"
                                    class="btn btn-dark radius-15 mt-3 submit"
                                    id="submit">
                                Add Experience <i class="b bi-arrow-up-right-circle"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteExperience" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Delete Experience</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form  id="removeExperience" method="post"
                       action="{{route('user.portfolios.experience.delete')}}" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row g-2 ">
                            @csrf
                            <div class="col-md-12 mx-auto mt-3">
                                <p class="text-center text-danger">
                                    Do you really want to delete this work experience?
                                </p>
                            </div>
                            <div class="col-md-12 mx-auto mt-3" style="display: none;">
                                <label for="store" class="form-label">
                                    Experience ID <sup><span class="text-danger">*</span> </sup>
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
                                Remove Experience
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="truncateExperience" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Delete all Experiences</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form  id="processTruncateExperience" method="post"
                       action="{{route('user.portfolios.experience.truncate')}}" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row g-2 ">
                            @csrf
                            <div class="col-md-12 mx-auto mt-3">
                                <p class="text-center text-danger">
                                    Do you really want to truncate all your experiences?
                                </p>
                            </div>

                            <button type="submit"
                                    class="btn btn-outline-danger radius-15 mt-3 submit"
                                    id="submit">
                                Truncate Experiences
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="editExperience" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title modal-title-update" id="staticBackdropLabel">Edit Experience</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form  id="updateExperience" method="post"
                       action="{{route('user.portfolios.experience.edit')}}" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row g-2 ">
                            @csrf
                            <div class="col-md-6 mx-auto mt-3">
                                <label for="store" class="form-label">
                                    Title <sup><span class="text-danger">*</span> </sup>
                                </label>
                                <div class="input-group">
                                    <button class="btn btn-outline-dark dropdown-toggle assetDropdown"
                                            type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <i class="ri-user-received-2-line"></i>
                                    </button>
                                    <input type="text" class="form-control"
                                           placeholder="Mathematics Teacher"
                                           aria-label="Example text with button addon"
                                           aria-describedby="button-addon1" name="title">
                                </div>
                            </div>
                            <div class="col-md-6 mx-auto mt-3">
                                <label for="store" class="form-label">
                                    Employer <sup><span class="text-danger">*</span> </sup>
                                </label>
                                <div class="input-group">
                                    <button class="btn btn-outline-dark dropdown-toggle assetDropdown"
                                            type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <i class="ri-user-received-2-line"></i>
                                    </button>
                                    <input type="text" class="form-control"
                                           placeholder="ABC LLC"
                                           aria-label="Example text with button addon"
                                           aria-describedby="button-addon1" name="employer">
                                </div>
                            </div>
                            <div class="col-md-12 mx-auto mt-3">
                                <label for="store" class="form-label">
                                    Location of Employment <sup><span class="text-danger">*</span> </sup>
                                </label>
                                <div class="input-group">
                                    <button class="btn btn-outline-dark dropdown-toggle assetDropdown"
                                            type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <i class="ri-map-pin-2-fill"></i>
                                    </button>
                                    <input type="text" class="form-control"
                                           placeholder="CA"
                                           aria-label="Example text with button addon"
                                           aria-describedby="button-addon1" name="location">
                                </div>
                            </div>
                            <div class="col-md-12 mx-auto mt-3">
                                <div class="row mt-2">
                                    <div class="col-md-6">
                                        <label for="store" class="form-label">
                                            Date Started <sup><span class="text-danger">*</span> </sup>
                                        </label>
                                        <div class="input-group">
                                            <button class="btn btn-outline-dark dropdown-toggle assetDropdown"
                                                    type="button" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                <i class="ri-calendar-2-fill"></i>
                                            </button>
                                            <input type="date" class="form-control"
                                                   placeholder="Time Started"
                                                   aria-label="Example text with button addon"
                                                   aria-describedby="button-addon1" name="dateStart">
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="store" class="form-label">
                                            Date Completed <sup><span class="text-danger">*</span> </sup>
                                        </label>
                                        <div class="input-group">
                                            <button class="btn btn-outline-dark dropdown-toggle assetDropdown"
                                                    type="button" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                <i class="ri-calendar-2-fill"></i>
                                            </button>
                                            <input type="date" class="form-control"
                                                   placeholder="JavaScript Library"
                                                   aria-label="Example text with button addon"
                                                   aria-describedby="button-addon1" name="dateFinish">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 mx-auto mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="gridCheck" name="current" value="1">
                                    <label class="form-check-label" for="gridCheck">
                                        Currently employed here
                                    </label>
                                </div>
                            </div>

                            <div class="col-md-12 mx-auto mt-3">
                                <label for="store" class="form-label">
                                    Describe your work here <sup><span class="text-danger">*</span> </sup>
                                </label>
                                <div class="input-group">
                                    <textarea class="form-control"  id="textInput"
                                              placeholder="Describe your project."
                                              aria-label="Example text with button addon"
                                              aria-describedby="button-addon1" name="description"
                                              rows="5" maxlength="2000"></textarea>
                                </div>
                            </div>

                            <div class="col-md-12 mx-auto mt-3" style="display: none;">
                                <label for="store" class="form-label">
                                    Experience ID <sup><span class="text-danger">*</span> </sup>
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
                                    class="btn btn-dark radius-15 mt-3 submit"
                                    id="submit">
                                Edit Experience <i class="b bi-arrow-up-right-circle"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
