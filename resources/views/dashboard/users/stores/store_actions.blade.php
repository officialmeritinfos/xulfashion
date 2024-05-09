<div class="container-fluid" style="margin-bottom: 5rem;">

    <div class="card shadow mb-3">
        <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
            <div class="flex-grow-1 mb-3 mb-md-0">
                <h5 class="card-title">
                    <i class="ri-bank-line"></i> Store Catalog
                </h5>
                <p class="card-text" style="word-break: break-word;">
                    Manage your store products
                </p>
            </div>
            <a href="{{route('user.settings.payout')}}" class="btn btn-outline-primary rounded-pill btn-sm small-button">
                Manage
            </a>
        </div>
    </div>
    <div class="card shadow mb-3">
        <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
            <div class="flex-grow-1 mb-3 mb-md-0">
                <h5 class="card-title">
                    <i class="ri-user-settings-line"></i> Store Info
                </h5>
                <p class="card-text" style="word-break: break-word;">
                    Manage your store information
                </p>
            </div>
            <a href="{{route('user.settings.portfolio')}}" class="btn btn-outline-primary rounded-pill btn-sm small-button">
                Manage
            </a>
        </div>
    </div>

    <div class="card shadow mb-3">
        <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
            <div class="flex-grow-1 mb-3 mb-md-0">
                <h5 class="card-title">
                    <i class="ri-settings-2-line"></i> Basic Setting
                </h5>
                <p class="card-text" style="word-break: break-word;">
                    Manage your store settings
                </p>
            </div>
            <a href="{{route('user.settings.basic')}}" class="btn btn-outline-primary rounded-pill btn-sm small-button">
                Manage
            </a>
        </div>
    </div>


    <div class="card shadow mb-3">
        <div class="card-body d-flex flex-wrap justify-content-between align-items-center">
            <div class="flex-grow-1 mb-3 mb-md-0">
                <h5 class="card-title">
                    <i class="ri-shield-check-fill"></i> Store Verification
                </h5>
                <p class="card-text" style="word-break: break-word;">
                    Manage your Store KYB
                </p>
            </div>
            <a href="{{route('user.stores.verify')}}" class="btn btn-outline-primary rounded-pill btn-sm small-button">
                Manage
            </a>
        </div>
    </div>


</div>
