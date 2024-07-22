<div>
@inject('option','App\Custom\Regular')
    @if($showInitializeStoreForm)
        @if($staff->can('create UserStore'))
            <div class="product-area">
                <div class="container-fluid">

                    <div class="submit-property-area">
                        <div class="container-fluid">
                            <form class="submit-property-form" id="processForm" wire:submit.prevent="submitInitialization">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="inputTitle" class="form-label">Store name<sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control form-control-lg" id="inputTitle" wire:model.live="name">
                                        @error('name') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputCity" class="form-label">Type of Service<sup class="text-danger">*</sup></label>
                                        <select class="form-control form-control-lg" id="inputCity" wire:model.live="serviceType">
                                            <option value="">Select an option</option>
                                            @foreach($services as $service)
                                                <option value="{{$service->id}}">{{$service->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('serviceType') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="inputAddress" class="form-label">Description<sup class="text-danger">*</sup></label>
                                        <textarea class="form-control form-control-lg" id="inputAddress" wire:model.live="description" rows="5"></textarea>
                                        @error('description') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputEmail4" class="form-label">Select State<sup class="text-danger">*</sup></label>
                                        <select class="form-control form-control-lg" id="inputState" wire:model.live="state">
                                            <option value="">Select a Location</option>
                                            @foreach($states as $state)
                                                <option value="{{$state->iso2}}">{{$state->name}}</option>
                                            @endforeach
                                        </select>
                                        @error('state') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputCity" class="form-label">City<sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control form-control-lg" id="inputCity" wire:model.live="city">
                                        @error('city') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="inputAddress" class="form-label">Address<sup class="text-danger">*</sup></label>
                                        <textarea class="form-control form-control-lg" id="inputAddress" placeholder="1234 Main St" wire:model.live="address"></textarea>
                                        @error('address') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputCity" class="form-label">Support Phone<sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control form-control-lg" id="inputCity" wire:model.live="phone">
                                        @error('phone') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputCity" class="form-label">Support Email<sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control form-control-lg" id="inputCity" wire:model.live="email">
                                        @error('email') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Return Policy<i class="ri-information-fill" datat-bs-toggle="tooltip"
                                                                   title="This is a necessary protection for your product order"></i> </label>
                                            <textarea wire:model.live="returnPolicy" class="form-control summernote form-control-lg" cols="30" rows="5"></textarea>
                                        </div>
                                        @error('returnPolicy') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Refund Policy<i class="ri-information-fill" datat-bs-toggle="tooltip"
                                                                   title="This is a necessary protection for your product order"></i> </label>
                                            <textarea wire:model.live="refundPolicy" class="form-control summernote form-control-lg" cols="30" rows="5"></textarea>
                                        </div>
                                        @error('refundPolicy') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-lg-12">
                                        <div class="form-group">
                                            <label>Your Store Logo</label>
                                            <div class="file-upload">
                                                <input class="form-control" type="file" accept="image/*" wire:model.live="logo">
                                            </div>
                                        </div>
                                        @error('logo') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-12">
                                        <div class="d-flex align-items-center flex-wrap gap-28">
                                            <div class="form-switch switch-primary d-flex align-items-center gap-3">
                                                <input class="form-check-input" type="checkbox" role="switch" id="yes" wire:model.live="verifyBusiness">
                                                <label class="form-check-label line-height-1 fw-medium text-secondary-light" for="yes">
                                                    Verify Business Instantly
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-outline-success-600">
                                        <span>
                                            Initialize
                                            <div wire:loading>
                                                <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                            </div>
                                        </span>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        @endif
    @endif
    @if($showVerifyBusinessForm)
        @if($staff->can('create UserStoreVerification'))
            <div class="card">
                <div class="product-area card-body">
                    <div class="container-fluid">

                        <div class="submit-property-area">
                            <div class="container-fluid">
                                <form class="row g-3" id="processForm" wire:submit.prevent="submitKYC" enctype="multipart/form-data">
                                    <div class="col-md-6">
                                        <label for="inputState" class="form-label">Legal Business Name<sup class="text-danger">*</sup>
                                            <i class="ri-information-fill"
                                               data-bs-toggle="tooltip" title="Name of store as it appeared on the Registration Certificate"></i> </label>
                                        <input type="text" class="form-control" id="inputState" name="legalName"  wire:model.live="legalName">
                                        @error('legalName') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="inputAddress" class="form-label">Registration Certificate<sup class="text-danger">*</sup></label>
                                        <input type="file" class="form-control" id="inputAddress"
                                               wire:model.live="regCert">
                                        @error('regCert') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6 idNumber" id="idNumber">
                                        <label for="inputAddress" class="form-label">Registration Number<sup class="text-danger">*</sup></label>
                                        <input type="text" class="form-control" id="inputAddress" placeholder="xxxx-xxxx-xxxx"
                                               wire:model.live="regNumber">
                                        @error('regNumber') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-6 idNumber" id="idNumber">
                                        <label for="inputAddress" class="form-label">Doing Business As (DBA)</label>
                                        <input type="text" class="form-control" id="inputAddress" placeholder="{{$store->name}}"
                                               wire:model.live="doingBusinessAs">
                                        @error('doingBusinessAs') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="inputAddress" class="form-label">Address</label>
                                        <textarea type="text" class="form-control" id="inputAddress"
                                                  placeholder="1234 Main St" wire:model.live="address" >{{$store->address}}</textarea>
                                        @error('address') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-12">
                                        <label for="inputAddress" class="form-label">Proof of Address</label>
                                        <input type="file" class="form-control" id="inputAddress" wire:model.live="addressProof">
                                        @error('addressProof') <span class="error text-danger">{{ $message }}</span> @enderror
                                    </div>
                                    <div class="col-md-12 text-center mt-3">
                                        <button class="btn btn-outline-primary" type="submit">
                                            <span>
                                                Submit
                                                <div wire:loading>
                                                    <span class="spinner-border spinner-border-sm ms-2" role="status" aria-hidden="true"></span>
                                                </div>
                                            </span>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endif
    @endif
    @if($showStoreDetail)
        @if($staff->can('read UserStore'))

            <div class="row gy-4">
                <div class="col-lg-6 mx-auto">
                    <div class="user-grid-card position-relative border radius-16 overflow-hidden bg-base h-100">
                        <img src="{{ asset('staff/images/user-grid/user-grid-bg1.png') }}" alt=""
                             class="w-100 object-fit-cover">
                        <div class="pb-24 ms-16 mb-24 me-16  mt--100">
                            <div class="text-center border border-top-0 border-start-0 border-end-0">
                                <img src="{{ $store->logo??'https://ui-avatars.com/api/?rounded=true&name='.$store->name }}"
                                     alt=""
                                     class="border br-white border-width-2-px w-200-px h-200-px rounded-circle object-fit-cover">
                                <h6 class="mb-0 mt-16">{{ $store->name }}</h6>
                                <span class="text-secondary-light mb-16">{{ $store->email }}</span>
                            </div>
                            <div class="mt-24">
                                <h6 class="text-xl mb-16">Store Info</h6>
                                <ul>
                                    <li class="d-flex align-items-center gap-1 mb-12">
                                        <span class="w-30 text-md fw-semibold text-primary-light">Store Name</span>
                                        <span class="w-70 text-secondary-light fw-medium">: {{ $store->name }}</span>
                                    </li>
                                    <li class="d-flex align-items-center gap-1 mb-12">
                                        <span class="w-30 text-md fw-semibold text-primary-light"> Legal Name</span>
                                        <span class="w-70 text-secondary-light fw-medium">: {{ $option->fetchStoreKYB($store->id)->legalName??'N/A' }}</span>
                                    </li>
                                    <li class="d-flex align-items-center gap-1 mb-12">
                                        <span class="w-30 text-md fw-semibold text-primary-light"> Doing Business As</span>
                                        <span class="w-70 text-secondary-light fw-medium">: {{ $option->fetchStoreKYB($store->id)->dba??'N/A' }}</span>
                                    </li>

                                    <li class="d-flex align-items-center gap-1 mb-12">
                                        <span class="w-30 text-md fw-semibold text-primary-light"> Email</span>
                                        <span class="w-70 text-secondary-light fw-medium">: {{ $store->email }}</span>
                                    </li>
                                    <li class="d-flex align-items-center gap-1 mb-12">
                                        <span class="w-30 text-md fw-semibold text-primary-light"> Phone Number</span>
                                        <span class="w-70 text-secondary-light fw-medium">: {{ $store->phone??'N/A' }}</span>
                                    </li>
                                    <li class="d-flex align-items-center gap-1 mb-12">
                                        <span class="w-30 text-md fw-semibold text-primary-light"> Country:</span>
                                        <span class="w-70 text-secondary-light fw-medium">: {{ $option->fetchCountryIso2($store->country)->name }}</span>
                                    </li>

                                    <li class="d-flex align-items-center gap-1 mb-12">
                                        <span class="w-30 text-md fw-semibold text-primary-light"> Address:</span>
                                        <span class="w-70 text-secondary-light fw-medium">: {{ $store->address??'N/A' }}</span>
                                    </li>


                                    <li class="d-flex align-items-center gap-1 mb-12">
                                        <span class="w-30 text-md fw-semibold text-primary-light"> State:</span>
                                        <span class="w-70 text-secondary-light fw-medium">: {{ $option->fetchState($store->country,$store->state)->name??'N/A' }}</span>
                                    </li>
                                    <li class="d-flex align-items-center gap-1 mb-12">
                                        <span class="w-30 text-md fw-semibold text-primary-light"> KYB Status</span>
                                        <span class="w-70 text-secondary-light fw-medium">:
                                         @switch($store->isVerified)
                                                @case(1)
                                                    <span class="badge text-sm fw-semibold bg-dark-success-gradient px-20 py-9 radius-4 text-white">
                                                        Verified
                                                    </span>
                                                    @break
                                                @case(4)
                                                    <span class="badge text-sm fw-semibold bg-dark-primary-gradient px-20 py-9 radius-4 text-white">Under Review</span>
                                                    @break
                                                @default
                                                    <span class="badge text-sm fw-semibold bg-dark-lilac-gradient px-20 py-9 radius-4 text-white">Pending Submission/Rejected</span>
                                                    @break
                                            @endswitch
                                        </span>
                                    </li>
                                    <li class="d-flex align-items-center gap-1">
                                        <span class="w-30 text-md fw-semibold text-primary-light"> Description</span>
                                        <span class="w-70 text-secondary-light fw-medium">:
                                    {!! $store->description !!}
                                </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <!-- Statistics -->
                        <div class="col-xl-12 mb-4 col-lg-12 col-12">
                            <div class="card h-auto">
                                <div class="card-header d-flex flex-wrap align-items-center justify-content-between gap-3">
                                    <div class="d-flex flex-wrap align-items-center gap-3">
                                        <h6 class="text-lg fw-semibold mb-0">Statistics</h6>
                                    </div>
                                    <div class="d-flex flex-wrap align-items-center gap-3">
                                        <h6 class="text-lg fw-semibold mb-0">
                                            <a href="{{route('merchant.store',['subdomain'=>$store->slug])}}" target="_blank"><i class="ri-eye-line" data-bs-toggle="tooltip"
                                                                                                                                 title="View Store"></i> </a>
                                        </h6>
                                    </div>
                                </div>
                                <div class="card-body g-5 d-flex flex-wrap">
                                    <div class="row gy-3">
                                        <div class="col-md-6 col-6">
                                            <div class="d-flex align-items-center">
                                                <div class="badge rounded-pill bg-label-primary me-3 p-2"><i class="ti ti-chart-pie-2 ti-sm"></i></div>
                                                <div class="card-info">
                                                    <h5 class="mb-0">{{$option->formatNumber($option->numberOfSalesInStore($store->id))}}</h5>
                                                    <small>Total Sales<i class="ri-information-fill" data-bs-toggle="tooltip"
                                                                         title="Total number of orders received - which includes ony successfully processed orders where the status
                                            has updated to completed."></i> </small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-6">
                                            <div class="d-flex align-items-center">
                                                <div class="badge rounded-pill bg-label-success me-3 p-2"><i class="ti ti-currency-dollar ti-sm"></i></div>
                                                <div class="card-info">
                                                    <h5 class="mb-0">{{$option->fetchCurrencySign($store->currency)->currency_symbol}}{{$option->formatNumber($option->invoiceRevenueInStore($store->id))}} </h5>
                                                    <small>Invoice Revenue<i class="ri-information-fill" data-bs-toggle="tooltip"
                                                                             title="Total sum of money earned through invoices. This only accounts for invoices whose payment was processed through
                                                         this platform not offline payments."></i></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-6">
                                            <div class="d-flex align-items-center">
                                                <div class="badge rounded-pill bg-label-success me-3 p-2"><i class="ti ti-currency-dollar ti-sm"></i></div>
                                                <div class="card-info">
                                                    <h5 class="mb-0">{{$option->fetchCurrencySign($store->currency)->currency_symbol}}{{$option->formatNumber($option->revenueInStore($store->id))}} </h5>
                                                    <small>Revenue<i class="ri-information-fill" data-bs-toggle="tooltip"
                                                                     title="Total sum of money earned through your stores. This only accounts for sales which was marked as completed."></i></small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-6">
                                            <div class="d-flex align-items-center">
                                                <div class="badge rounded-pill bg-label-info me-3 p-2"><i class="ti ti-users ti-sm"></i></div>
                                                <div class="card-info">
                                                    <h5 class="mb-0">{{$option->formatNumber($option->numberOfCustomersInStore($store->id))}}</h5>
                                                    <small>Customers</small>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6 col-6">
                                            <div class="d-flex align-items-center">
                                                <div class="badge rounded-pill bg-label-danger me-3 p-2"><i class="ti ti-shopping-cart ti-sm"></i></div>
                                                <div class="card-info">
                                                    <h5 class="mb-0">{{$option->numberOfProductInStore($store->id)}}</h5>
                                                    <small>Products</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--/ Statistics -->

                        <div class="col-lg-12 mx-auto mt-3">
                            <div class="container-fluid" style="margin-bottom: 5rem;">


                                @can('read UserStoreCoupon')
                                    <div class="card shadow mb-3">
                                        <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                                            <div class="flex-grow-1 mb-3 mb-md-0">
                                                <h5 class="card-title">
                                                    <i class="ri-apps-2-fill"></i> Merchant Store Coupons
                                                </h5>
                                                <p class="card-text" style="word-break: break-word;">
                                                    View all merchant's coupons - <i class="ri-information-fill" data-bs-toggle="tooltip"
                                                                                     title="View merchant's settings"></i>
                                                </p>
                                            </div>
                                            <a href="{{route('staff.stores.coupons',['id'=>$store->reference])}}" wire:navigate
                                               class="btn btn-outline-primary rounded-pill btn-sm small-button">
                                                Manage
                                            </a>
                                        </div>
                                    </div>
                                @endcan
                                @can('read UserStoreCustomer')
                                    <div class="card shadow mb-3">
                                        <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                                            <div class="flex-grow-1 mb-3 mb-md-0">
                                                <h5 class="card-title">
                                                    <i class="ri-apps-2-fill"></i> Merchant Store Customer
                                                </h5>
                                                <p class="card-text" style="word-break: break-word;">
                                                    View all merchant's customers - <i class="ri-information-fill" data-bs-toggle="tooltip"
                                                                                       title="View merchant's customers"></i>
                                                </p>
                                            </div>
                                            <a href="{{route('staff.stores.customers',['id'=>$store->reference])}}" wire:navigate
                                               class="btn btn-outline-primary rounded-pill btn-sm small-button">
                                                Manage
                                            </a>
                                        </div>
                                    </div>
                                @endcan
                                @can('read UserStoreInvoice')
                                    <div class="card shadow mb-3">
                                        <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                                            <div class="flex-grow-1 mb-3 mb-md-0">
                                                <h5 class="card-title">
                                                    <i class="ri-apps-2-fill"></i> Merchant Store invoices
                                                </h5>
                                                <p class="card-text" style="word-break: break-word;">
                                                    View all merchant's invoices - <i class="ri-information-fill" data-bs-toggle="tooltip"
                                                                                      title="View merchant's customers"></i>
                                                </p>
                                            </div>
                                            <a href="{{route('staff.stores.invoices',['id'=>$store->reference])}}" wire:navigate class="btn btn-outline-primary rounded-pill btn-sm small-button">
                                                Manage
                                            </a>
                                        </div>
                                    </div>
                                @endcan
                                @can('read UserStoreOrder')
                                    <div class="card shadow mb-3">
                                        <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                                            <div class="flex-grow-1 mb-3 mb-md-0">
                                                <h5 class="card-title">
                                                    <i class="ri-apps-2-fill"></i> Merchant Store Products
                                                </h5>
                                                <p class="card-text" style="word-break: break-word;">
                                                    View all merchant's products - <i class="ri-information-fill" data-bs-toggle="tooltip"
                                                                                      title="View merchant's products"></i>
                                                </p>
                                            </div>
                                            <a href="{{route('staff.stores.products',['id'=>$store->reference])}}" wire:navigate class="btn btn-outline-primary rounded-pill btn-sm small-button">
                                                Manage
                                            </a>
                                        </div>
                                    </div>
                                @endcan
                                @can('read UserStoreCatalogCategory')
                                    <div class="card shadow mb-3">
                                        <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                                            <div class="flex-grow-1 mb-3 mb-md-0">
                                                <h5 class="card-title">
                                                    <i class="ri-apps-2-fill"></i> Merchant Store Product Category
                                                </h5>
                                                <p class="card-text" style="word-break: break-word;">
                                                    View all merchant's product category - <i class="ri-information-fill"
                                                                                              data-bs-toggle="tooltip" title="View merchant's product category"></i>
                                                </p>
                                            </div>
                                            <a href="{{route('staff.stores.categories',['id'=>$store->reference])}}" wire:navigate class="btn btn-outline-primary rounded-pill btn-sm small-button">
                                                Manage
                                            </a>
                                        </div>
                                    </div>
                                @endcan
                                @can('read UserStoreOrder')
                                    <div class="card shadow mb-3">
                                        <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                                            <div class="flex-grow-1 mb-3 mb-md-0">
                                                <h5 class="card-title">
                                                    <i class="ri-apps-2-fill"></i> Merchant Store Orders
                                                </h5>
                                                <p class="card-text" style="word-break: break-word;">
                                                    View all merchant's orders - <i class="ri-information-fill"
                                                                                              data-bs-toggle="tooltip" title="View merchant's product category"></i>
                                                </p>
                                            </div>
                                            <a href="{{route('staff.stores.orders',['id'=>$store->reference])}}" wire:navigate class="btn btn-outline-primary rounded-pill btn-sm small-button">
                                                Manage
                                            </a>
                                        </div>
                                    </div>
                                @endcan

                                @can('read UserStoreSetting')
                                    <div class="card shadow mb-3">
                                        <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                                            <div class="flex-grow-1 mb-3 mb-md-0">
                                                <h5 class="card-title">
                                                    <i class="ri-apps-2-fill"></i> Merchant Store Setting
                                                </h5>
                                                <p class="card-text" style="word-break: break-word;">
                                                    View all merchant's store setting - <i class="ri-information-fill"
                                                                                           data-bs-toggle="tooltip" title="View merchant's product category"></i>
                                                </p>
                                            </div>
                                            <a href="#" wire:navigate class="btn btn-outline-primary rounded-pill btn-sm small-button">
                                                Manage
                                            </a>
                                        </div>
                                    </div>
                                @endcan
                                @can(['create UserVerification','update UserVerification'])
                                    <div class="card shadow mb-3">
                                        <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
                                            <div class="flex-grow-1 mb-3 mb-md-0">
                                                <h5 class="card-title">
                                                    <i class="ri-apps-2-fill"></i> Store KYB
                                                </h5>
                                                <p class="card-text" style="word-break: break-word;">
                                                    Manage Merchant KYB - <i class="ri-information-fill" data-bs-toggle="tooltip"
                                                                             title="Edit Merchant Information"></i>
                                                </p>
                                            </div>
                                            <a href="#" wire:navigate class="btn btn-outline-primary rounded-pill btn-sm small-button">
                                                Manage
                                            </a>
                                        </div>
                                    </div>
                                @endcan
                            </div>
                        </div>
                    </div>

                </div>

            </div>

        @endif
    @endif
</div>
