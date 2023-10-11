<div class="modal" id="modal-create-review" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content p-3 " style="border-top: 4px solid var(--btn_color);">
            <div class="modal-header border-bottom-0">
                <h5 class="modal-title fw700">Write a review <small class="c_s fs12 ms-2 fw400">Reading Status:
                        C0</small>
                </h5>
                <button type="button" class="close btn fs30 c_2" data-dismiss="modal" aria-label="Close"
                    onclick="closeModal('create-review')">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body border-bottom-0 pt-0">
                <form action="{{ route('api.reviews.store') }}" id="form-create-review" method="POST"
                    enctype="multipart/form-data">
                    <input type="hidden" name="comic_id" id="comic_id" value="{{ $data->id }}">
                    <input type="hidden" name="comic_slug" id="comic_slug" value="{{ $data->slug }}">
                    <div class="d-flex align-items-center">
                        <ul class="fs16" style="width: 68%">
                            <li class="d-flex justify-content-between ms-2 mt-3">Writing
                                Quality
                                <div class="rate_ele max_content">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star c_s me-1 cursor_pointer" name="wqscore"></i>
                                    @endfor
                                </div>
                            </li>
                            <li class="d-flex justify-content-between ms-2 mt-3">Stability
                                of
                                Updates
                                <div class="rate_ele max_content">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star c_s me-1 cursor_pointer" name="souscore"></i>
                                    @endfor
                                </div>
                            </li>
                            <li class="d-flex justify-content-between ms-2 mt-3">Story
                                Development
                                <div class="rate_ele max_content">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star c_s me-1 cursor_pointer" name="sdscore"></i>
                                    @endfor
                                </div>
                            </li>
                            <li class="d-flex justify-content-between ms-2 mt-3">Character
                                Design
                                <div class="rate_ele max_content">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star c_s me-1 cursor_pointer" name="cdscore"></i>
                                    @endfor
                                </div>
                            </li>
                            <li class="d-flex justify-content-between ms-2 mt-3">World
                                Background
                                <div class="rate_ele max_content">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star c_s me-1 cursor_pointer" name="wbscore"></i>
                                    @endfor
                                </div>
                            </li>
                        </ul>
                        <div class="border d-flex flex-column align-items-center ms-4"
                            style="border-radius: 5px; padding: 18px 20px;">
                            <span class="c_s fs12">The total score</span>
                            <input class="fw700 fs32 d-block border-0 pointer_event_none" style="width: 46px"
                                name="rate" value="0.0" />
                            <div class="rate_main fs12">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star c_s me-0"></i>
                                @endfor
                            </div>
                        </div>
                    </div>
                    <div>
                        <textarea class="editor p-2" id="editor" name="editor" id="" cols="30" rows="10"
                            placeholder="Type your review here. Please write your review as detailed as you can. Your reviews would be very important to the story (at least 140 characters)."></textarea>
                        <img src="" alt="" id="image_upload" class="image_upload">
                    </div>
                    <input type="file" name="image" id="image" class="d-none" accept="imgage/*"
                        oninput="image_upload.src=window.URL.createObjectURL(this.files[0])">

                </form>
                <div class="modal-footer d-flex justify-content-between py-0 border-top-0">
                    <button class="btn fs20 c_s" id="upload_imgage" onclick="openChooseFile('image')">
                        <i class="fa-regular fa-image"></i>
                    </button>
                    <div class="read_now d-flex disabled" id="postReview">
                        <a class="cursor_pointer" onclick="submitFormCreate('create-review')">
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
