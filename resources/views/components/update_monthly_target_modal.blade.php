<!-- Modal -->
{{-- @props(['month', 'annual_target', 'division_ID']) --}}
@props(['month', 'division_ID', 'annual_target'])



<div class="modal fade" id="<?=$month.'_'.$annual_target?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="jan_35">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- {{$month}} {{$division_ID}} {{$annual_target}} --}}
                


                <form method="POST" action="{{ route('monthly_targets.store') }}">
                    @csrf
                    
                        <input type="hidden" name="annual_target_ID" value="{{$annual_target}}">
                        <input type="hidden" name="division_ID" value="{{$division_ID}}">
                        <input type="hidden" name="month" value="{{$month}}">
                        <div class="row">
                            <label for="monthly_target"
                                class="col-form-label text-md-start">{{ __('Monthly Target') }}</label>

                            <div>
                                <input type="text" id="monthly_target"
                                    class="form-control @error('monthly_target') is-invalid @enderror"
                                    name="monthly_target" value="{{ old('monthly_target') }}" required autofocus />


                                @error('monthly_target')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror


                            </div>
                        </div>


                        <div class="d-grid col-10 mx-auto my-3">
                            <button class="btn btn-primary" type="submit">{{ __('Add Monthly Target') }}</button>
                        </div>
                    </div>
                </form>
              
            </div>
            

        </div>
    </div>
</div>