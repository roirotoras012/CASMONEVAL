<div id="updatemodal" class="modal fade">
    <div class="modal-dialog modal-confirm">
        <div class="modal-content">
            <div class="modal-header flex-column">
                <div class="icon-box">
                    <i class="fa-solid fa-pen"></i>

                </div>
                <h4 class="modal-title w-100">Edit Profile</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            </div>
            <div class="modal-body">
                <div class="input-group input-group-sm">
                    <div class="input-group-prepend">
                        <span class="input-group-icon" id="inputGroup-sizing-sm logo-input"><i
                                class="p-1 fa-solid fa-user"></i>
                        </span>
                    </div>
                    <input value="{{ old('first_name') }}" placeholder="Firstname" id="first_name" type="text"
                        class="form-control @error('first_name') is-invalid @enderror" value="{{ old('first_name') }}"
                        name="first_name" autocomplete="first_name" autofocus>
                    @error('first_name')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </div>
            </div>
            <div class="modal-footer justify-content-center">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="submit" class="btn btn-danger">Update</button>
            </div>
        </div>
    </div>
</div>
