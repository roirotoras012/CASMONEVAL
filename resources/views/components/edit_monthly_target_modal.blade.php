<!-- Modal -->
{{-- @props(['month', 'annual_target', 'division_ID']) --}}
@props(['month', 'division_ID', 'annual_target', 'monthly_target_ID', 'monthly_target'])



<div class="modal fade" id="<?=$month.'_'.$annual_target?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="jan_35">Edit monthly target</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('dc.updateTar')}}" id="disableWhenClickedEdit-{{$monthly_target_ID}}">
                    @csrf
                    
                        <input type="hidden" name="annual_target_ID" value="{{$annual_target}}">
                        <input type="hidden" name="division_ID" value="{{$division_ID}}">
                        <input type="hidden" name="month" value="{{$month}}">
                        <input type="hidden" name="monthly_target_ID" value="{{$monthly_target_ID}}">
                        {{-- <input type="hidden" name="year" value="2032"> --}}

                        <div class="row">
                            <label for="monthly_target"
                                class="col-form-label text-md-start">{{ __('Monthly Target') }}</label>

                            <div>
                                <input type="text" id="monthly_target"
                                    class="form-control @error('monthly_target') is-invalid @enderror"
                                    name="monthly_target" value="{{ old('monthly_target') }}" required autofocus placeholder="{{ $monthly_target }}"/>
                                    

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
<script>
$(document).ready(function() {
  
    var add_form = document.getElementById('disableWhenClickedEdit-{{$monthly_target_ID}}');
  
    add_form.addEventListener('submit', (event) => {
   
        // Prevent the form from submitting normally
        event.preventDefault();
       
        // Disable the submit button
        const button = event.submitter;
        button.disabled = true;
        
        // Submit the form
        
        event.target.submit();
      });



    // your code goes here
  });

   

</script>