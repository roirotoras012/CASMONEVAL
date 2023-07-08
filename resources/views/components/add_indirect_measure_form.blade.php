<!-- Modal -->
<div class="modal fade" id="addIndirect" tabindex="-1" role="dialog" aria-labelledby="addIndirectLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
      <form method="POST" action="{{ route('dc.add_indirect_measure') }}">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="addIndirectLabel">Add KPI Driver</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <div class="modal-body">
            <div class="form-group">
                <label for="Indirect Measure">Indirect Measure</label>
                <input required type="text" class="form-control" id="Indirect Measure" placeholder="Indirect Measure" name="strategic_measure">
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