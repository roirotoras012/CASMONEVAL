<!-- Modal -->
@props(['province', 'measure', 'target'])


<div class="modal fade" id="<?=$measure."_".$province?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="<?=$measure."_".$province?>">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                
                <form method="POST" action="{{ route('annual_targets.update') }}">
                    @csrf
                    @method('PUT')
                        <input type="hidden" name="annual_target_ID" value="{{$target}}">
                        <input type="hidden" name="measure_ID" value="{{$measure}}">
                        <input type="hidden" name="province_ID" value="{{$province}}">
                        <div class="row">
                            <label for="annual_target"
                                class="col-form-label text-md-start">{{ __('Annual Target') }}</label>

                            <div>
                                <input type="text" id="annual_target"
                                    class="form-control @error('annual_target') is-invalid @enderror"
                                    name="annual_target" value="{{ old('annual_target') }}" required autofocus />


                                @error('annual_target')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror


                            </div>
                        </div>


                        <div class="d-grid col-10 mx-auto my-3">
                            <button class="btn btn-primary" type="submit">{{ __('Update Annual Target') }}</button>
                        </div>
                    </div>
                </form>
              
            </div>
            

        </div>
    </div>
</div>
