<!-- Modal -->
@props(['drivers'])
<div class="modal fade" id="deleteKpi" tabindex="-1" role="dialog" aria-labelledby="deleteKpiLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <form method="POST" action="{{ route('dc.delete_driver_only') }}" onsubmit="return confirm('Are you sure you want to delete this driver?');">
            @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="deleteKpiLabel">Delete Operational Driver</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        
        <div class="modal-body">
            <div class="form-group">
                <label for="KPI Driver">Select Operational Driver</label>
                <select name="driver_ID" required class="form-select">
                    <option value="">CHOOSE DRIVER</option>
                    @foreach ($drivers->sortByDesc('driver_ID') as $driver)
                    <option value="{{ $driver->driver_ID }}">{{ $driver->driver }}</option>
                    @endforeach

                </select>
              </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-danger">Delete</button>
        </div>
        </form>
      </div>
    </div>
  </div>
