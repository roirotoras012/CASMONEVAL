<!-- Modal -->
@props(['opcr_id'])




<div class="modal fade" id="opcr-{{$opcr_id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-black">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="jan_35">Upload OPCR</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" method="POST" action="{{ route('rpo.upload_opcr')}}" id="">
                    @csrf
                    
                    

                        <div class="text-center">
                            <input type="hidden" name="opcr_id" value="{{$opcr_id}}">
                            <input type="file" name="opcr_file" id="" accept=".pdf,.doc,.docx,application/vnd.ms-excel,application/vnd.openxmlformats-officedocument.spreadsheetml.sheet,image/*" required>
                        </div>


                        <div class="d-grid col-10 mx-auto my-3">
                            <button class="btn btn-primary" type="submit">{{ __('Upload') }}</button>
                        </div>
                    </div>
                </form>
              
            </div>
            

        </div>
    </div>
