@extends('dashboard.layout.base')
@section('content')
    @inject('injected','App\Custom\Regular')

    <div class="product-details-area">
        <div class="container-fluid">
            <div class="product-details-wrap">
                <div class="row">
                    <div class="col-lg-6 col-md-12">
                        <img src="{{$ad->featuredImage}}" class="product-details-image pr-15"/>
                    </div>

                    <div class="col-lg-6 col-md-12">
                        <div class="product-details-desc pl-15">
                            <h3>{{$ad->title}}</h3>

                            <div class="price">
                                <span class="new-price">
                                    @if($ad->priceType==1)
                                        Contact for price
                                    @else
                                        {{$ad->currency}}{{number_format($ad->amount,2)}}
                                    @endif
                                </span>
                            </div>

                            <p>{{$ad->description}}</p>

                            <ul class="sku">
                                @if($ad->priceType==2)
                                    <li>
                                        Open To Negotiation:
                                        <span>
                                           {{$injected->openToNegotiation($ad->openToNegotiation)}}
                                        </span>
                                    </li>
                                @endif
                                @if(!empty($ad->companyName))
                                    <li>
                                        Company Name:
                                        <span>{{$ad->companyName}}</span>
                                    </li>
                                @endif
                                <li>
                                    State:
                                    <span>{{$injected->fetchState($ad->country,$ad->state)->name}}</span>
                                </li>
                                <li>
                                    Service Type:
                                    <span><span class="badge bg-primary text-white">{{$service->name}}</span> </span>
                                </li>
                                <li>
                                    Categories:
                                    <span>
                                        @php
                                        $cates = explode(',',$ad->tags)
                                        @endphp
                                        @foreach($cates as $cate)
                                            <span class="badge bg-primary text-white">
                                                {{$cate}}
                                            </span>
                                        @endforeach
                                    </span>
                                </li>
                            </ul>

                            <ul class="social-wrap">
                                <li>
                                    <span>Promoted:</span>
                                </li>
                                @if($ad->isPromoted==1)
                                    <li data-bs-toggle="tooltip" title="Promoted">
                                        <a href="#" class="bg-success">
                                            <i class="ri-checkbox-circle-fill text-light"></i>
                                        </a>
                                    </li>
                                @else
                                    <li data-bs-toggle="tooltip" title="Not promoted">
                                        <a href="#" class="bg-warning">
                                            <i class="ri-close-circle-fill text-light"></i>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>

    <div class="order-details-area mb-0 mt-3">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-6 col-sm-6">
                    <div class="add-new-orders">
                        <button class="new-orders" data-bs-toggle="modal" data-bs-target="#addPhoto">
                            Add New Photo
                            <i class="ri-add-circle-line"></i>
                        </button>
                    </div>
                </div>
            </div>

            <div class="latest-transaction-area mt-3">
                <div class="table-responsive h-auto" data-simplebar>
                    <table class="table align-middle mb-0">
                        <thead>
                        <tr>
                            <th scope="col">PHOTO</th>
                            <th scope="col">ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($photos as $photo)
                            <tr>
                                <td>
                                    <a href="{{$photo->photo}}" target="_blank">
                                        <img src="{{$photo->photo}}" alt="Images" style="width: 50px;">
                                    </a>
                                </td>
                                <td class="text-center">
                                    <div class="dropdown">
                                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="ri-more-2-fill"></i>
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                            <li>
                                                <a class="dropdown-item" href="{{route('user.ads.photo.delete',['ad'=>$ad->reference, 'id'=>$photo->id])}}">
                                                    Delete
                                                    <i class="ri-delete-bin-6-line"></i>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('js')
        <!-- Modal -->
        <div class="modal fade" id="addPhoto" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Add Ad Photo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form class="row g-3" id="processForm" action="{{route('user.ads.photo.add.process',['id'=>$ad->reference])}}" method="post">
                            <div class="col-md-12 custom-file mb-3 mt-3">
                                <label for="inputAddress" class="form-label">Images<i class="ri-information-fill" data-bs-toggle="tooltip"
                                                                                      title="Upload multiple images that represent your Ad"></i> </label>
                                <div class="input-group mb-3">
                                    <input type="file" class="form-control custom-file-input" id="imageInput" multiple name="photos[]">
                                    <label class="input-group-text" for="inputGroupFile02">Upload</label>
                                </div>
                            </div>
                            <div class="col-12 text-center mt-5">
                                <button type="submit" class="default-btn submit">Add Photo</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script src="{{asset('requests/dashboard/user/ads.js')}}"></script>
    @endpush
@endsection
