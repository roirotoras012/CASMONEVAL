@props(['users'])

<div id="updatemodal-{{ $users->user_ID }}" class="modal fade modal-update-rpo" data-update-id="{{$users->user_ID }}">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header flex-column">
                <div class="icon-box">
                    <i class="fa-solid fa-pen"></i>
                </div>
                <h4 class="modal-title w-100">Update {{ $users->first_name }}</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="input-group input-group-sm mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i
                                class="p-1 fa-solid fa-user"></i>
                        </span>
                    </div>
                    <input value="{{ $users->first_name }}" placeholder="Firstname" id="first_name" type="text"
                        class="form-control @error('first_name') is-invalid @enderror" name="first_name"
                        autocomplete="first_name" autofocus>
                    @error('first_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group input-group-sm mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i
                                class="p-1 fa-solid fa-user"></i>
                        </span>
                    </div>
                    <input value="{{ $users->last_name }}" placeholder="Lastname" id="last_name" type="text"
                        class="form-control @error('last_name') is-invalid @enderror" name="last_name"
                        autocomplete="last_name" autofocus>
                    @error('last_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group input-group-sm mb-2">
                    <div class="input-group-prepend">
                        <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i
                                class="p-1 fa-solid fa-user"></i>
                        </span>
                    </div>
                    <input value="{{ $users->middle_name }}" placeholder="Middlename" id="middle_name" type="text"
                        class="form-control @error('middle_name') is-invalid @enderror" name="middle_name">
                    @error('middle_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
                <div class="input-group input-group-sm mb-2">
                    <div class="input-group-prepend mb-2">
                        <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i
                                class="p-1 fa-solid fa-user"></i>
                        </span>
                    </div>
                    <input value="{{ $users->extension_name }}" placeholder="Extension name" id="extension_name"
                        type="text" class="form-control mr-2 @error('extension_name') is-invalid @enderror"
                        name="extension_name" name="extension_name" autocomplete="extension_name" autofocus>
                    @error('extension_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                    <div class="input-group-sm">
                        <div class="input-group-prepend mb-2">
                            <div class="input-group date" id="datepicker">
                                <div class="input-group-prepend">
                                    <span class="input-group-icon" id="inputGroup-sizing-sm logo-input">
                                        <i class="fa-regular fa-calendar"></i>

                                    </span>
                                </div>

                                <input value="{{ $users->birthday }}" type="date" name='birthday'
                                    class="form-control @error('birthday') is-invalid @enderror" id="entry_date" />
                                @error('birthday')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="input-group input-group-sm mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i
                                    class="p-1 fa-solid fa-at"></i>
                            </span>
                        </div>
                        <input value="{{ $users->email }}" placeholder="Email" id="email" type="email"
                            class="form-control @error('email') is-invalid @enderror" name="email"
                            autocomplete="email">
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="input-group input-group-sm mb-2">
                        <div class="input-group-prepend">
                            <span class="input-group-icon" id="inputGroup-sizing-sm logo-input">
                                {{-- <i class="p-1 fa-solid fa-user"></i> --}}
                                <i class="p-1 fa-solid fa-user-tie"></i>
                            </span>
                        </div>

                        <select name="user_type_ID" class="form-select" id="role-update-{{ $users->user_ID }}" data-update-id="{{ $users->user_ID }}">

                            <option selected disabled>
                                {{ $users->user_type_ID == 1
                                    ? 'Regional Director'
                                    : ($users->user_type_ID == 2
                                        ? 'Regional Planning Officer'
                                        : ($users->user_type_ID == 3
                                            ? 'Provincial Director'
                                            : ($users->user_type_ID == 4
                                                ? 'Provincial Planning Officer'
                                                : ($users->user_type_ID == 5
                                                    ? 'Division Chief'
                                                    : '')))) }}
                            </option>

                            <option disabled>Update User Role</option>
                            <option name="1" value="1">
                                Regional Director</option>
                            <option name="2" value="2">
                                Regional Planning Officer</option>
                            <option name="3" value="3">
                                Provincial Director</option>
                            <option name="4" value="4">
                                Provincial Planning Officer</option>
                            <option name="5" value="5">
                                Division Chief</option>
                        </select>

                        {{-- <select name="province_ID" class="form-select">

                            <option selected disabled>
                                {{ $users->user_type_ID == 1
                                    ? 'Regional Director'
                                    : ($users->user_type_ID == 2
                                        ? 'Regional Planning Officer'
                                        : ($users->user_type_ID == 3
                                            ? 'Provincial Director'
                                            : ($users->user_type_ID == 4
                                                ? 'Provincial Planning Officer'
                                                : ($users->user_type_ID == 5
                                                    ? 'Division Chief'
                                                    : '')))) }}
                            </option>

                            <option disabled>Update User Role</option>
                            <option name="1" value="1">
                                Regional Director</option>
                            <option name="2" value="2">
                                Regional Planning Officer</option>
                            <option name="3" value="3">
                                Provincial Director</option>
                            <option name="4" value="4">
                                Provincial Planning Officer</option>
                            <option name="5" value="5">
                                Division Chief</option>
                        </select> --}}
                    </div>
                    <div class="input-group input-group-sm" id="province-planning-update-{{ $users->user_ID }}" data-update-id="{{ $users->user_ID }}">
                        <div class="input-group-prepend">
                            <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i
                                    class="p-1 fa-solid fa-user"></i>
                            </span>
                        </div>
                        <select name="user_province_ID" class="form-select">
                            <option selected disabled>Select Province</option>
                            <option name="1" value="1"
                                {{ old('user_province_ID') == '1' ? 'selected' : '' }}>Bukidnon</option>
                            <option name="2" value="2"
                                {{ old('user_province_ID') == '2' ? 'selected' : '' }}>Lanao Del Norte
                            </option>
                            <option name="3" value="3"
                                {{ old('user_province_ID') == '3' ? 'selected' : '' }}>Misamis Oriental
                            </option>
                            <option name="4" value="4"
                                {{ old('user_province_ID ') == '4' ? 'selected' : '' }}>Misamis Occidental
                            </option>
                            <option name="5" value="5"
                                {{ old('user_province_ID ') == '5' ? 'selected' : '' }}>Camiguin</option>
                        </select>

                    </div>
                    <div class="input-group input-group-sm ">
                        <div class="input-group-prepend">
                            <span class="input-group-icon" id="inputGroup-sizing-sm logo-input">
                                <i class="p-1 fa-solid fa-lock"></i>
                            </span>
                        </div>
                        <input placeholder="Password" id="update-password-{{ $users->user_ID }}" type="text"
                            class="form-control user-password {{ $users->user_ID }}" name="password" required/>
                        <div class="input-group-append">
                            <button class="btn btn-primary generate-password-btn" type="button"
                                data-generate-id="{{ $users->user_ID }}">
                                Generate
                            </button>
                        </div>
                    </div>
                    <input type="hidden" value="{{ $users->user_ID }}" name="user_ID" />

                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Update</button>
            </div>
        </div>
    </div>
</div>
