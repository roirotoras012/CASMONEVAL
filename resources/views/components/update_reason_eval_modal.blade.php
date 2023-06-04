<!-- Modal -->

@props(['evaluation_ID'])



<!-- Modal -->
<div class="modal fade" id="reason<?=$evaluation_ID?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h1 class="modal-title fs-5" id="exampleModalLabel">Reason Form</h1>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <form method="POST" action="{{ route('eval.reason')}}" >
                @csrf
                
                    
                    <input type="hidden" name="evaluation_ID" value="<?=$evaluation_ID?>">
                    <input type="hidden" name="month" value="<?=$evaluation_ID?>">
                    <div class="row">

                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Reason why you did not hit your target" id="reason" style="height: 100px" name="reason"></textarea>
                            <label for="reason">{{ __('Reason why you did not hit your target') }}</label>
                          </div>
                    </div>


                    <div class="d-grid col-10 mx-auto my-3">
                        <button class="btn btn-primary" type="submit">{{ __('Add Reason') }}</button>
                    </div>
                </div>
            </form>
        </div>
        
      </div>
    </div>
  </div>