<ul class="account-nav-list">
    <li><a href="{{ route('user.index') }}" class="account-nav-link {{ request()->routeIs('user.index') ? 'active' : '' }}">Dashboard</a></li>
    <li><a href="{{ route('user.orders') }}" class="account-nav-link {{ request()->routeIs('user.orders*') ? 'active' : '' }}">Orders</a></li>
    <li><a href="{{ route('user.addresses') }}" class="account-nav-link {{ request()->routeIs('user.addresses') ? 'active' : '' }}">Addresses</a></li>
    <li><a href="{{ route('user.account.details') }}" class="account-nav-link {{ request()->routeIs('user.account.details') ? 'active' : '' }}">Account Details</a></li>
    <li><a href="{{ route('wishlist.index') }}" class="account-nav-link {{ request()->routeIs('wishlist.index') ? 'active' : '' }}">Wishlist</a></li>
    <li>
        <form method="POST" action="{{ route('logout') }}" id="logout-form" style="display: none;">
            @csrf
        </form>
        <a href="{{ route('logout') }}" class="account-nav-link" 
           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Logout
        </a>
    </li>
</ul>