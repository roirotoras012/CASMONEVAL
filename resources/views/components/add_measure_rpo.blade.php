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
                    
                    
                    <div class="row mb-2">
                      <label for="number_measure"
                          class="col-form-label text-md-start">{{ __('Measure Number') }}</label>
                      <div>
                          <select class="form-select" aria-label="Default select example" name="number_measure" required >
                            <option selected disabled>Select Number</option>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                            <option value="8">8</option>
                            <option value="9">9</option>
                            <option value="10">10</option>
                            <option value="11">11</option>
                            <option value="12">12</option>
                            <option value="13">13</option>
                            <option value="14">14</option>
                            <option value="15">15</option>
                            <option value="16">16</option>
                            <option value="17">17</option>
                            <option value="18">18</option>
                            <option value="19">19</option>
                            <option value="20">20</option>
                            <option value="21">21</option>
                            <option value="22">22</option>
                            <option value="23">23</option>
                            <option value="24">24</option>
                            <option value="25">25</option>
                            <option value="26">26</option>
                            <option value="27">27</option>
                            <option value="28">28</option>
                            <option value="29">29</option>
                            <option value="30">30</option>

                          </select>
                          @error('number_measure')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                      </div>
                        <div class="row">
                          
                        </div>
                            <label for="monthly_target"
                                class="col-form-label text-md-start">{{ __('Strategic Objective: ') }}</label>
                            <span><b>{{$objective->strategic_objective}}</b></span>

                            <div id="my-div-{{$objective->strategic_objective_ID}}">
                                <input type="hidden" name="strategic_objective_ID" value="{{$objective->strategic_objective_ID}}">
                                <textarea placeholder="Input Strategic Measure" class="form-control w-100" name="strategic_measure" required></textarea>
                                <label for="sub_measure" class="d-flex" style="margin-bottom: 0 !important">
                                  <input type="checkbox" id="sub_measure_update" name="sub_measure">
                                   <span> <b>SUBMEASURE</b></span>
                              </label>
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
                                    let checkboxes_{{$objective->strategic_objective_ID}} = document.querySelectorAll('#_{{$objective->strategic_objective_ID}} input[type="checkbox"][name="division[]"]');
      
                                    let dropdownContainer_{{$objective->strategic_objective_ID}} = document.createElement('div');
                                    dropdownContainer_{{$objective->strategic_objective_ID}}.id = 'new-dropdown_{{$objective->strategic_objective_ID}}';
                                    let dropdownSelect_{{$objective->strategic_objective_ID}} = document.createElement('select');
                                    dropdownSelect_{{$objective->strategic_objective_ID}}.name = 'accountable_division';
                                    dropdownContainer_{{$objective->strategic_objective_ID}}.appendChild(dropdownSelect_{{$objective->strategic_objective_ID}});
                                    
                                    checkboxes_{{$objective->strategic_objective_ID}}.forEach(checkbox_{{$objective->strategic_objective_ID}} => {
                                      
                                      checkbox_{{$objective->strategic_objective_ID}}.addEventListener('change', () => {
                                     
                                        let selectedCheckboxes_{{$objective->strategic_objective_ID}} = document.querySelectorAll('#_{{$objective->strategic_objective_ID}} input[type="checkbox"][name="division[]"]:checked');
                                        
                                        if (selectedCheckboxes_{{$objective->strategic_objective_ID}}.length > 1) {
                                          let dropdownOptions_{{$objective->strategic_objective_ID}} = document.createDocumentFragment();
                                          let dropdownOption_{{$objective->strategic_objective_ID}} = document.createElement('option');
                                            dropdownOption_{{$objective->strategic_objective_ID}}.value = '';
                                            
                                            dropdownOption_{{$objective->strategic_objective_ID}}.textContent = 'Select Accountable Division';
                                            dropdownOptions_{{$objective->strategic_objective_ID}}.appendChild(dropdownOption_{{$objective->strategic_objective_ID}});
                                          selectedCheckboxes_{{$objective->strategic_objective_ID}}.forEach(selectedCheckbox_{{$objective->strategic_objective_ID}} => {
                                            let optionValue_{{$objective->strategic_objective_ID}} = selectedCheckbox_{{$objective->strategic_objective_ID}}.value;
                                            let optionText_{{$objective->strategic_objective_ID}} = selectedCheckbox_{{$objective->strategic_objective_ID}}.nextElementSibling.innerText;
                                            let dropdownOption_{{$objective->strategic_objective_ID}} = document.createElement('option');
                                            dropdownOption_{{$objective->strategic_objective_ID}}.value = optionValue_{{$objective->strategic_objective_ID}};
                                            dropdownSelect_{{$objective->strategic_objective_ID}}.required = true;
                                            dropdownOption_{{$objective->strategic_objective_ID}}.textContent = optionText_{{$objective->strategic_objective_ID}};
                                            dropdownOptions_{{$objective->strategic_objective_ID}}.appendChild(dropdownOption_{{$objective->strategic_objective_ID}});
                                          });
                                          dropdownSelect_{{$objective->strategic_objective_ID}}.innerHTML = '';
                                          dropdownSelect_{{$objective->strategic_objective_ID}}.appendChild(dropdownOptions_{{$objective->strategic_objective_ID}});
                                          if (!document.getElementById('new-dropdown_{{$objective->strategic_objective_ID}}')) {
                                            let dropdownParent_{{$objective->strategic_objective_ID}} = document.querySelector('#my-div-{{$objective->strategic_objective_ID}}');
                                            dropdownParent_{{$objective->strategic_objective_ID}}.appendChild(dropdownContainer_{{$objective->strategic_objective_ID}});
                                          }
                                        } else {
                                          if (document.getElementById('new-dropdown_{{$objective->strategic_objective_ID}}')) {
                                            document.getElementById('new-dropdown_{{$objective->strategic_objective_ID}}').remove();
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