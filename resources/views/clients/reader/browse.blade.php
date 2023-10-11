@extends('layouts.reader.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/reader/browse.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reader/style2.css') }}">
@endpush()
@section('content')
    <div class="d-flex w_layout pe-0 mt-5">
        <div class="nothing1" id="nothing1"></div>
        <h2 style="margin-bottom: 1rem; padding-left: 3.1rem; " id="list_tag">List Tag Comic</h2>
        <div class="list_checked">
            <form action="">
                <div class="title align-items-center">
                    <h3 class="fs20 fw900 mb-0 ">Genre of Comics</h3>
                    <i class="fas fa-angle-down up me-1"></i>
                </div>
                <div class="genre _on">
                    <ul class="list_male show">
                        <li><a class="fs16 cursor_pointer">All</a></li>
                        @foreach ($arrGenre as $genre)
                            <li>
                                <a class="fs16 cursor_pointer" data-id="{{ $genre->id }}">{{ $genre->name }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </form>
        </div>
        <div class="function ms-4">
            <div class="filter">
                <h3 class="fs20 fw700 cl6 mb-0">{{ __('frontpage.filter_by') }}</h3>
                <div class="content d-flex">
                    <div class="status col-6">
                        <h5 class="cl6 mb-0 fs14">{{ __('frontpage.content_status') }}</h5>
                        <div class="list_content">
                            <label for="">
                                <input type="radio" value="-1">
                                <strong>{{ __('frontpage.all') }}</strong>
                            </label>
                            @foreach ($arrStatus as $status => $key)
                                <label for="">
                                    <input type="radio" value="{{ $key }}">
                                    <strong>{{ __('frontpage.' . strtolower($status)) }}</strong>
                                </label>
                            @endforeach
                        </div>
                    </div>
                    <div class="time col-6">
                        <h5 class="cl6 mb-0 fs14">{{ __('frontpage.time') }}</h5>
                        <a class="fs12 d-flex align-items-center justify-content-between border mt-2" id="filter">
                            <span class="fw400 ms-1">Weekly Filter</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </a>
                        <form action="" class="flex-column position-absolute">
                            <fieldset id="fieldset_1">
                                <legend class="cl6 fs12">{{ __('frontpage.time_filter_title') }}</legend>
                                @foreach ($arrTimeType as $timeType => $val)
                                    <label for="" class="col-12 position-relative cursor_pointer">
                                        <span class="fw400" id="text">
                                            {{ __('frontpage.' . strtolower($timeType)) }}
                                        </span>
                                        <span>
                                            <input type="radio" name="timeType" value="{{ $val }}"
                                                class="d-none"
                                                @if (request()->get('timeType') == $val) checked ="true" 
                                                    @elseif(request()->get('timeType') == null && $loop->first) checked ="true" @endif>
                                            <i class="fa-solid fa-check position-absolute mt-1" style="right: 0"></i>
                                        </span>
                                    </label>
                                @endforeach
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
            <div class="sort">
                <h3 class="fs20 fw700 cl6 mb-0">{{ __('frontpage.sort_by') }}</h3>
                <div class="list_content">
                    @foreach ($arrSort as $key => $val)
                        <label for="">
                            <input type="radio" value="{{ $key }}">
                            <strong>{{ __('frontpage.' . strtolower($val)) }}</strong>
                        </label>
                    @endforeach
                </div>
            </div>
            <div class="list_comics">
            </div>
        </div>
        <div class="list_load_comic">
        </div>
    </div>
@endsection
@push('js')
    <script type="module" src="{{ asset('js/reader/browse.js') }}"></script>
    <script type="module" src="{{ asset('js/helper.js') }}"></script>
    <script>
        const addToLibrary = (e, comicId, text) => {
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
                        .text('LOAD')
                },
                success: function(response) {
                    if (response.success) {
                        $(e).attr('onclick', '')
                            .addClass('disabled');
                        $(e).find('#icon').remove();
                        $(e).find('#text')
                            .text(text);
                    }
                },
                error: function(response) {
                    if (!response.success) {
                        $(e).find('#icon')
                            .removeClass('fa-solid fa-spinner')
                            .addClass('fa-plus')
                            .css('animation', 'none');
                        $(e).find('#text')
                            .text('ADD');
                    }
                }
            })
        }
    </script>
    <script>
        var list_comics = $('.list_comics');
        const addComics = (item) => {
            var comic = document.createElement("div")

            comic.classList.add("comic")

            let tags = '';

            for (let index = 0; index < 3; index++) {
                tags += item.categories[index] ? `<a href="###">#${item.categories[index].name}</a>` : ''
            }

            let str = '';
            if (item.addedLibraries != null) {
                str = `
                <p class="cursor_pointer fs12 fw400 pe-3 disabled">
                    <b></span><span id="text">IN LIBRARY</span></b>
                </p>`
            } else {
                str = `
                <p class="cursor_pointer fs12 fw400 pe-3"
                    onclick="addToLibrary(this, ${item.id}, 'IN LIBRARY')">
                    <b><span class="fas fa-plus me-1 g_icon_add" id="icon"></span><span id="text">ADD</span></b>
                </p>`
            }

            comic.innerHTML = `
            <a href="${window.location.origin + '/comics/' + item.slug}">
                <img src="${window.location.origin + '/' + item.avatar}" alt="">
            </a>
            <div class="comic_info">
                <div class="tags align-items-center">
                    ${tags}
                </div>
                <a href="${window.location.origin + '/comics/' + item.slug}">
                    <h4 class="fs17 fw700 cl9">${item.name + (item.alias ? ` (${item.alias})` : '')}</h4>
                </a>
                <div class="text cl9 fs14 fw400"><p class="text-ellipsis">${item.description}</p></div>
                <div class="rate fs12 fw400 cl6">
                    <i class="fas fa-star"><p id="star" class="fs14">${item.rate || 0}</p></i>
                    <i class="fas fa-file-alt"><p class="fs14">${item.chapter_count} Chapters</p></i>
                    ${str}
                </div>
            </div>
          `
            list_comics.append(comic)
        }

        const list_load_comic = $('.list_load_comic');

        function add_load_comic(n) {
            for (let index1 = 0; index1 < n; index1++) {
                var newL = document.createElement("div")
                newL.classList.add("load_comic", "h_120_")
                newL.innerHTML = `<h2 class="fw700 fs20 ls20 cl6">DIRTYLESC</h2>`
                list_comics.append(newL)
            }
        }

        var timeout;
        var page = 1;
        const changeComics = (category, status, sort, timeType, search) => {
            $.ajax({
                url: "{{ route('api.comics.stories') }}",
                data: {
                    category: category ?? -1,
                    status: status ?? -1,
                    sort: sort ?? -1,
                    timeType: timeType ?? 0,
                    search: search ?? '',
                    page: page ?? 1,
                },
                type: "GET",
                beforeSend: function() {
                    if (page == 1) {
                        add_load_comic(10);
                    } else {
                        list_comics.append(`
                            <div class="col-12 my-5 d-flex justify-content-center align-items-center loading">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading...</span>
                                </div>
                            </div>`)
                    }
                },
                success: function(response) {
                    if (page == 1) {
                        list_comics.find('.load_comic').remove();
                    } else {
                        list_comics.find('.loading').remove();
                    }
                    response.data.data.forEach(element => {
                        addComics(element)
                    });
                },
                error: function(response) {},
            })
        }

        $(document).ready(function() {
            $('#filter').click(function() {
                $(this).toggleClass('_on')
            });

            $(window).click(function(e) {
                if (!$(e.target).closest('.time form').length && !$(e.target).closest('#filter').length) {
                    $('#filter').removeClass('_on')
                }
            });

            var english = /^[A-Za-z0-9]*$/;
            var locale = 'vi';

            var currentUrlString = window.location.href;
            var currentUrl = new URL(currentUrlString);

            let search = currentUrl.searchParams.get("search") || '';
            let sort_radio = currentUrl.searchParams.get("sort") || 0;
            let category = currentUrl.searchParams.get("category") || 'all';
            let status_radio = currentUrl.searchParams.get("status") || -1;
            let timeType = currentUrl.searchParams.get("timeType") || 0;
            changeComics(category.toLowerCase(), status_radio, sort_radio, timeType, search);

            //Hiển thị theo category
            var list_category = $(".genre .show li a");
            list_category.each(function(n, e) {
                if ($(e).text().toLowerCase().replace('+', '') == category.trim()) {
                    $(e).addClass('clicked');
                }
                e.onclick = () => {
                    if ($(e).text() != category) {
                        list_comics.innerHTML = "";
                        $('.genre .show li a.clicked').removeClass('clicked');
                        e.classList.add('clicked');

                        category = e.text;
                        pushState(category.toLowerCase(), status_radio, sort_radio, timeType, search);

                        list_comics.html('');
                        page = 1;
                        changeComics(category.toLowerCase(), status_radio, sort_radio, timeType,
                            search);
                    }
                }
            })

            ///Hiển thị theo sort by
            var list_sort = $(".sort .list_content label");
            list_sort[sort_radio].classList.add('clicked_radio');
            list_sort.each((n, e) => {
                e.onclick = () => {
                    if (n != sort_radio) {
                        list_comics.innerHTML = ""
                        list_sort.get(sort_radio).classList.remove("clicked_radio")
                        list_sort.get(n).classList.add("clicked_radio")

                        sort_radio = n;
                        pushState(category.toLowerCase(), status_radio, sort_radio, timeType, search);

                        list_comics.html('');
                        page = 1;
                        changeComics(category.toLowerCase(), status_radio, sort_radio, timeType,
                            search);
                    }
                }
            })

            ///Hiển thị theo status
            var list_status = $(".status .list_content label");
            let oldStatus = -1;
            list_status.each((n, e) => {
                if ($(e).find("input").val() == status_radio) {
                    oldStatus = n;
                    $(e).addClass('clicked_radio');
                }
                e.onclick = () => {
                    if (e.children[0].value != status_radio) {
                        list_comics.innerHTML = "";
                        list_status.get(oldStatus).classList.remove("clicked_radio")
                        e.classList.add('clicked_radio');

                        status_radio = e.children[0].value;
                        oldStatus = n;

                        pushState(category.toLowerCase(), status_radio, sort_radio, timeType, search);

                        list_comics.html('');
                        page = 1;
                        changeComics(category.toLowerCase(), status_radio, sort_radio, timeType,
                            search);
                    }
                }
            });

            const listTime = $('#fieldset_1 > label');
            let timeText = listTime.eq(timeType).find('#text').text().replace('/n', '').trim();
            if (english.test(timeText)) {
                locale = 'en';
            }

            if (locale === 'en') {
                $('#filter').find('span').text(timeText + " Filter");
            } else if (locale === 'vi') {
                $('#filter').find('span').text("Lọc: " + timeText);
            }

            listTime.each(function(e) {
                $(this).click(function() {
                    const checked = $(this).find('input').attr('checked');
                    if (checked === undefined || checked === false) {
                        listTime.find('input[name="timeType"]:checked').attr(
                            'checked', false);
                        $(this).find('input').attr('checked', true);

                        timeText = $(this).find('#text').text();
                        $('#filter').find('span').text(timeText + " Filter");

                        $('#filter').removeClass('_on');

                        timeType = $(this).find('input[name="timeType"]:checked').val();
                        pushState(category.toLowerCase(), status_radio, sort_radio, timeType,
                            search)

                        list_comics.html('');
                        page = 1;
                        changeComics(category.toLowerCase(), status_radio, sort_radio, timeType,
                            search);
                    }
                })
            });


            $(window).scroll(function() {
                if (list_comics.find('.comic').length == page * 10) {
                    var list_comics_h = list_comics.height();

                    if ($(this).scrollTop() >= list_comics_h) {
                        page++;
                        changeComics(category.toLowerCase(), status_radio, sort_radio, timeType, search);
                    }
                } else checkScroll = false;
            });
        })
    </script>
@endpush
