<!-- Modal -->
<div class="modal fade" id="addKpi" tabindex="-1" role="dialog" aria-labelledby="addKpiLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form method="POST" action="{{ route('dc.add_driver_only') }}">
            @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="addKpiLabel">Add Operational Driver</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <div class="modal-body">
            <div class="form-group">
                <label for="KPI Driver">Operational Driver</label>
                <input type="text" class="form-control" id="KPI Driver" aria-describedby="emailHelp" placeholder="Operational Driver" name="driver">
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