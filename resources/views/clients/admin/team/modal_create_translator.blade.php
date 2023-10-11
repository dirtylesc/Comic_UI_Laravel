<div class="modal" id="modal-create-translator" tabindex="-1" role="dialog" style="background-color: rgba(0, 0, 0, .3)">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <a href=""></a>
            <div class="modal-header">
                <h5 class="modal-title">Create Translator</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-modal-1">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('api.teams.store_translator') }}" id="form-create-translator" method="POST">
                    <input type="hidden" name="team_id" id="team_id" class="form-control"
                        value="{{ $data->id }}">
                    <div class="col-12 mt-1">
                        <label for="" class="fs16">Translator:</label>
                        <select type="text" name="user_id" id="select-translator" class="ms-2 col-12">
                        </select>
                    </div>
                    <div class="col-12 mt-1">
                        <label for="" class="fs16">Language:</label>
                        <select type="text" name="languages[]" id="select-translator-language" class="ms-2 col-12"
                            multiple>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onClick="submitForm('create-translator')">Submit</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close-modal-2">Close</button>
            </div>
        </div>
    </div>
</div>
