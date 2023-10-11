<div class="modal" id="modal-create-chapter" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New Chapter</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close" id="close-modal-1">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('api.chapters.store') }}" id="form-create-chapter" method="POST">
                    <input type="hidden" name="comic_slug" id="comic_slug" class="form-control"
                        value="{{ $comic->slug }}">
                    <input type="hidden" name="comic_id" id="comic_id" class="form-control"
                        value="{{ $comic->id }}">
                    <div class="col-12 mt-1">
                        <label for="title">Title <span class="c_red">(*)</span>:</label>
                        <input type="text" name="title" id="title" class="form-control">
                    </div>
                    <div class="col-12 mt-1">
                        <label for="number">
                            Chapter <span class="c_red">(*)</span>:
                        </label>
                        <input type="text" name="number" id="number-create" class="form-control">
                    </div>
                    <div class="col-12 mt-1">
                        <label for="slug">
                            Slug <span class="c_red">(*)</span>:
                        </label>
                        <input type="text" name="slug" id="slug-create" class="form-control">
                    </div>
                    <div class="col-12 mt-1 d-flex">
                        <div class="col-8 ps-0">
                            <label for="images">
                                Images <span class="c_red">(*)</span>:
                            </label>
                            <input type="file" name="images[]" id="upload_images_create" class="form-control"
                                multiple accept="image/*">
                        </div>
                        <span class="btn-link cursor_pointer" style="margin-top: 2.3rem; margin-left: 1rem;"
                            onclick="previewChapter(upload_images_create, 'div.gallery')">Preview
                            Chapter</span>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="checkSlug('create')">Submit</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal" id="close-modal-2">Close</button>
            </div>
        </div>
    </div>
</div>
