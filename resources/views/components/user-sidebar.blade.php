<div id="layoutSidenav">
    <div id="layoutSidenav_nav">
        <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion" style="background: #fff !important;">
            <div class="sb-sidenav-menu">
                <div class="nav">
                    {{-- <div class="sb-sidenav-menu-heading">Core</div> --}}
                    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0" id="sidebarToggle"
                        href="#!"><i class="fas fa-bars"></i></button>
                    <div class="pb-5 px-5 pt-5"><img style="height:150px;width: auto; object-fit: contain;"
                            src="{{ url('/images/dti-logo.png') }}" /></div>
                    {{-- RD SIDENAV  --}}
                    @if (auth()->user()->user_type_ID == '1')
                        <a class="nav-link  {{ Request::is('rd/dashboard') ? 'active' : '' }}"
                            href="{{ url('rd/dashboard') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>

                            Dashboard
                        </a>

                        {{-- <div class="sb-sidenav-menu-heading">Interface</div> --}}
                        <a class="nav-link  {{ Request::is('rd/opcr-target') ? 'active' : '' }}"
                            href="{{ url('rd/opcr-target') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-columns"></i></div>
                            OPCR Target

                        </a>

                        <a class="nav-link  {{ Request::is('rd/assessment') ? 'active' : '' }}"
                            href="{{ url('rd/assessment') }}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-table"></i></div>
                            Performance Assessment

                        </a>

                        {{-- <div class="sb-sidenav-menu-heading">Addons</div> --}}
                        <a class="nav-link  {{ Request::is('rd/profile') ? 'active' : '' }}"
                            href="{{ url('rd/profile') }}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                            My Profile
                        </a>
                    {{-- RPO SIDENAV --}}
                    @elseif (auth()->user()->user_type_ID == '2')
                        <a class="nav-link  {{ Request::is('rpo/dashboard') ? 'active' : '' }}"
                            href="{{ url('rpo/dashboard') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>

                            Dashboard
                        </a>


                        <a class="nav-link  {{ Request::is('rpo/addtarget') ? 'active' : '' }}"
                            href="{{ url('rpo/addtarget') }}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-calendar-plus"></i></div>
                            Add Target

                        </a>

                        <a class="nav-link  {{ Request::is('rpo/savedtarget') ? 'active' : '' }}"
                            href="{{ url('rpo/savedtarget') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-save"></i></div>
                            Saved Target

                        </a>

                        <a class="nav-link  {{ Request::is('rpo/assessment') ? 'active' : '' }}"
                            href="{{ url('rpo/assessment') }}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-table"></i></div>
                            Performance Assessment

                        </a>



                        {{-- <div class="sb-sidenav-menu-heading">Addons</div> --}}
                        <a class="nav-link  {{ Request::is('rpo/profile') ? 'active' : '' }}"
                            href="{{ url('rpo/profile') }}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                            My Profile
                        </a>
                    {{-- PD SIDENAV --}}
                    @elseif (auth()->user()->user_type_ID == '3')
                        <a class="nav-link  {{ Request::is('pd/dashboard') ? 'active' : '' }}"
                            href="{{ url('pd/dashboard') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>

                            Dashboard
                        </a>


                        <a class="nav-link  {{ Request::is('pd/addtarget') ? 'active' : '' }}"
                            href="{{ url('pd/addtarget') }}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-calendar-plus"></i></div>
                            Add Target

                        </a>

                        <a class="nav-link  {{ Request::is('pd/savetarget') ? 'active' : '' }}"
                            href="{{ url('pd/savetarget') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-save"></i></div>
                            Save Target

                        </a>

                        <a class="nav-link  {{ Request::is('pd/accomplishment') ? 'active' : '' }}"
                            href="{{ url('pd/accomplishment') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-contract"></i></div>
                            Add Accomplishment

                        </a>

                        <a class="nav-link  {{ Request::is('pd/assessment') ? 'active' : '' }}"
                            href="{{ url('pd/assessment') }}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-table"></i></div>
                            Performance Assessment

                        </a>



                        {{-- <div class="sb-sidenav-menu-heading">Addons</div> --}}
                        <a class="nav-link  {{ Request::is('pd/profile') ? 'active' : '' }}"
                            href="{{ url('pd/profile') }}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                            My Profile
                        </a>
                    {{-- PPO SIDENAV  --}}
                    @elseif (auth()->user()->user_type_ID == '4')
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
                            Saved Target

                        </a>

                        <a class="nav-link  {{ Request::is('ppo/accomplishment') ? 'active' : '' }}"
                            href="{{ url('ppo/accomplishment') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-contract"></i></div>
                            Add Accomplishment

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
                    {{-- DC SIDENAV --}}
                    @else
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

                        <a class="nav-link  {{ Request::is('dc/coaching') ? 'active' : '' }}"
                            href="{{ url('dc/coaching') }}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-calendar-plus"></i></div>
                            Coaching and Mentoring

                        </a>

                        {{-- <div class="sb-sidenav-menu-heading">Addons</div> --}}
                        <a class="nav-link  {{ Request::is('dc/profile') ? 'active' : '' }}"
                            href="{{ url('dc/profile') }}">
                            <div class="sb-nav-link-icon"><i class="fa-solid fa-user"></i></div>
                            My Profile
                        </a>
                    @endif
                    <button type="button" class="btn btn-primary mt-5 mx-2" data-toggle="modal"
                        data-target="#logout-modal">
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
        <!-- Modal -->
        <x-modal-logout />
    </div>
</div>
