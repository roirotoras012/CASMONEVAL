<!-- Modal -->
{{-- @props(['month', 'annual_target', 'division_ID']) --}}


@props(['item', 'measures'])

<div class="modal fade" id="triggerSumModal_{{ $item->strategic_measure_ID }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="jan_35">Add Trigger </h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('rpo.add_objective') }}" id="add_objective">
                    @csrf


                    <div class="row">
                        <small class="text-danger">This will add the values of selected submeasures</small>
                        <label for="strategic_measures"
                            class="col-form-label text-md-start">{{ __('Strategic Measures') }}</label>
                        <div>
                            <div class="dropdown my-1 text-right">
                                <button style="width: 100%"  class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                  SUM OF
                                </button>

                          
                              
                                <div style="width: 100%" class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @foreach ($measures as $measure)
                                    @if (($measure->strategic_measure_ID != $item->strategic_measure_ID) && $measure->number_measure == $item->number_measure)
                                    <a style="text-wrap: wrap" class="dropdown-item" href="#" onclick="toggleCheckbox(event)">
                                        <input  type="checkbox" name="measures[]" value="{{$measure->strategic_measure_ID}}">
                                       {{$measure->strategic_measure}}
                                    </a>
                                    @endif
                                  
                                    @endforeach
                                </div>
                              
                               
                              
                                
                              </div>

                            @error('letter_division')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                 


                    <div class="d-grid col-10 mx-auto my-3">
                        <button class="btn btn-primary" value="trigger" name="submit" type="submit">{{ __('Add Trigger') }}</button>
                    </div>
            </div>
            </form>

        </div>


    </div>
</div>
<script>
    function toggleCheckbox(event) {
        event.stopPropagation();
        var checkbox = $(event.target).find('input[type="checkbox"]');
        checkbox.prop('checked', !checkbox.prop('checked'));
    }
</script>
