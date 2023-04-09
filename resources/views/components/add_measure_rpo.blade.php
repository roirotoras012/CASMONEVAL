<!-- Modal -->
@props(['objective', 'divisions'])




<div class="modal fade" id="_{{$objective->strategic_objective_ID}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-black">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="jan_35">Add Strategic Measure</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('rpo.add_measure')}}" id="measure_modal-{{$objective->strategic_objective_ID}}">
                    @csrf
                    
                    

                        <div class="row">
                            <label for="monthly_target"
                                class="col-form-label text-md-start">{{ __('Strategic Objective: ') }}</label>
                            <span><b>{{$objective->strategic_objective}}</b></span>

                            <div id="my-div">
                                <input type="hidden" name="strategic_objective_ID" value="{{$objective->strategic_objective_ID}}">
                                <textarea placeholder="Input Strategic Measure" class="form-control w-100" name="strategic_measure" required></textarea>
                             
                                  <div class="dropdown my-1 text-right">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      Select Division
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @foreach ($divisions as $division)
                                        <a class="dropdown-item" href="#">
                                        
                                            <input type="checkbox" name="division[]" value="{{$division->division_ID}}"> <b>{{$division->code}}</b>
                                          </a>
                                        @endforeach
                                      
                                    </div>
                                  
                                    
                                  </div>
                                  <script>
                                    const checkboxes = document.querySelectorAll('input[type="checkbox"][name="division[]"]');
                                    const dropdownContainer = document.createElement('div');
                                    dropdownContainer.id = 'new-dropdown';
                                    const dropdownSelect = document.createElement('select');
                                    dropdownSelect.name = 'accountable_division';
                                    dropdownContainer.appendChild(dropdownSelect);
                                    
                                    checkboxes.forEach(checkbox => {
                                      checkbox.addEventListener('change', () => {
                                        const selectedCheckboxes = document.querySelectorAll('input[type="checkbox"][name="division[]"]:checked');
                                        
                                        if (selectedCheckboxes.length > 1) {
                                          const dropdownOptions = document.createDocumentFragment();
                                          const dropdownOption = document.createElement('option');
                                            dropdownOption.value = '';
                                            
                                            dropdownOption.textContent = 'Select Accountable Division';
                                            dropdownOptions.appendChild(dropdownOption);
                                          selectedCheckboxes.forEach(selectedCheckbox => {
                                            const optionValue = selectedCheckbox.value;
                                            const optionText = selectedCheckbox.nextElementSibling.innerText;
                                            const dropdownOption = document.createElement('option');
                                            dropdownOption.value = optionValue;
                                            dropdownSelect.required = true;
                                            dropdownOption.textContent = optionText;
                                            dropdownOptions.appendChild(dropdownOption);
                                          });
                                          dropdownSelect.innerHTML = '';
                                          dropdownSelect.appendChild(dropdownOptions);
                                          if (!document.getElementById('new-dropdown')) {
                                            const dropdownParent = document.querySelector('#my-div');
                                            dropdownParent.appendChild(dropdownContainer);
                                          }
                                        } else {
                                          if (document.getElementById('new-dropdown')) {
                                            document.getElementById('new-dropdown').remove();
                                          }
                                        }
                                      });
                                    });
                                  </script>
                                @error('monthly_target')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror


                            </div>
                        </div>


                        <div class="d-grid col-10 mx-auto my-3">
                            <button class="btn btn-primary" type="submit">{{ __('Add Measure') }}</button>
                        </div>
                    </div>
                </form>
              
            </div>
            

        </div>
    </div>
    <script>
        $(document).ready(function() {
          
            var add_form = document.getElementById('measure_modal-{{$objective->strategic_objective_ID}}');
          
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