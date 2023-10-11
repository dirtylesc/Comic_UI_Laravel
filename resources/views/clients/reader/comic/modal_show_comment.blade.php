<div class="modal" id="modal-show-comment" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content" style="border-top: 4px solid var(--btn_color);">
            <div class="modal-header border-bottom-0 pb-0 p-4">
                <h4 class="modal-title fw700">Review Details</h4>
                <button type="button" class="close btn fs30 c_2" data-dismiss="modal" aria-label="Close"
                    onclick="closeModal('show-comment')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body border-bottom-0 p-0" id="comments_body">
                <div class="d-flex p-4 pb-2 pt-0" id="review_comments">
                </div>
                <div class="ps-4 pb-2 pt-4" id="comment_count">
                </div>
                <div class="d-flex flex-column p-4 pb-0 pt-0" id="list_comments">
                </div>
            </div>
            <div class="modal-footer d-flex justify-content-between p-0 border-top-0">
                <button class="btn fs14 c_s w_100 text-start" id="create_comment" onclick="showModal('create-comment')">
                    Add a reply
                </button>
            </div>
        </div>
    </div>
</div>
