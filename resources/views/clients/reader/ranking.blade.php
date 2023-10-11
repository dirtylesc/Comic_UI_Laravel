@extends('layouts.reader.master')
@push('css')
    <link rel="stylesheet" href="{{ asset('css/reader/style2.css') }}">
    <link rel="stylesheet" href="{{ asset('css/reader/ranking.css') }}">
@endpush()
@section('content')
    <div class="d-flex w_layout pe-0 mt-5">
        <div class="list_checked">
            <form action="">
                <div class="title align-items-center border-bottom pb-2">
                    <h3 class="fs20 fw900 mb-2">Hot Ranking</h3>
                </div>
                <div class="title align-items-center border-bottom pb-2">
                    <h3 class="fs20 fw900 mb-2 ">Comic Ranking</h3>
                    <i class="fas fa-angle-down up me-1"></i>
                </div>
                <div class="genre _on">
                    <input type="checkbox" id="check_1">
                    <input type="checkbox" id="check_2">
                    <ul class="list_male show pt-0">
                        @foreach ($arrRankName as $rankName)
                            <li><a
                                    class="fs16 cursor_pointer  
                                    @if (request()->get('rankName') === $rankName) clicked 
                                    @elseif(request()->get('rankName') == null && $loop->first) clicked @endif
                                ">{{ $rankName }}</a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </form>
        </div>
        <div class="function ms-4">
            <div class="filter">
                <h3 class="fs20 fw700 cl6 mb-0">Trending Ranking</h3>
                <div class="content">
                    <div class="status position-relative">
                        <h5 class="cl6 mb-0 fs12">Other Filters</h5>
                        <a class="fs12 d-flex align-items-center justify-content-between border mt-2" id="filter">
                            <span class="fw400 ms-1">Weekly Filter</span>
                            <i class="fa-solid fa-chevron-down"></i>
                        </a>
                        <form action="" class="flex-column position-absolute">
                            <fieldset id="fieldset_1">
                                <legend class="cl6 fs12">Time range of Power Stone being voted the most</legend>
                                @foreach ($arrTimeType as $timeType => $val)
                                    <label for="" class="col-12 position-relative cursor_pointer">
                                        <span class="fw400" id="text">{{ $timeType }}</span>
                                        <span>
                                            <input type="radio" name="timeType" value="{{ $val }}" class="d-none"
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
            <div class="list_comics">
            </div>
        </div>
        <div class="list_load_comic">
        </div>
    </div>
