<div class="modal" id="modal-create-comment" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content p-3 " style="border-top: 4px solid var(--btn_color);">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title fw700">Write a comment
                </h5>
                <button type="button" class="close btn fs30 c_2" data-dismiss="modal" aria-label="Close"
                    onclick="closeModal('create-comment')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body border-bottom-0 pt-0">
                <form action="{{ route('api.comments.store') }}" id="form-create-comment" method="POST"
                    enctype="multipart/form-data">
                    <input type="hidden" name="rating_id" id="rating_id" value="">
                    <input type="hidden" name="comic_slug" value="{{ $data->slug }}">
                    <div>
                        <textarea class="editor_c p-2" id="editor_c" name="messages" id="" cols="30" rows="10"
                            placeholder="Type your comment here. Please write your comment as detailed as you can."></textarea>
                        <img src="" alt="" id="image_upload_c" class="image_upload">
                    </div>
                    <input type="file" name="image_c" id="image_c" class="d-none" accept="imgage/*"
                        oninput="image_upload.src=window.URL.createObjectURL(this.files[0])">
                </form>
                <div class="modal-footer d-flex justify-content-between py-0 border-top-0">
                    <button class="btn fs20 c_s" id="upload_image" onclick="openChooseFile('image_c')">
                        <i class="fa-regular fa-image"></i>
                    </button>
                    <div class="read_now d-flex disabled" id="postComment">
                        <a class="cursor_pointer" onclick="submitFormCreate('create-comment')">
                            <b style="height: max-content;" class="fs14 fw700 d-flex align-items-center px-3 py-1">
                                POST
                            </b>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
