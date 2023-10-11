@extends('layouts.reader.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/reader/style_comic.css') }}">
    <link rel="stylesheet" href="{{ asset('css/grid.css') }}">
    <style>
        .ck-editor__editable {
            height: 200px;
            overflow-y: scroll !important;
        }

        .ck-editor__editable p:not(.ck-placeholder) {
            height: fit-content !important;
        }

        .ck.ck-content.ck-focused:not(.ck-editor__nested-editable),
        .ck.ck-editor__editable_inline {
            border: 0 !important;
            outline: none !important;
            box-shadow: none !important;
        }

        .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
            border-color: #fff !important;
        }
    </style>
@endpush
@section('content')
    <div class="info_comic">
        <div class="w_layout">
            <div class="link">
                <a href="{{ route('reader.index') }}" title="Home">
                    <i class="fas fa-home fs14"></i>
                </a>
                /
                <a href="{{ route('reader.tags.index', $data->categories[0]->slug) }}"
                    title="{{ $data->categories[0]->name }}">
                    <strong> {{ $data->categories[0]->name }}</strong>
                </a>
                /
                <strong>{{ $data->name }}</strong>
            </div>
            <div class="info">
                <div class="comic_img">
                    <img src="{{ asset($data->avatar) }}" alt="">
                </div>
                <div class="text">
                    <h1 class="fw900 cl9">
                        {{ $data->name }}
                        @if ($data->alias)
                            ( {{ $data->alias }} )
                        @endif
                    </h1>
                    <div class="detail1">
                        <span><i class="fas fa-file-contract ms-1"></i>{{ count($data->chapters) }} Chapters</span>
                        <span><i class="fas fa-eye"></i>
                            {{ calculateViewComic($data->chapters) }} Views
                        </span>
                    </div>
                    <div class="detail2">
                        <span class="fw400 cl6 ms-1">Author: </span>
                        <strong>{{ $data->author }}
                        </strong>
                        <span class="fw400 cl6">Translator: </span>
                        <a>
                            <strong>{{ $data->user->name }}</strong>
                        </a>
                    </div>
                    <div class="more">

                    </div>
                    <div class="rate">
                        @for ($i = 0; $i < 5; $i++)
                            <i class="fas fa-star @if ($i + 1 < $data->rate) _on @endif"></i>
                        @endfor
                        <span class="star_avg fs24">{{ $data->rate }}</span>
                        <small class="fs16">({{ $data->rate_count }} ratings)</small>
                    </div>
                    <div class="function">
                        @if (!$chapters->isEmpty())
                            <a href="{{ route('reader.comics.show_chapter', [$data->slug, $data->chapters[0]->slug]) }}">
                                <strong class="read max_content">{{ __('frontpage.read_now') }}</strong>
                            </a>
                        @endif
                        @if (!$data->addedLibraries)
                            <strong class="add cursor-pointer cursor_pointer"
                                onclick="addToLibrary(this, {{ $data->id }}, 
                                '{{ mb_strtoupper(__('frontpage.in_library')) }}', 
                                '{{ mb_strtoupper(__('frontpage.add_to_library')) }}')">
                                <i class="fas fa-plus" id="icon"></i>
                                <span id="text">{{ mb_strtoupper(__('frontpage.add_to_library')) }}</span>
                            </strong>
                        @else
                            <strong class="add cursor-pointer cursor_pointer"
                                onclick="removeFromLibrary(this, {{ $data->id }}, 
                                '{{ mb_strtoupper(__('frontpage.in_library')) }}', 
                                '{{ mb_strtoupper(__('frontpage.add_to_library')) }}')">
                                <i class="fas fa-check" id="icon"></i>
                                <span id="text">{{ mb_strtoupper(__('frontpage.in_library')) }}</span>
                            </strong>
                        @endif
                    </div>
                    <a href="" class="fw12 fw400 cl6">
                        <i class="fas fa-flag-checkered"></i>
                        <span>Report story</span>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div class="about_table">
        <div class="w_layout">
            <input type="radio" id="about" name="radio">
            <input type="radio" id="content" name="radio">
            <div class="position-relative min_content" id="title">
                <label for="about" class="fs30 fw700 cl9 mb-0 click" id="abouts_label">About</label>
                <i class="_hr"></i>
                <label for="content" class="fs30 fw700 cl9 mb-0" id="contents_label">Table of Contents</label>
                <i class="_line _1"></i>
            </div>
            <div class="abouts">
                <div class="synopsis">
                    <input type="checkbox" id="readmore">
                    <div class="_readmore g_flex_center">
                        <label for="readmore" class="mb-0 mt-1">
                            <i class="fas fa-angle-down cl9"></i>
                        </label>
                    </div>
                    <h3 class="fs24 fw700">Synopsis</h3>
                    <p class="fs18">{{ $data->description }}</p>
                </div>
                <div class="tags">
                    <div class="title t align-items-center">
                        <h3 class="fs24 fw700">Tags</h3>
                        <div class="_seeall">
                            <a href="" class="fs116 fw700">See all</a>
                        </div>
                    </div>
                    <div class="moretag">
                        @foreach ($data->categories as $each)
                            <a href="{{ route('reader.tags.index', $each->slug) }}" class="d-flex align-items-center">
                                <h4 class="mb-0 fs16"># {{ $each->name }}</h4>
                                <i class="fab fa-napster"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
                <div class="rec_comics mt-4">
                    <div class="title t align-items-center">
                        <h3 class="fs24 fw700">You may also Like</h3>
                        <div class="_seeall">
                            <a href="" class="fs116 fw700">More</a>
                        </div>
                    </div>
                    <div class="more_comics d-flex mt-3">
                        @foreach ($randomComics as $each)
                            <div class="col-2 @if (!$loop->last) me-4 @endif g_col _2">
                                <a href="{{ route('reader.comics.index', $each->slug) }}">
                                    <img class="b-radius-5" width="100%" src="{{ asset($each->avatar) }}" alt="">
                                </a>
                                <div class="text mt-2">
                                    <a href="">
                                        <h4 class="fs14 fw700 text-ellipsis mb-0">{{ $each->name }}</h4>
                                    </a>
                                    <a href="{{ route('reader.comics.index', $each->slug) }}">
                                        <p class="fs12 fw400"
                                            style="max-height: 18px; white-space: nowrap; line-height: 16px;">
                                            {{ optional(optional($each->categories)[0])->name }}</p>
                                    </a>
                                    <div class="rate">
                                        @for ($i = 0; $i < 5; $i++)
                                            <i
                                                class="fas fa-star fs12 me-0 @if ($i + 1 < $each->rate) _on @endif"></i>
                                        @endfor
                                        <span class="star_avg fs16 ms-1">{{ $each->rate ?? 0 }}</span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="mt-5">
                    @include('clients.reader.comic.modal_create_review')
                    <div class="w_layout row">
                        <input type="checkbox" id="review">
                        <input type="checkbox" id="comment">
                        <div class="title position-relative min_content">
                            <label for="review" class="fs22 fw700 cl9 mb-0 click" id="reviews_label">Reviews</label>
                            <i class="_hr"></i>
                            <label for="comment" class="fs22 fw700 cl9 mb-0" id="comments_label">Comments</label>
                            <i class="_line _2"></i>
                        </div>
                        <div class="reviews mt-4">
                            <div class="d-flex border-top border-bottom">
                                <div class="col-5 border-end py-4 d-flex align-items-center justify-content-center">
                                    <h4 class="fs24 fw700 mb-0 me-3"><strong
                                            id="rate_count">{{ $data->rate_count }}</strong> Reviews</h4>
                                    <div class="rate" id="rate_total">
                                        @for ($i = 0; $i < 5; $i++)
                                            <i class="fas fa-star fs14 @if ($i + 1 < $data->rate) _on @endif"></i>
                                        @endfor
                                        <span class="fs24 fw700"
                                            style="line-height: 20px;">{{ $data->rate ?? '0.0' }}</span>
                                    </div>
                                </div>
                                <div class="col-7 d-flex py-4 flex-column align-items-center justify-content-center">
                                    <p style="height: max-content" class="mb-3">Share your thoughts with others</p>
                                    <div class="read_now d-flex">
                                        <a class="cursor_pointer" id="write_review">
                                            <b style="height: max-content; padding: 12px 24px;"
                                                class="fs14 fw700 d-flex align-items-center">
                                                <i class="fa-regular fa-comments"
                                                    style="color: white; background-color: transparent"></i>
                                                WRITE A REVIEW
                                            </b>
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-column mt-4" id="list_reviews">
                            </div>
                        </div>
                        <div class="comments">
                            @include('clients.reader.comic.modal_show_comment')
                            @include('clients.reader.comic.modal_create_comment')
                        </div>
                    </div>
                </div>
            </div>
            <div class="contents mt-5" style="display: none;">
                <h6 class="border-bottom border-dark pb-3">
                    <strong>Lastest Release:</strong>
                    @if (!$chapters->isEmpty())
                        <a href="{{ route('reader.comics.show_chapter', [$data->slug, $chapters[0]->slug]) }}"
                            id="lastest_comic" class="ms-3">
                            Chapter <span class="number">{{ $chapters[0]->number }}: </span>{{ $chapters[0]->title }}
                        </a>
                    @endif
                </h6>
                <div class="d-flex justify-content-between flex-wrap mt-4" id="list_comic">
                    @if (!$chapters->isEmpty())
                        @for ($i = count($chapters) - 1; $i >= 0; $i--)
                            <a href="{{ route('reader.comics.show_chapter', [$data->slug, $chapters[$i]->slug]) }}"
                                class="d-flex g_none_link w_48 border-bottom pb-2 ps-1 pt-2" id="comic">
                                <span class="number ms-2" style="width: 50px">{{ $chapters[$i]->number }}</span>
                                <div class="d-flex flex-column">
                                    <span class="underline fs16">{{ $chapters[$i]->title }}</span>
                                    <small class="c_s mt-2 fs12">6mth</small>
                                </div>
                            </a>
                        @endfor
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script src="https://cdn.ckeditor.com/ckeditor5/35.2.1/classic/ckeditor.js"></script>
    <script>
        var isTranslator = false;

        const showModal = (name) => {
            $(`#modal-${name}`).modal('show')
        }

        const closeModal = (name) => {
            $(`#modal-${name}`).modal('hide')
        }

        const openChooseFile = (name) => {
            $(`input[name='${name}']`).trigger('click')
        }

        const addToLibrary = (e, comicId, text1, text2) => {
            $.ajax({
                url: "{{ route('api.users.add_library') }}",
                type: "POST",
                data: {
                    comicId: comicId,
                },
                beforeSend: function() {
                    $(e).find('#icon')
                        .removeClass('fa-plus')
                        .removeClass('fa-check')
                        .addClass('fa-solid fa-spinner')
                        .css('animation', 'spinner-border 1s infinite linear');
                    $(e).find('#text')
                        .text('LOADING...')
                },
                success: function(response) {
                    if (response.success) {
                        $(e).attr('onclick', `removeFromLibrary(this, ${comicId}, '${text2}', '${text1}')`);
                        $(e).find('#icon')
                            .css('animation', 'none')
                            .removeClass('fa-solid fa-spinner')
                            .addClass('fa-check');
                        $(e).find('#text')
                            .text(text1);
                    }
                },
                error: function(response) {
                    if (!response.success) {
                        $(e).find('#icon')
                            .removeClass('fa-solid fa-spinner')
                            .addClass('fa-plus')
                            .css('animation', 'none');
                    }
                }
            })
        }

        const removeFromLibrary = (e, comicId, text1, text2) => {
            $.ajax({
                url: "{{ route('api.users.remove_library') }}",
                type: "POST",
                data: {
                    comicId: comicId,
                },
                beforeSend: function() {
                    $(e).find('#icon')
                        .removeClass('fa-plus')
                        .removeClass('fa-check')
                        .addClass('fa-solid fa-spinner')
                        .css('animation', 'spinner-border 1s infinite linear');
                    $(e).find('#text')
                        .text('LOADING...')
                },
                success: function(response) {
                    if (response.success) {
                        $(e).attr('onclick', `addToLibrary(this, ${comicId}, '${text2}', '${text1}')`);
                        $(e).find('#icon')
                            .css('animation', 'none')
                            .removeClass('fa-solid fa-spinner')
                            .addClass('fa-plus');
                        $(e).find('#text')
                            .text(text1);
                    }
                },
                error: function(response) {
                    if (!response.success) {
                        $(e).find('#icon')
                            .removeClass('fa-solid fa-spinner')
                            .addClass('fa-check')
                            .css('animation', 'none');
                    }
                }
            })
        }

        const likeReview = (action, id) => {
            $.ajax({
                url: action,
                type: 'POST',
                success: function(data) {
                    if (data.success) {
                        let like_review = $(`#like_review[data-id='${id}']`);
                        let isLike = like_review.hasClass('active');

                        if (isLike) {
                            like_review.removeClass('active')
                            like_review.find('span').text(parseInt(like_review.find('span').text()) - 1)
                        } else {
                            like_review.addClass('active')
                            like_review.find('span').text(parseInt(like_review.find('span').text()) + 1)
                        }
                    }
                }
            })
        }

        const likeComment = (action, id) => {
            $.ajax({
                url: action,
                type: 'POST',
                success: function(data) {
                    if (data.success) {
                        let like_comment = $(`#like_comment[data-id='${id}']`);
                        let isLike = like_comment.hasClass('active');

                        if (isLike) {
                            like_comment.removeClass('active')
                            like_comment.find('span').text(parseInt(like_comment.find('span').text()) - 1)
                        } else {
                            like_comment.addClass('active')
                            like_comment.find('span').text(parseInt(like_comment.find('span').text()) + 1)
                        }
                    }
                }
            })
        }

        const loading = (ele) => {
            let loadding = `<div class="d-flex justify-content-center align-items-center">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            </div>`

            $(ele).html(loadding);
        }

        const openReport = (id, name) => {
            showModal('show-report');

            let url = `{{ route('api.comments.index', ':reviewId') }}`;
            url = url.replace(':reviewId', reviewId);

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                beforeSend: function() {
                    loading('#list_comments');
                },
                success: function(response) {
                    if (response.success) {
                        $('#review_comments').html(createReview(response.data.rating))

                        $('#comment_count').html(
                            `<h6 class="fw700">${response.data.rating.commentCount} Replies</h6>`);
                        $('#list_comments').html('')
                        response.data.comments.forEach(function(item) {
                            let string = createComment(item);
                            $('#list_comments').append(string);
                        })
                    }
                },
                error: function(data) {
                    const erorrs = Object.values(data.responseJSON.errors);
                    notifyError(erorrs);
                }
            });
        }

        const createReviewStars = (rate, fs, ele) => {
            let str = '';

            if (ele) {
                ele.each(function(n) {
                    if (n + 1 <= rate) {
                        $(this).addClass('c_tertiary')
                    } else {
                        $(this).removeClass('c_tertiary')
                    }
                })
            } else {
                for (let i = 0; i < 5; i++) {
                    str +=
                        `<i class="fas fa-star fs${fs} me-0 ${i + 1 <= rate ? 'c_tertiary' : ''}"></i>`;
                }
            }

            return str;
        }

        const submitDelete = (name, id) => {
            if (confirm(`Are you sure to delete this ${name} ?`)) {
                const form = $(`#delete-${name}`);
                form.attr('action', form.attr('action').replace(':id', id));
                console.log(form.attr('action'));

                $.ajax({
                    url: form.attr('action'),
                    type: 'POST',
                    success: function(res) {
                        if (res.success) {
                            $(`#${name}-${id}`).remove();

                            var comment_count = $('#comment_count').find('span');
                            comment_count.html(parseInt(comment_count.text()) - 1);
                        }
                    }
                })
            }
        }

        const createReview = (item) => {
            let actionLike = "{{ route('api.reviews.like', ':id') }}";
            actionLike = actionLike.replace(':id', item.ratingId || item.id);

            let profileUrl = "{{ route('reader.profiles.show', ':id') }}";
            profileUrl = profileUrl.replace(':id', item.userId);

            let rate = createReviewStars(item.rate, 10);

            let timeAgo = getTimeAgo(item.updated_at_ago);

            let image = item.image ?
                `<figure class="mt-3 mb-0">
                <img class="image_upload" src="${window.location.origin + '/storage/' + item.image}" />
            </figure>` : '';

            let string =
                `
                <div class="d-flex mt-3" id="review-${item.ratingId || item.id}">
                        <a href="${profileUrl}">
                            <img id="image_review"
                                src="${window.location.origin}/${item.avatar}"
                                alt="" width="40px" height="40px">
                        </a>
                        <div class="d-flex flex-column ms-3 flex-grow-1 border-bottom pb-2">
                            <a href="${profileUrl}">
                                <h5 class="fw700 mb-0 fs16">${item.name}</h5>
                            </a>
                            <div class="rate mt-1">
                                ${rate}
                            </div>
                            <div class="m_review c_m fs16 mt-1">
                                ${item.messages}
                            </div>
                            ${image}
                            <div class="d-flex align-items-center justify-content-between mt-2">
                                <small class="c_s">${timeAgo}</small>
                                <div class="fs16 c_m d-flex align-items-center">
                                    <a class="me-2 g_hd_link cursor_pointer ${item.userLikeId ? 'active' : ''}"
                                        id="like_review"
                                        data-id="${item.ratingId || item.id}"
                                        onclick="likeReview('${actionLike}', '${item.ratingId || item.id}')">
                                        <i class="fa-regular fa-thumbs-up me-1"></i>
                                        <span>${item.like || 0}</span>
                                    </a>
                                    <a class="me-2 g_hd_link cursor_pointer" id="comment"
                                        onclick="openReviewComments(${item.commentCount || 0}, ${item.ratingId || item.id})">
                                        <i class="fa-regular fa-comment me-1"></i>  
                                        <span>${item.commentCount || 0}</span>
                                    </a>
                                    <div class="dropdown" id="report">
                                        <button class="btn p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis fs24 g_hd_link"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" onclick="openReviewReport(${item.ratingId || item.id})">Report abuse</a>
                                            ${isTranslator ? 
                                        `<form action="{{ route('api.reviews.destroy', ':id') }}" id="delete-review"><a class="dropdown-item" onclick="submitDelete('review', ${item.id || item.ratingId})">Delete</a></form>`
                                        : ''}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `
            return string;
        }

        const createComment = (item) => {
            let actionLike = "{{ route('api.comments.like', ':id') }}";
            actionLike = actionLike.replace(':id', item.id);

            let profileUrl = "{{ route('reader.profiles.show', ':id') }}";
            profileUrl = profileUrl.replace(':id', item.userId);

            let timeAgo = getTimeAgo(item.updated_at_ago);

            let image = item.image ?
                `<figure class="mt-3 mb-0">
                        <img class="image_upload" src="${window.location.origin + '/storage/' + item.image}" />
                    </figure>` : '';

            let string =
                `
                <div class="d-flex mt-3" id="comment-${item.ratingId || item.id}">
                        <a href="${profileUrl}">
                            <img id="image_review" src="${window.location.origin}/${item.avatar}" alt=""
                                width="40px" height="40px">
                        </a>
                        <div class="d-flex flex-column ms-3 flex-grow-1 border-bottom">
                            <a href="${profileUrl}">
                                <h5 class="fw700 mb-0 fs16">${item.name}</h5>
                            </a>
                            <div class="m_review c_m fs16 mt-1">
                                ${item.messages}
                            </div>
                            ${image}
                            <div class="d-flex align-items-center justify-content-between mt-1">
                                <small class="c_s">${timeAgo}</small>
                                <div class="fs14 c_m d-flex align-items-center">
                                    <a class="me-2 g_hd_link cursor_pointer ${item.userLikeId ? 'active' : ''}"
                                        id="like_comment" data-id="${item.id}" onclick="likeComment('${actionLike}', '${item.id}')">
                                        <i class="fa-regular fa-thumbs-up me-1"></i>
                                        <span>${item.like || 0}</span>
                                    </a>
                                    <div class="dropdown">
                                        <button class="btn p-0" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <i class="fa-solid fa-ellipsis fs24 g_hd_link"></i>
                                        </button>
                                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                            <a class="dropdown-item" onclick="openReviewReport(${item.id})">Report abuse</a>
                                            ${isTranslator ? 
                                        `<form action="{{ route('api.comments.destroy', ':id') }}" id="delete-comment"><a class="dropdown-item" onclick="submitDelete('comment', ${item.id})">Delete</a></form>`
                                        : ''}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                `
            return string;
        }

        const getReviews = () => {
            $.ajax({
                url: "{{ route('api.reviews.index') }}",
                type: 'GET',
                data: {
                    comic_id: "{{ $data->id }}"
                },
                dataType: 'json',
                beforeSend: function() {
                    let loadding = `<div class="d-flex justify-content-center align-items-center pt-5" id="loadding">
                            <div class="spinner-border text-primary" role="status">
                                <span class="visually-hidden">Loading...</span>
                            </div>
                            </div>`

                    $('.reviews').append(loadding);
                },
                success: function(response) {
                    if (response.success) {
                        $('.reviews').find('#loadding').remove();

                        const data = response.data.data;
                        data.forEach(function(item) {
                            let string = createReview(item);
                            $('#list_reviews').append(string);
                        })
                    }
                },
                error: function(data) {
                    const erorrs = Object.values(data.responseJSON.errors);
                    notifyError(erorrs);
                }
            });
        }

        const openReviewComments = (commentCount, reviewId) => {
            showModal('show-comment');
            $('#form-comment #rating_id').val(reviewId);

            let url = `{{ route('api.comments.index', ':reviewId') }}`;
            url = url.replace(':reviewId', reviewId);

            $.ajax({
                url: url,
                type: 'GET',
                dataType: 'json',
                beforeSend: function() {
                    let loadding = `<div class="d-flex justify-content-center align-items-center pt-5" id="loadding">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    </div>`

                    $('.list_comments').append(loadding);
                },
                success: function(response) {
                    if (response.success) {
                        $('#review_comments').html(createReview(response.data.rating))

                        $('#comment_count').html(
                            `<h6 class="fw700"><span>${response.data.rating.commentCount}</span> Replies</h6>`
                        );
                        $('#list_comments').html('')
                        response.data.comments.forEach(function(item) {
                            let string = createComment(item);
                            $('#list_comments').append(string);
                        })
                    }
                },
                error: function(data) {
                    const erorrs = Object.values(data.responseJSON.errors);
                    notifyError(erorrs);
                }
            });
        }

        $(document).ready(function() {

            $(".number").each(function() {
                if (isInt($(this).text())) {
                    $(this).text(parseInt($(this).text()));
                }
            })

            let m = 0;
            $('.content #comic').each(function(n) {
                if (n == m + 4) {
                    m += 4;
                }
                if (n >= m + 2) {
                    $(this).addClass('bg-light');
                }
            })

            $('#write_review').click(function() {
                $('#reviews_label').trigger('click');
            })

            let check = true;
            $(window).scroll(function() {
                if (parseInt($('#rate_count').text()) > 0 && check) {
                    var info_comic_h = $('.info_comic').height();
                    var title_h = $('.about_table #title').height();
                    var synopsis_h = $('.synopsis').height();
                    var tags_h = $('.tags').height();
                    var rec_comics_h = $('.rec_comics').height();

                    let height = info_comic_h + title_h + synopsis_h + tags_h + rec_comics_h;

                    if ($(this).scrollTop() >= height - 150) {
                        //Get Reviews First Time:
                        getReviews();
                        $(this).unbind('scroll');
                    }
                } else check = false;
            });
        })
    </script>
    @if (user() && $data->user_id === user()->id)
        <script>
            isTranslator = true;
        </script>
    @endif
    <script>
        ClassicEditor
            .create(document.querySelector('#editor'), {
                toolbar: [],
                autosave: {
                    save(editor) {
                        return saveData(editor.getData());
                    }
                }
            })
            .then(editor => {
                window.editor = editor;
                $('.ck-reset_all').remove();

                displayStatus(editor);
            })
            .catch(err => {
                console.error(err.stack);
            });

        ClassicEditor
            .create(document.querySelector('#editor_c'), {
                toolbar: [],
                autosave: {
                    save(editor) {
                        return saveData(editor.getData());
                    }
                }
            })
            .then(editor_c => {
                window.editor_c = editor_c;
                $('.ck-reset_all').remove();

                displayStatus(editor_c);
            })
            .catch(err => {
                console.error(err.stack);
            });

        // Save the data to a fake HTTP server (emulated here with a setTimeout()).
        function saveData(data) {
            return new Promise(resolve => {
                setTimeout(() => {
                    console.log('Saved', data);

                    resolve();
                }, HTTP_SERVER_LAG);
            });
        }

        // Update the "Status: Saving..." info.
        function displayStatus(editor) {
            const pendingActions = editor.plugins.get('PendingActions');
            const statusIndicator = document.querySelector('#editor-status');

            pendingActions.on('change:hasAny', (evt, propertyName, newValue) => {
                if (newValue) {
                    statusIndicator.classList.add('busy');
                } else {
                    statusIndicator.classList.remove('busy');
                }
            });
        }
    </script>
    <script>
        /// About Table Contents Events
        const setEventsMouse = (class_1, class_2, class_line) => {
            $(`#${class_1}_label`).mouseenter(function() {
                $(`._line.${class_line}`).addClass('right');
            });
            $(`#${class_1}_label`).mouseout(function() {
                $(`._line.${class_line}`).removeClass('right');
            });
            $(`#${class_1}_label`).click(function() {
                $(`._line.${class_line}`).addClass('right');
                $(this).unbind('mouseout mouseover');
                $(`.${class_2}`).hide();
                $(`.${class_1}`).show();

                $(`#${class_2}_label`).mouseenter(function() {
                    $(`._line.${class_line}`).removeClass('right');
                });
                $(`#${class_2}_label`).mouseout(function() {
                    $(`._line.${class_line}`).addClass('right');
                });
            });
            $(`#${class_2}_label`).click(function() {
                $(`._line.${class_line}`).removeClass('right');
                $(this).unbind('mouseout mouseover');
                $(`.${class_1}`).hide();
                $(`.${class_2}`).show();

                $(`#${class_1}_label`).mouseenter(function() {
                    $(`._line.${class_line}`).addClass('right');
                });
                $(`#${class_1}_label`).mouseout(function() {
                    $(`._line.${class_line}`).removeClass('right');
                });
            });
        }
        setEventsMouse('contents', 'abouts', '_1');
        setEventsMouse('comments', 'reviews', '_2');
    </script>
    <script>
        //Update Score
        var arrName = [
            'wqscore',
            'souscore',
            'sdscore',
            'cdscore',
            'wbscore'
        ]

        const calculateScore = () => {
            if ($('._rated').length === 5 && $('.modal-create-review .ck.ck-content').text().length >= 140) {
                $('#postReview').removeClass('disabled')
            }

            let score = 0;
            score = $('i.rated').length / $('._rated').length
            $('input[name="rate"]').val(parseFloat(score).toFixed(2))

            createReviewStars(score, '', $('.rate_main i'));
        }

        arrName.forEach((name) => {
            $(`i[name="${name}"]`).each(function(n, e) {
                $(e).click(function() {
                    $(e).parent().addClass('_rated');
                    for (let index = 0; index <= n; index++) {
                        $(`i[name="${name}"]`).eq(index).addClass('rated c_tertiary');
                    }
                    for (let index = n + 1; index < 5; index++) {
                        $(`i[name="${name}"]`).eq(index).removeClass('rated c_tertiary');
                    }
                    calculateScore();
                })
            })
        })

        const updateReview = (data) => {
            $('input[name="rate"]').val('0.0');
            $('#image_upload').attr('src', '');
            $('input[name="image"]').val('');
            $('#postReview').addClass('disabled');

            //Add New Review
            let string = createReview(data);
            $('#list_reviews').prepend(string);

            //Update Rate Total Reviews
            let rate_count = parseInt($('#rate_count').text());
            let rate_total = parseFloat($('#rate_total').find('span').text());

            $('#rate_total').find('span').text(
                ((rate_total * rate_count + parseFloat(data.rate)) / (rate_count + 1))
                .toFixed(1));
            $('#rate_count').text(parseInt($('#rate_count').text()) + 1);
            rate_total = parseFloat($('#rate_total').find('span').text());

            //Update Rate Star
            let rate_stars = $('#rate_total').find('i');
            createReviewStars(rate_total, '', rate_stars);
        }

        const updateComment = (data) => {
            $('#image_upload_c').attr('src', '');
            $('input[name="image_c"]').val('');
            $('#postComment').addClass('disabled');

            //Add New Review
            let string = createComment(data);
            $('#list_comments').prepend(string);
        }

        const submitFormCreate = (name) => {
            const form = $(`#form-${name}`);
            const formData = new FormData(form[0]);
            formData.set('messages', $(`#form-${name} .ck.ck-content`).html());

            $.ajax({
                url: form.attr('action'),
                type: 'POST',
                dataType: 'json',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if (response.success) {
                        $(`#modal-${name}`).modal('hide');

                        if (name === "create-review") {
                            updateReview(response.data);

                            $('.rate_ele._rated').each(function(n, e) {
                                $(e).removeClass('_rated');
                                $(e).find('i').each(function(n, e) {
                                    $(e).removeClass('rated c_tertiary');
                                })
                                $('.ck-editor__editable').find('p').text('');
                            })
                            $('.rate_main i').each(function(n, e) {
                                $(e).removeClass('rated c_tertiary');
                            })
                        } else if (name === "create-comment") {
                            updateComment(response.data);
                        }
                    }
                },
                error: function(data) {
                    // const erorrs = Object.values(data.responseJSON.errors);
                    // notifyError(erorrs);
                }
            });
        }

        //Enable Post Review
        $(`#form-create-review .ck.ck-content`).keyup(function() {
            var text = $(this).text();

            if (text.length >= 140 && $('._rated').length === 5) {
                $('#postReview').removeClass('disabled')
            } else {
                $('#postReview').addClass('disabled')
            }
        })


        //Enable Post Comment
        $('#form-create-comment .ck.ck-content').keyup(function() {
            var text = $(this).text();

            if (text.length > 0) {
                $('#postComment').removeClass('disabled')
            } else {
                $('#postComment').addClass('disabled')
            }
        })
    </script>
    @if (user())
        <script>
            $('#write_review').click(function() {
                showModal('create-review');
            })
            $('#write_comment').click(function() {
                showModal('create-comment');
            })
        </script>
    @else
        <script>
            $('#write_review, #write_comment').click(function() {
                $('.log_function').addClass('hold_show')
            })
        </script>
    @endif
@endpush
