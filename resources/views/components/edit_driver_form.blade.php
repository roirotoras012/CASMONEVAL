<!-- Modal -->
@props(['drivers', 'selectedDriverId', 'selectedDriver'])
<div class="modal fade" id="editDriver" tabindex="-1" role="dialog" aria-labelledby="editDriverLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form method="POST" action="{{ route('dc.edit_driver') }}">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="editDriverLabel">Edit Operational Driver</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label for="driver_ID">Select Operational Driver</label>
                        <select name="driver_ID" required class="form-select" onchange="updateDriverName(this)">
                            <option value="">CHOOSE DRIVER</option>
                            @foreach ($drivers->sortByDesc('driver_ID') as $driver)
                                <option value="{{ $driver->driver_ID }}" {{ $driver->driver_ID == $selectedDriverId ? 'selected' : '' }}>
                                    {{ $driver->driver }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="driver">New Driver Name</label>
                        <input type="text" name="driver" id="newDriverName" value="{{ $selectedDriver }}" required class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function updateDriverName(select) {
        var selectedDriver = select.options[select.selectedIndex].text;
        document.getElementById("newDriverName").value = selectedDriver;
    }
</script>
