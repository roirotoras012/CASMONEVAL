<!-- Modal -->
@props(['objective', 'divisions'])




<div class="modal fade" id="_{{$objective->strategic_objective_ID}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content text-black">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="jan_35">Add Strategic Measure</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('rpo.add_measure')}}" >
                    @csrf
                    
                    

                        <div class="row">
                            <label for="monthly_target"
                                class="col-form-label text-md-start">{{ __('Strategic Objective: ') }}</label>
                            <span><b>{{$objective->strategic_objective}}</b></span>

                            <div>
                                <input type="hidden" name="strategic_objective_ID" value="{{$objective->strategic_objective_ID}}">
                                <textarea placeholder="Input Strategic Measure" class="form-control w-100" name="strategic_measure" required></textarea>
                             
                                  <div class="dropdown my-1 text-right">
                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                      Select Division
                                    </button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                        @foreach ($divisions as $division)
                                        <a class="dropdown-item" href="#">
                                        
                                            <input type="checkbox" name="division[]" value="{{$division->division_ID}}"> <b>{{$division->code}}</b>
                                          </a>
                                        @endforeach
                                      
                                    </div>
                                
                                  </div>
                                @error('monthly_target')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror


                            </div>
                        </div>


                        <div class="d-grid col-10 mx-auto my-3">
                            <button class="btn btn-primary" type="submit">{{ __('Add Measure') }}</button>
                        </div>
                    </div>
                </form>
              
            </div>
            

        </div>
    </div>
