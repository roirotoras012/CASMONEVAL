

<div class="modal fade" id="editAnnualModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Update Annual Target</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('rpo.updateAnnual') }}" id="modalForm">
               
                <div class="modal-body">
                    <input type="text" id="provTargetInput" name="target_id" >
                    <input type="hidden" id="provValInput" name="old_target">
                 

                    <div class="row">
                        <div>
                            <input type="text" id="provValInput2" class="form-control @error('prov_val') is-invalid @enderror" name="new_target" required autofocus  />
                            @error('prov_val')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" >Close</button>
                    <button class="btn btn-primary" value="update_target" name="submit" type="submit" >{{ __('Update') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>

function setModalParams(target, value) {

    // Set the values in the modal input fields
    $('#provTargetInput').val(target);
    $('#provValInput').val(value);
    $('#provValInput2').val(value);
   
    
}

// function submitModalForm() {
//         console.log("hoy")
//         // Submit the form inside the modal
//         $('#modalForm').submit();
//     }
</script>