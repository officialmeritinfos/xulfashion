<div class="container py-4">
    <h3 class="text-center mb-4 text-muted">🛍️ Store Management Dashboard</h3>

    <div class="row g-4">

        <!-- Store Catalog Category -->
        <div class="col-12">
            <div class="card dashboard-card h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fa fa-th-list icon-small text-primary"></i>
                        <h5 class="mt-2">Store Catalog Categories</h5>
                        <p>Manage product categories for your store</p>
                    </div>
                    <a href="{{ route('mobile.user.store.catalog.categories') }}" class="btn btn-outline-primary btn-auto">Manage Categories</a>
                </div>
            </div>
        </div>

        <!-- Store Catalog Products -->
        <div class="col-12">
            <div class="card dashboard-card h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fa fa-th-list icon-small text-success"></i>
                        <h5 class="mt-2">Store Products</h5>
                        <p>Manage products for your store</p>
                    </div>
                    <a href="{{ route('mobile.user.store.catalog.products') }}" class="btn btn-outline-success btn-auto">Manage Products</a>
                </div>
            </div>
        </div>

        <!-- Store Orders -->
        <div class="col-12">
            <div class="card dashboard-card h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fa fa-shopping-cart icon-small text-warning"></i>
                        <h5 class="mt-2">Store Orders</h5>
                        <p>Track and manage your store orders.</p>
                    </div>
                    <a href="{{ route('user.stores.orders') }}" class="btn btn-warning btn-auto">Manage Orders</a>
                </div>
            </div>
        </div>

        <!-- Store Invoices -->
        <div class="col-12">
            <div class="card dashboard-card h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fa fa-file-pdf-o icon-small text-danger"></i>
                        <h5 class="mt-2">Store Invoices</h5>
                        <p>Issue and manage invoices for your clients.</p>
                    </div>
                    <a href="{{ route('user.stores.invoices') }}" class="btn btn-danger btn-auto">Manage Invoices</a>
                </div>
            </div>
        </div>

        <!-- Store Customers -->
        <div class="col-12">
            <div class="card dashboard-card h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fa fa-users icon-small text-info"></i>
                        <h5 class="mt-2">Store Customers</h5>
                        <p>View and engage with your customers.</p>
                    </div>
                    <a href="{{ route('user.stores.customers') }}" class="btn btn-info btn-auto">Manage Customers</a>
                </div>
            </div>
        </div>

        <!-- Store Coupons -->
        <div class="col-12">
            <div class="card dashboard-card h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fa fa-ticket icon-small text-secondary"></i>
                        <h5 class="mt-2">Store Coupons</h5>
                        <p>Create and manage discount codes.</p>
                    </div>
                    <a href="{{ route('user.stores.coupons') }}" class="btn btn-secondary btn-auto">Manage Coupons</a>
                </div>
            </div>
        </div>

        <!-- Store Settings -->
        <div class="col-12">
            <div class="card dashboard-card h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fa fa-cog icon-small text-primary"></i>
                        <h5 class="mt-2">Store Settings</h5>
                        <p>Manage your store settings</p>
                    </div>
                    <a href="{{ route('user.stores.edit.settings') }}" class="btn btn-dark btn-auto">Manage Settings</a>
                </div>
            </div>
        </div>

        <!-- Store-front Theme -->
        <div class="col-12">
            <div class="card dashboard-card h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fa fa-paint-brush icon-small text-primary"></i>
                        <h5 class="mt-2">Store-front Theme</h5>
                        <p>Customize your store's appearance and branding.</p>
                    </div>
                    <a href="{{ route('user.stores.themes') }}" class="btn btn-primary btn-auto">Manage Theme</a>
                </div>
            </div>
        </div>


        <!-- Store Verification -->
        <div class="col-12">
            <div class="card dashboard-card h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fa fa-shield icon-small text-success"></i>
                        <h5 class="mt-2">Store Verification</h5>
                        <p>Verify your business for premium features.</p>
                    </div>
                    <a href="{{ route('mobile.user.store.verify') }}" class="btn btn-success btn-auto">Verify Store</a>
                </div>
            </div>
        </div>


        <!-- Store Newsletters -->
        <div class="col-12">
            <div class="card dashboard-card h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fa fa-envelope icon-small text-primary"></i>
                        <h5 class="mt-2">Store Newsletters</h5>
                        <p>Keep your customers updated with newsletters.</p>
                    </div>
                    <button class="btn btn-dark btn-auto" disabled>Coming soon</button>
                </div>
            </div>
        </div>
        <!-- Store Team -->
        <div class="col-12">
            <div class="card dashboard-card h-100">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fa fa-user-plus icon-small text-secondary"></i>
                        <h5 class="mt-2">Store Team</h5>
                        <p>Manage your store team members <span class="badge bg-warning">Coming Soon</span></p>
                    </div>
                    <button class="btn btn-secondary btn-auto" disabled>Coming Soon</button>
                </div>
            </div>
        </div>
    </div>
</div>