@endsection
@push('js')
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

            comic.classList.add("d-flex")

            let number_color = '';
            if (1 == 0) number_color = 'c_secondary'
            else if (1 == 1) number_color = 'c_tertiary'
            else if (1 == 2) number_color = 'c_quaternary'
            else number_color = 'c_m'

            let number_text = '';
            if (1 + 1 < 100)
                number_text = '00' + (1 + 1)
            else if (1 + 1 < 10)
                number_text = '0' + (1 + 1)
            else
                1 + 1

            let str = '';
            if (item.addedLibraries != null) {
                str = `
                <p class="cursor_pointer fs12 fw400 pe-3 disabled">
                    <b></span><span id="text">IN LIBRARY</span></b>
                </p>`
            } else {
                str = `
                <p class="cursor_pointer fs12 fw400 mt-1" onclick="addToLibrary(this, ${item.id}, 'IN LIBRARY')">
                    <b><span class="fas fa-plus me-1 g_icon_add"></span><span class="c_origin">ADD</span></b>
                </p>`
            }

            comic.innerHTML = `
                    <h3
                        class="fs16 ff_number lc1_5 me-3 mt-3 ${number_color}">
                        ${number_text}
                    </h3>
                    <a class="a_scale" href="" style="min-width: 48px; width: 48px; height: 64px;">
                        <img class="img_scale w_100 h_100"
                            src="https://img.webnovel.com/bookcover/14622895506049901/150/150.jpg?coverUpdateTime=1578976350360&imageMogr2/quality/80"
                            alt="">
                    </a>
                    <div class="flex-grow-1 ms-3">
                        <a href="" class="g_none_link" title="Tales of Demons and Gods">
                            <h4 class="fs16 fw700 underline">
                                Tales of Demons and Gods
                            </h4>
                        </a>
                        <p class="c_m fw400 fs14 text-ellipsis wlc_2">
                            "The world overturns as demons arrive..." #Eastern Fantasy #WeaktoStrong
                            #2020
                            Male Lead No.2
                            【Update Mon Wed】A warp in space-time occured</p>
                        <div class="d-flex fs12 fw400 mt-1">
                            <div class="d-flex align-items-center c_m" id="power">
                                <img class="f_c_m" width="16px" src="{{ asset('images/power.svg') }}" alt="">
                                <span class="ms-1 border-right pe-2" style="height: 12px; line-height: 12px;">818</span>
                            </div>
                            <div class="fs12 ps-2 d-flex align-items-center">
                                <a href="" title="" class="g_none_link c_m">
                                    <span class="underline">Fantastic</span>
                                </a>
                                <span class="_dot cursor_default">.</span>
                                <span>Taxue Comics</span>
                            </div>
                        </div>
                    </div>
                    <div class="d-flex max_content">
                        <div class="read_now d-flex ms-2">
                            <a href="http://web_truyen_tranh.test/comics/only-i-level-up-%28solo-leveling-2%29/chapter-1.5">
                                <b class="fs12 text_uppercase py-0" style="height: max-content">Read</b>
                            </a>
                        </div>
                    </div>
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
        const listRank = $('ul.show').find('li');
        const listTime = $('#fieldset_1 > label');
        const changeComics = (rankName, timeType, page) => {
            $.ajax({
                url: "{{ route('api.comics.ranking') }}",
                data: {
                    rankName: rankName ?? listRank.find('a.clicked').text(),
                    timeType: timeType ?? listTime.find('input[name="timeType"]:checked').val(),
                    page: page ?? 0,
                },
                type: "GET",
                beforeSend: function() {
                    list_comics.html('');
                    add_load_comic(10);
                },
                success: function(response) {
                    list_comics.find('.load_comic').remove();
                    response.data.forEach(element => {
                        addComics(element)
                    });
                },
                error: function(response) {},
            })
        }

        const pushState = (rankName, timeType) => {
            window.history.pushState("", "",
                `?rankName=${rankName}&timeType=${timeType}`
            );
        }
    </script>
    <script>
        $(document).ready(function() {
            $('#filter').click(function() {
                $(this).toggleClass('_on')
            });

            var currentUrlString = window.location.href;
            var currentUrl = new URL(currentUrlString);
            const listTime = $('#fieldset_1 > label');
            const listRank = $('ul.show').find('li');

            //Get Comics First Time:
            changeComics();

            listTime.each(function(e) {
                $(this).click(function() {
                    const checked = $(this).find('input').attr('checked');
                    if (checked === undefined || checked === false) {
                        listTime.find('input[name="timeType"]:checked').attr(
                            'checked', false);
                        $(this).find('input').attr('checked', true);

                        const timeText = $(this).find('#text').text();
                        $('#filter').find('span').text(timeText + " Filter");

                        const timeType = $(this).find('input[name="timeType"]:checked').val();
                        pushState(listRank.find('a.clicked').text(), timeType)

                        // changeComics(listRank.find('a.clicked').text(), timeType);
                    }
                })
            });

            listRank.each(function(e) {
                $(this).click(function() {
                    const hasClicked = $(this).find('a').hasClass('clicked');
                    if (hasClicked === false) {
                        listRank.find('a.clicked').removeClass('clicked');
                        $(this).find('a').addClass('clicked');

                        const rankText = $(this).find('a.clicked').text();

                        pushState(rankText, listTime.find('input[name="timeType"]:checked').val())

                        // changeComics(listRank.find('a.clicked').text(), timeType);
                    }
                })
            });
        });
    </script>
@endpush
