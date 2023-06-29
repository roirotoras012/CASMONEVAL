<!-- Modal -->
@props(['user_dashboard_details','id'])
<div class="modal fade" id="dashboard-modal-{{$id}}" tabindex="-1" role="dialog" aria-labelledby="dashboard-modal-{{$id}}" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="dashboard-modalLabel">User Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            @foreach($user_dashboard_details as $user_dashboard_detail)
            <div class="d-flex">
                <p class="user_dashboard_firstname">{{$user_dashboard_detail->first_name}}</p>
                <p class="user_dashboard_lastname">{{$user_dashboard_detail->last_name}}</p>
            </div>
            @endforeach
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>