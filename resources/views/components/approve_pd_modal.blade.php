@props(['monthly_target_ID'])

<div class="modal fade" id="_<?=$monthly_target_ID?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Approve Target</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form method="POST" action="{{ route('monthly_target.approve') }}">
            @csrf
        <div class="modal-body">

          <input type="hidden" name="monthly_target_ID" value="<?= $monthly_target_ID ?>">
          
          <div class="row">
              <div class="form-floating">
                  <select class="form-select" name="approve">
                      <option selected>Open this select menu</option>
                      <option value="approve">Approve</option>
                  </select>
                  <label for="reason">{{ __('Remarks') }}</label>
              </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
        </form>
      </div>
    </div>
  </div>