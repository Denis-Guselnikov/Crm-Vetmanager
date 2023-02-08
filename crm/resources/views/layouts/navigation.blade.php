<nav x-data="{ open: false }" class="bg-white border-b border-gray-100">

    <div class="container">
        <div class="row">
            <div class="col-4">
                <h1>CRM-Vetmanager</h1>
            </div>
            <div class="col-8">
                <ul>
                    <li>Name: {{ Auth::user()->name }}</li>
                    <li>Email: {{ Auth::user()->email }}</li>
                    <li>
                        <div class="">
                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-responsive-nav-link :href="route('logout')"
                                                       onclick="event.preventDefault();
                                        this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-responsive-nav-link>
                            </form>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</nav>
