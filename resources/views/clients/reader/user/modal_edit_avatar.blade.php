<div class="modal" id="modal-edit-avatar" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content p-3 " style="border-top: 4px solid var(--btn_color);">
            <div class="modal-header border-bottom-0">
                <h4 class="modal-title fw700">Position and size your avatar</h4>
                <button type="button" class="close btn fs30 c_2" data-dismiss="modal" aria-label="Close"
                    onclick="closeModal('edit-avatar')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body border-bottom-0 pt-0">
                <form action="{{ route('api.profiles.update_avatar', user()->id) }}" class="text_center"
                    id="form-edit-avatar" method="POST" enctype="multipart/form-data">
                    <img src="" id="avatar" alt="">
                </form>
            </div>
            <div class="modal-footer d-flex justify-content-center py-0 border-top-0 mt-3">
                <div class="read_now d-flex" id="postReview">
                    <a class="cursor_pointer" onclick="closeModal('edit-avatar')">
                        <b style="height: max-content; background: transparent; color: var(--btn_color); border: 1px solid var(--btn_color)"
                            class="fs14 fw700 text_uppercase">
                            Cancel
                        </b>
                    </a>
                    <a class="cursor_pointer ms-3" onclick="submitForm('edit-avatar')">
                        <b style="height: max-content;" class="fs14 fw700 text_uppercase">
                            Save
                        </b>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
