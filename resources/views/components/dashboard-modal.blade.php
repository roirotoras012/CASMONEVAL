<!-- Modal -->
@props(['user_dashboard_details','id'])
<div class="modal fade p-0" id="dashboard-modal-{{$id}}" tabindex="-1" role="dialog" aria-labelledby="dashboard-modal-{{$id}}" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document">
    <div class="modal-content">
      {{-- <div class="modal-header">
        <h5 class="modal-title" id="dashboard-modalLabel">User Details</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div> --}}
      <div class="modal-body">
          
            <div class="d-flex">
              <table class="table table-striped">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Firstname</th>
                        <th scope="col">Lastname</th>
                        <th scope="col">Middle name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Birthday</th>
                      </tr>
                </thead>
                <tbody scope="row">
                  @foreach($user_dashboard_details as $user_dashboard_detail)

                  <tr>
                    <td class="user_dashboard_firstname p-2">{{$user_dashboard_detail->first_name}}</td>
                    <td class="user_dashboard_lastname p-2">{{$user_dashboard_detail->last_name}}</td>
                    <td class="user_dashboard_lastname p-2">{{$user_dashboard_detail->middle_name}}</td>
                    <td class="user_dashboard_lastname p-2">{{$user_dashboard_detail->email}}</td>

                    <td class="user_dashboard_lastname p-2">{{$user_dashboard_detail->birthday}}</td>



                  </tr>
                  @endforeach

                </tbody>
              </table>
           
            </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>