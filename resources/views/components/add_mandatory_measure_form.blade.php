<!-- Modal -->
<div class="modal fade" id="addMandatory" tabindex="-1" role="dialog" aria-labelledby="addMandatoryLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      <form method="POST" action="{{ route('dc.add_mandatory_measure') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="addMandatoryLabel">Add KPI Driver</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <div class="modal-body">
            <div class="form-group">
                <label for="Indirect Measure">Mandatory Measure</label>
                <input required pattern="^[a-zA-Z]+$" required type="text" class="form-control" id="Mandatory Measure" placeholder="Mandatory Measure" name="strategic_measure">
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>