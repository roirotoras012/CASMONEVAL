<!-- Modal -->
@props(['opcr_id'])




<div class="modal fade" id="cutoff-{{$opcr_id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-black">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="jan_35">Monthly Cutoff / Monthly Reopen</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" method="POST" action="{{ route('rpo.cutOff')}}" id="">
                    @csrf
                    
                    

                        <div class="text-center">
                            <input type="hidden" name="opcr_id" value="{{$opcr_id}}">
                            <select class="custom-select" id="inputGroupSelect01" name="month" required>
                                <option selected value="">Choose a month</option>
                                <option value="jan">January</option>
                                <option value="feb">February</option>
                                <option value="mar">March</option>
                                <option value="apr">April</option>
                                <option value="may">May</option>
                                <option value="jun">June</option>
                                <option value="jul">July</option>
                                <option value="aug">August</option>
                                <option value="sep">September</option>
                                <option value="oct">October</option>
                                <option value="nov">November</option>
                                <option value="dec">December</option>
                              </select>
                        </div>


                        <div class="d-flex justify-content-center mx-auto my-3 gap-2">
                            <button class="btn btn-primary" type="submit" value="cutoff" name="submit">Cutoff</button>
                            <button class="btn btn-primary" type="submit" value="reopen" name="submit">Reopen</button>
                        </div>
                      
                    </div>
                </form>
              
            </div>
            

        </div>
    </div>
