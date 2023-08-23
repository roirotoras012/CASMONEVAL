@props(['annualTarget', 'note', 'annualID'])

<div class="modal fade" id="_<?= $annualID ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="{{ $annualID }}Label">Update Annual Target</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="POST" action="{{ route('ppo.updateTarget') }}" id="modalForm">
                @csrf
                <div class="modal-body">
                    <input type="hidden" value="<?= $annualID ?>" name="target_id">
                    <div class="row">
                        <div class="d-flex gap-1 align-items-center">
                            <input type="text" id="provValInput2"
                                class="form-control @error('prov_val') is-invalid @enderror" name="annualTarget"
                                pattern="^[0-9]+$" value="<?= $annualTarget ?>" disabled/>
                        </div>
                    </div>
                    <div class="row mt-4">
                        {{-- <div class="form-floating">
                        <textarea class="form-control" placeholder="note" id="note" style="height: 100px" name="note" disabled><?= $note ?></textarea>
                    </div> --}}
                        <div class="form-floating">
                            <textarea class="form-control" placeholder="Add a note (optional)" id="note" style="height: 100px" name="note"></textarea>
                            <label for="comment">{{ __('Add a note (optional)') }}</label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button class="btn btn-primary" value="update_target" name="submit"
                        type="submit">{{ __('Update') }}</button>
                </div>
            </form>
        </div>
    </div>
</div>
