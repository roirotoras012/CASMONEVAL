@props(['prov_target', 'prov_val'])

<div class="modal fade" id="_{{ $prov_target }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Annual Target</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('rpo.updateAnnual') }}">
                @csrf
                <div class="modal-body">
                    <input type="text" name="prov_target" value="{{ $prov_target }}">
                    <input type="hidden" name="prov_val" value="{{ $prov_val }}">
                    <div class="row">
                        <div>
                            <input type="text" id="prov_val" class="form-control @error('prov_val') is-invalid @enderror" name="prov_val" value="{{ old('prov_val', $prov_val) }}" required autofocus placeholder="{{ $prov_val }}" />
                            @error('prov_val')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" type="submit">{{ __('Update') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
