<!-- Modal -->

@props(['evaluation_ID'])



<!-- Modal -->
<div class="modal fade" id="reason<?= $evaluation_ID ?>" tabindex="-1" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Add Remarks</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('eval.store') }}">
                    @csrf


                    <input type="hidden" name="evaluation_ID" value="<?= $evaluation_ID ?>">
                    {{-- <input type="hidden" name="month" value="<?= $evaluation_ID ?>"> --}}
                    <div class="row">
                        <div class="form-floating">
                            <select class="form-select" name="remark">
                                <option selected>Open this select menu</option>
                                <option value="Approve">Approve</option>
                                <option value="Revise">Revise</option>
                                <option value="See me about this">See me about this</option>
                            </select>
                            <label for="reason">{{ __('Remarks') }}</label>
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
