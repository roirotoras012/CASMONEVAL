<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion" style="background: #fff;">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    {{-- <div class="sb-sidenav-menu-heading">Core</div> --}}
                    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"
                        href="#!"><i class="fas fa-bars"></i></button>
                    <div class="pb-5 px-5 pt-5"><img style="height:150px;width: auto; object-fit: contain;"
                            src="{{ url('/images/dti-logo.png') }}" /></div>
                    {{ Request::is('rd/dashboard') ? 'active' : '' }}
                    <a class="nav-link  {{ Request::is('dc/dashboard') ? 'active' : '' }}"
                        href="{{ url('dc/dashboard') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>

                        Dashboard
                    </a>

                    {{-- <div class="sb-sidenav-menu-heading">Interface</div> --}}
                    <a class="nav-link  {{ Request::is('dc/job-fam') ? 'active' : '' }}"
                        href="{{ url('dc/job-fam') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-users"></i></div>
                        Job Family Shopping

                    </a>

                    <a class="nav-link  {{ Request::is('dc/accomplishment') ? 'active' : '' }}"
                        href="{{ url('dc/accomplishment') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-file-contract"></i></div>
                        Add Accompishment

                    </a>

                    <a class="nav-link  {{ Request::is('dc/coaching') ? 'active' : '' }}" href="{{ url('dc/coaching') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-calendar-plus"></i></div>
                        Coaching and Mentoring
                       
                    </a>

                    {{-- <div class="sb-sidenav-menu-heading">Addons</div> --}}
                    <a class="nav-link  {{ Request::is('dc/profile') ? 'active' : '' }}" href="{{ url('dc/profile') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                        My Profile
                    </a>
                    <a class="nav-link" href="{{ url('/') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-right-from-bracket"></i></div>
                        Logout
                    </a>

                </div>
            </div>
            {{-- <div class="sb-sidenav-footer">
                <div class="small">Logged in as:</div>
                Start Bootstrap
            </div> --}}
        </nav>
    </div>
    <div id="layoutSidenav_content">
        {{ $slot }}
    </div>
</div>