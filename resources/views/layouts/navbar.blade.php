<div class="top-navbar d-flex justify-content-between align-items-center">

  <!-- LEFT -->
  <div class="d-flex align-items-center">

    <i class="fas fa-bars sidebar-toggle me-3 mr-2"
       onclick="toggleSidebar()"
       style="cursor:pointer"></i>

    <strong class="mb-0">@yield('title')</strong>

  </div>

  <!-- RIGHT -->
  <div class="d-flex align-items-center">

    <!-- DARK MODE -->
    <button onclick="toggleDark()" class="btn btn-sm btn-light me-3">
      <i class="fas fa-moon"></i>
    </button>

    <!-- USER -->
    <div class="dropdown">

      <a class="d-flex align-items-center text-decoration-none dropdown-toggle"
         data-bs-toggle="dropdown"
         style="cursor:pointer">

        <img src="https://i.pravatar.cc/40"
             width="32"
             height="32"
             class="rounded-circle me-2 mr-1">

        <span>{{ auth()->user()->name ?? 'User' }}</span>

      </a>

      <ul class="dropdown-menu dropdown-menu-end shadow">

        <li>
          <a class="dropdown-item" href="#">
            <i class="fas fa-user me-2"></i> Profile
          </a>
        </li>

        <li><hr class="dropdown-divider"></li>

        <li>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button class="dropdown-item text-danger">
              <i class="fas fa-sign-out-alt me-2"></i> Logout
            </button>
          </form>
        </li>

      </ul>

    </div>

  </div>

</div>
