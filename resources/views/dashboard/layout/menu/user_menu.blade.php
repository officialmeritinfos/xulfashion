<li>
    <a href="{{route('user.account.index')}}" class="box-style">
        <i class="bx bx-money"></i>
        <span class="menu-title">Account</span>
    </a>
</li>
<li>
    <a href="{{route('user.ads.index')}}" class="box-style">
        <i class="ri-table-alt-line"></i>
        <span class="menu-title">ADs</span>
    </a>
</li>
<li>
    <a href="{{route('user.stores.index')}}" class="box-style">
        <i class="ri-store-2-fill"></i>
        <span class="menu-title">Store</span>
    </a>
</li>
<li>
    <a href="{{route('marketplace.index',['country'=>$user->countryCode])}}" target="_blank" class="box-style">
        <i class="ri-user-settings-fill"></i>
        <span class="menu-title">Marketplace</span>
    </a>
</li>
<li>
    <a href="{{route('user.settings.index')}}" class="box-style">
        <i class="ri-settings-2-line"></i>
        <span class="menu-title">Settings</span>
    </a>
</li>


