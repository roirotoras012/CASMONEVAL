@props(['users'])
<div id="disablemodal-{{ $users->user_ID }}" class="modal fade">
	<div class="modal-dialog modal-confirm">
		<div class="modal-content">
			<div class="modal-header flex-column">
				<div class="icon-box">
					<i class="fa fa-ban" aria-hidden="true"></i>

				</div>						
				{{-- <h4 class="modal-title w-100">Are you sure?</h4>	 --}}
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
				<select class="form-select" name='statusSelect' aria-label="Default select example">
                    <option value='current' name='current' disabled>{{$users->status}}</option>
                    <option value="active" name="active">Active</option>
                    <option value="disabled" name="disabled">Disabled</option>
                </select>
			</div>
            <input type='hidden' value={{$users->user_ID}} name="user_ID"/>
			<div class="modal-footer justify-content-center">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
				<button type="submit" class="btn btn-success">Save</button>
			</div>
		</div>
	</div>
</div> 