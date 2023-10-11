<script src="{{ asset('js/helper.js') }}"></script>
<script>
    const search = (val) => {
        $.ajax({
            url: "{{ route('api.comics.search') }}",
            data: {
                q: val
            },
            type: "GET",
            success: function(response) {
                if (response.success && response.data.length > 0) {
                    $('.products').addClass('show');
                    addComicSearch(response.data);
                }
            },
            error: function(response) {}
        })
    }

    const addComicSearch = (arr) => {
        $('.products').empty();
        arr.forEach(element => {
            let urlComic = "{{ route('reader.comics.index', ':slug') }}";
            urlComic = urlComic.replace(':slug', element.slug);

            let avatar =
                `<img src="${window.location.origin + '/' + element.avatar}" alt="" />`;
            let chapter_0 =
                element.chapter_slug_0 ?
                `<a href = "${window.location.origin + '/comics/' + element.slug + '/' + element.chapter_slug_0}" >` :
                '';
            let chapter_1 =
                element.chapter_slug_1 ?
                `<a href = "${window.location.origin + '/comics/' + element.slug + '/' + element.chapter_slug_1}" >` :
                '';

            console.log(element.chapter_number_1 % 1);

            $('.products').append($('<div class="product">')
                .append($(`<a  id = "pro_img" href = ${urlComic} > `)
                    .append($(avatar))
                )
                .append($('<div class="info">')
                    .append($('<div class="title">')
                        .append($(
                            `<a href = "${'http://' + window.location.hostname + '/comics/' + element.slug}" >`
                        ).append(element.name)))
                    .append($('<div class="chapter">')
                        .append($(`<p>Chương</p>`))
                        .append($(chapter_0)
                            .append(
                                isInt(element.chapter_number_0) ?
                                parseInt(element.chapter_number_0) :
                                element.chapter_number_0
                            ))
                        .append($(chapter_1)
                            .append(
                                isInt(element.chapter_number_1) ?
                                parseInt(element.chapter_number_1) :
                                element.chapter_number_1
                            ))
                    )
                )
            )
        });
    }

    $('.search').on('input', function(e) {
        clearTimeout(this.delay)
        $('.products').removeClass('show');

        this.delay = setTimeout(() => {
            if (e.target.value != "") {
                search(e.target.value);
            } else $('.products').empty();;
        }, 200);
    })

    $(document).on('click', function(e) {
        if (!$(e.target).closest('.search').length) {
            $('.products').removeClass('show');
        }
        if ($(e.target).closest('.search').length) {
            if ($('.products').html().trim() != "") {
                $('.products').addClass('show');
            }
        }
    })
</script>
