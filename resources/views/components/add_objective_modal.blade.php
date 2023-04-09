<!-- Modal -->
{{-- @props(['month', 'annual_target', 'division_ID']) --}}




<div class="modal fade" id="objectiveModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="jan_35">Add Strategic Objective</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('rpo.add_objective')}}" id="add_objective">
                    @csrf
                    
                    

                        <div class="row">
                            <label for="monthly_target"
                                class="col-form-label text-md-start">{{ __('Strategic Objective') }}</label>

                            <div>
                                <textarea class="form-control w-100" name="strategic_objective" required></textarea>

                                @error('monthly_target')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror


                            </div>
                        </div>


                        <div class="d-grid col-10 mx-auto my-3">
                            <button class="btn btn-primary" type="submit">{{ __('Add Objective') }}</button>
                        </div>
                    </div>
                </form>
              
            </div>
            

        </div>
    </div>
    <script>
        $(document).ready(function() {
          
            var add_form = document.getElementById('add_objective');
          
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