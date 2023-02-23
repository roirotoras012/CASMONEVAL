 <div class="modal fade" id="logout-modal" tabindex="-1" role="dialog" aria-labelledby="logout-label" aria-hidden="true">
     <div class="modal-dialog text-center" role="document">
         <div class="modal-content">
             <div class="modal-header">

                 <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                 </button>
             </div>
             <div class="modal-body">
                 <h5 class="modal-title" id="logout-label">Are you sure you want to log-out ?</h5>
             </div>
             <div class="text-center mx-auto p-3">

                 <a class="btn btn-primary text-white" data-dismiss="modal"
                     onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                     Yes
                 </a>
                 <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                     @csrf
                 </form>

                 <button type="button" class="btn btn-primary" data-dismiss="modal">No</button>
             </div>
         </div>
     </div>
 </div>
