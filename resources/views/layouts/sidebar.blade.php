<div class="d-none d-md-flex flex-column flex-shrink-0 p-3 bg-white" style="width: 250px; height: 100vh; border-right: 1px solid #dee2e6;">
    <a href="/" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-dark text-decoration-none">
        @include('components.logo')
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        @auth
            @if(auth()->user()->role->slug == 'admin')
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : 'link-dark' }}" aria-current="page">
                        <i class="bi bi-speedometer2 me-2"></i>
                        Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : 'link-dark' }}">
                        <i class="bi bi-people me-2"></i>
                        Users
                    </a>
                <li class="nav-item">
                    <a href="{{ route('admin.categories.index') }}" class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : 'link-dark' }}">
                        <i class="bi bi-tags me-2"></i>
                        Categories
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.reports.index') }}" class="nav-link {{ request()->routeIs('admin.reports.index') ? 'active' : 'link-dark' }}">
                        <i class="bi bi-file-earmark-bar-graph me-2"></i>
                        Reports
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.attendance.index') }}" class="nav-link {{ request()->routeIs('admin.attendance.*') ? 'active' : 'link-dark' }}">
                        <i class="bi bi-calendar-check me-2"></i>
                        Attendance
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.fees.index') }}" class="nav-link {{ request()->routeIs('admin.fees.*') ? 'active' : 'link-dark' }}">
                        <i class="bi bi-cash-stack me-2"></i>
                        Fees
                    </a>
                </li>
            @elseif(auth()->user()->role->slug == 'staff')
                <li class="nav-item">
                    <a href="{{ route('staff.dashboard') }}" class="nav-link {{ request()->routeIs('staff.dashboard') ? 'active' : 'link-dark' }}">
                        <i class="bi bi-check-circle me-2"></i>
                        Verification
                    </a>
                </li>
            @elseif(auth()->user()->role->slug == 'student')
                <li class="nav-item">
                    <a href="{{ route('student.dashboard') }}" class="nav-link {{ request()->routeIs('student.dashboard') ? 'active' : 'link-dark' }}">
                        <i class="bi bi-grid me-2"></i>
                        My Documents
                    </a>
                </li>
                <li>
                    <a href="{{ route('student.documents.create') }}" class="nav-link {{ request()->routeIs('student.documents.create') ? 'active' : 'link-dark' }}">
                        <i class="bi bi-cloud-upload me-2"></i>
                        Upload
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('student.fees.index') }}" class="nav-link {{ request()->routeIs('student.fees.*') ? 'active' : 'link-dark' }}">
                        <i class="bi bi-wallet2 me-2"></i>
                        My Fees
                    </a>
                </li>
            @endif
        @endauth
        
        @guest
             <li class="nav-item">
                <a href="{{ route('login') }}" class="nav-link link-dark">
                    <i class="bi bi-box-arrow-in-right me-2"></i> Login
                </a>
            </li>
        @endguest
    </ul>
    <hr>
    @auth
    <div class="dropdown">
        <a href="#" class="d-flex align-items-center link-dark text-decoration-none dropdown-toggle" id="dropdownUser2" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="rounded-circle bg-secondary text-white d-flex justify-content-center align-items-center me-2" style="width: 32px; height: 32px;">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            <strong>{{ auth()->user()->name }}</strong>
        </a>
        <ul class="dropdown-menu text-small shadow" aria-labelledby="dropdownUser2">
            <li>
                @php
                    $profileRoute = match(auth()->user()->role->slug) {
                        'admin' => route('admin.profile.show'),
                        'staff' => route('staff.profile.show'),
                        default => route('student.profile.show'),
                    };
                @endphp
                <a href="{{ $profileRoute }}" class="dropdown-item">
                    <i class="bi bi-person-circle me-2"></i> Profile
                </a>
            </li>
            <li><hr class="dropdown-divider"></li>
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="bi bi-box-arrow-right me-2"></i> Sign out
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </li>
        </ul>
    </div>
    @endauth
</div>
