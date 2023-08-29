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
                <form method="POST" action="{{ route('rpo.add_objective') }}" id="add_objective">
                    @csrf
                    <div class="row">
                        <small class="text-danger">* Please make sure to select objective letter</small>

                        <label for="objective_letter"
                            class="col-form-label text-md-start">{{ __('Objective Letter') }}</label>

                        <div>
                            <select class="form-select" aria-label="Default select example" name="objective_letter"
                                required>
                                <option selected disabled>Select Letter</option>
                                <option value="A">A</option>
                                <option value="B">B</option>
                                <option value="C">C</option>
                                <option value="D">D</option>
                                <option value="E">E</option>
                                <option value="F">F</option>
                                <option value="G">G</option>
                                <option value="H">H</option>
                                <option value="I">I</option>
                                <option value="J">J</option>
                                <option value="K">K</option>
                                <option value="L">L</option>
                                <option value="M">M</option>
                                <option value="N">N</option>
                                <option value="O">O</option>
                                <option value="P">P</option>
                                <option value="Q">Q</option>
                                <option value="R">R</option>
                                <option value="S">S</option>
                                <option value="T">T</option>
                                <option value="U">U</option>
                                <option value="V">V</option>
                                <option value="W">W</option>
                                <option value="X">X</option>
                                <option value="Y">Y</option>
                                <option value="Z">Z</option>
                            </select>

                            @error('letter_division')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <label for="monthly_target"
                            class="col-form-label text-md-start">{{ __('Strategic Objective') }}</label>

                        <div>
                            <textarea class="form-control w-100" name="strategic_objective" id="strategic_objective" required></textarea>

                            @error('monthly_target')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror


                        </div>
                    </div>


                    <div class="d-grid col-10 mx-auto my-3">
                        <button class="btn btn-primary" type="submit" id="addObjectiveButton">{{ __('Add Objective') }}</button>
                    </div>
            </div>
            </form>

        </div>


    </div>
</div>
{{-- <script>
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

    
</script> --}}

<script>
    $(document).ready(function() {
        var add_form = document.getElementById('add_objective');
        const objectiveTextarea = document.getElementById('strategic_objective');
        const addObjectiveButton = document.getElementById('addObjectiveButton');

        // Disable the button when the modal is opened
        addObjectiveButton.disabled = true;

        add_form.addEventListener('submit', (event) => {
            // Prevent the form from submitting normally
            event.preventDefault();

            // Disable the submit button
            const button = event.submitter;
            button.disabled = true;

            // Submit the form
            event.target.submit();
        });

        objectiveTextarea.addEventListener('input', function() {
            if (objectiveTextarea.value.trim() === '') {
                addObjectiveButton.disabled = true;
            } else {
                addObjectiveButton.disabled = false;
            }
        });
    });
</script>


