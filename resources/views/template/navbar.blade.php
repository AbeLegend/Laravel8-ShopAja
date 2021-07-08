<nav class="bg-gray-700">
  <div class="flex flex-col lg:flex-row container mx-auto">
    <div class="flex items-center justify-between px-4 py-4 lg:py-0 border-b lg:border-b-0 border-gray-500">
      <div><a href="#" class="uppercase font-semibold text-white">Brand</a></div>
      <div>
        <button class="focus:out-of-range: text-white block lg:hidden" onclick="toggleNavbar()">
            <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
              <path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM9 15a1 1 0 011-1h6a1 1 0 110 2h-6a1 1 0 01-1-1z" clip-rule="evenodd" />
            </svg>
        </button>
      </div>
    </div>
    <div class="lg:flex flex-col lg:flex-row justify-between w-full py-4 lg:py-0 hidden" id="nav_item">
      <div class="flex flex-col lg:flex-row">
        @if (Route::has('login'))
          @auth
          <a href="#" class="block px-4 py-3 lg:py-5 text-gray-300 hover:text-white">Home</a>
          <a href="#" class="block px-4 py-3 lg:py-5 text-gray-300 hover:text-white">Item</a>
          <a href="#" class="block px-4 py-3 lg:py-5 text-gray-300 hover:text-white">Transaction</a>
          @endauth
        @else          

        @endif
      </div>
      <div class="flex flex-col lg:flex-row">
        @if (Route::has('login'))
          @auth
              <a href="{{ url('/') }}" class="block px-4 py-3 lg:py-5 text-gray-300 hover:text-white">Profile</a>
              <a href="{{ route('logout') }}" class="block px-4 py-3 lg:py-5 text-gray-300 hover:text-white" onclick="event.preventDefault();document.getElementById('logout-form').submit();">Logout</a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                  @csrf
              </form>
          @else
              <a href="{{ route('login') }}" class="block px-4 py-3 lg:py-5 text-gray-300 hover:text-white">Sign in</a>

              @if (Route::has('register'))
                  <a href="{{ route('register') }}" class="block px-4 py-3 lg:py-5 text-gray-300 hover:text-white">Sign up</a>
              @endif
          @endauth
        @endif
      </div>
    </div>
  </div>
</nav>
