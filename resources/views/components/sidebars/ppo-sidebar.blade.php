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
                    {{ Request::is('ppo/dashboard') ? 'active' : '' }}
                    <a class="nav-link  {{ Request::is('ppo/dashboard') ? 'active' : '' }}"
                        href="{{ url('ppo/dashboard') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>

                        Dashboard
                    </a>


                    <a class="nav-link  {{ Request::is('ppo/addtarget') ? 'active' : '' }}"
                        href="{{ url('ppo/addtarget') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-calendar-plus"></i></div>
                        Add Target

                    </a>

                    <a class="nav-link  {{ Request::is('ppo/savetarget') ? 'active' : '' }}"
                        href="{{ url('ppo/savetarget') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-save"></i></div>
                        Add Driver

                    </a>

                    <a class="nav-link  {{ Request::is('ppo/accomplishment') ? 'active' : '' }}"
                        href="{{ url('ppo/accomplishment') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-file-contract"></i></div>
                        Manage Strategic Measure Group

                    </a>

                    <a class="nav-link  {{ Request::is('ppo/assessment') ? 'active' : '' }}"
                        href="{{ url('ppo/assessment') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-table"></i></div>
                        Performance Assessment

                    </a>



                    {{-- <div class="sb-sidenav-menu-heading">Addons</div> --}}
                    <a class="nav-link  {{ Request::is('ppo/profile') ? 'active' : '' }}"
                        href="{{ url('ppo/profile') }}">
                        <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                        My Profile
                    </a>
                     <button type="button" class="btn btn-primary mt-5 mx-2" data-toggle="modal" data-target="#logout-modal">
                        Logout
                    </button>

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
        <x-modal-logout/>
    </div>
</div>