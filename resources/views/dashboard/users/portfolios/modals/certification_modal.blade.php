
<!-- Modal -->
<div class="modal fade" id="addCertification" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
     aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Add Certifications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form  id="processAddCertifications" method="post"
                       action="{{route('user.portfolios.certifications.add')}}" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row g-2 ">
                            @csrf
                            <div class="col-md-12 mx-auto mt-3">
                                <label for="store" class="form-label">
                                    Title <i class="ri-file-info-fill" data-bs-toggle="tooltip" title="Title of Certification/Award"></i>
                                    <sup><span class="text-danger">*</span> </sup>
                                </label>
                                <div class="input-group">
                                    <button class="btn btn-outline-dark dropdown-toggle assetDropdown"
                                            type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <i class="ri-user-received-2-line"></i>
                                    </button>
                                    <input type="text" class="form-control"
                                           placeholder="BSc in Computer Science"
                                           aria-label="Example text with button addon"
                                           aria-describedby="button-addon1" name="title">
                                </div>
                            </div>
                            <div class="col-md-12 mx-auto mt-3">
                                <label for="store" class="form-label">
                                    Organization <i class="ri-file-info-fill" data-bs-toggle="tooltip" title="Which organization or body issued this certificate"></i>
                                    <sup><span class="text-danger">*</span> </sup>
                                </label>
                                <div class="input-group">
                                    <button class="btn btn-outline-dark dropdown-toggle assetDropdown"
                                            type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <i class="ri-building-2-fill"></i>
                                    </button>
                                    <input type="text" class="form-control"
                                           placeholder="University of Nigeria"
                                           aria-label="Example text with button addon"
                                           aria-describedby="button-addon1" name="organization">
                                </div>
                            </div>
                            <div class="col-md-6 mx-auto mt-3">
                                <label for="store" class="form-label">
                                    Certification <i class="ri-file-info-fill" data-bs-toggle="tooltip"
                                                     title="Upload the certificate/award. This can also be an image or PDF"></i>
                                </label>
                                <div class="input-group">
                                    <button class="btn btn-outline-dark dropdown-toggle assetDropdown"
                                            type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <i class="ri-award-fill"></i>
                                    </button>
                                    <input type="file" class="form-control"
                                           aria-label="Example text with button addon"
                                           aria-describedby="button-addon1" name="certificate" accept="image/*,application/pdf">
                                </div>
                            </div>
                            <div class="col-md-6 mx-auto mt-3">
                                <label for="store" class="form-label">
                                    Certificate Type <i class="ri-file-info-fill" data-bs-toggle="tooltip"
                                                     title="Is this an award or a Certificate"></i>
                                    <sup><span class="text-danger">*</span> </sup>
                                </label>
                                <div class="input-group">
                                    <button class="btn btn-outline-dark dropdown-toggle assetDropdown"
                                            type="button" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                        <i class="bx bx-certification"></i>
                                    </button>
                                    <select class="form-control selectize"
                                           aria-label="Example text with button addon"
                                           aria-describedby="button-addon1" name="certificateType">
                                        <option value="">Select Certificate Type</option>
                                        <option value="1">Certificate</option>
                                        <option value="2">Award</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12 mx-auto mt-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="gridCheck" name="isPublic" value="1">
                                    <label class="form-check-label" for="gridCheck">
                                        Make uploaded certificate public
                                    </label>
                                </div>
                            </div>



                            <button type="submit"
                                    class="btn btn-dark radius-15 mt-3 submit"
                                    id="submit">
                                Add Certification <i class="b bi-arrow-up-right-circle"></i>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="deleteCertifications" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Delete Certification</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form  id="removeCertifications" method="post"
                       action="{{route('user.portfolios.certifications.delete')}}" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row g-2 ">
                            @csrf
                            <div class="col-md-12 mx-auto mt-3">
                                <p class="text-center text-danger">
                                    Do you really want to delete this Certification?
                                </p>
                            </div>
                            <div class="col-md-12 mx-auto mt-3" style="display: none;">
                                <label for="store" class="form-label">
                                    Certifications ID <sup><span class="text-danger">*</span> </sup>
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
                                Remove Certifications
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="truncateCertifications" data-bs-backdrop="static" data-bs-keyboard="false"
     tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="staticBackdropLabel">Delete all Certifications</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form  id="processTruncateCertifications" method="post"
                       action="{{route('user.portfolios.certifications.truncate')}}" enctype="multipart/form-data">
                    <div class="card-body">
                        <div class="row g-2 ">
                            @csrf
                            <div class="col-md-12 mx-auto mt-3">
                                <p class="text-center text-danger">
                                    Do you really want to truncate all your Certifications?
                                </p>
                            </div>

                            <button type="submit"
                                    class="btn btn-outline-danger radius-15 mt-3 submit"
                                    id="submit">
                                Truncate Certifications
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

