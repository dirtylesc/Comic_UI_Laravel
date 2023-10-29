import { CODE_API_NO, PATH_API_COMIC, PATH_API_DESTROY, PATH_API_PRIV, RES_CODE, RES_DATA } from "/js/constants/api.js";
import { reqStatusObj } from "/js/constants/comicStatus.js";
import { renderComicItems } from "./tmpl.js";

function submitDeleted(id) {
    if (!confirm('You want to delete this comic, right?')) {
        return;
    }

    const apiDestroy = PATH_API_PRIV + PATH_API_COMIC + PATH_API_DESTROY;

    fetch(apiDestroy, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            id: id
        }),
    })
    .then(res => {
        return res.json();
    })
    .then(data => {
        if(data[RES_CODE] == CODE_API_NO) {
            return;
        }
    })
}

const filterCategory = () => {
    showDataTable();
}

const changeStatus = (chapter_id, old_status, status, status_name) => {
    if (confirm('You want to change status this comic, right?')) {
        const url = "{{ route('api.comics.change_status', ':id') }}";
        url = url.replace(':id', chapter_id);

        $.ajax({
            url: url,
            data: {
                status: status || 0
            },
            type: 'POST',
            success: function(response) {
                if (response.success) {
                    $('.status[data-id="' + chapter_id + '"]')
                        .text(status_name || 'Đang tiến hành')
                        .removeClass(addClassStatus(old_status ?? 4))
                        .addClass(addClassStatus(status ?? 0));

                    notifySuccess(response.message);
                }
            },
            error: function(data) {}
        });
    };
}

const reformatBeforeRender = (lst) => {
    $.each(lst, (i, item) => {
        item.status = reqStatusObj(parseInt(item.status))
    })

    return lst;
}

export const showDataTable = (isSuperAdmin) => {
    let apiUrl  = PATH_API_PRIV + PATH_API_COMIC + '?'

    const objData = {
        categories  : $('#select-category').val() || [],
        q           : $('#search').val()          || '',
        status      : $('#select-status').val() >= 0 ? 
                      $('#select-status').val() : [],
    }

    apiUrl += new URLSearchParams({
        ...objData
    })

    fetch(apiUrl, {
        method: "GET",
        headers: {
            "Content-Type": "application/json"
        },
    })
    .then(res => {
        return res.json();
    })
    .then(data => {
        $('#tbody-data').empty();

        if(data[RES_CODE] == CODE_API_NO) return;

        let lstComics   = data[RES_DATA];
        if(!lstComics || lstComics.length <= 0) return;

        lstComics       = reformatBeforeRender(lstComics)

        const template  = renderComicItems(lstComics);
    
        $('#tbody-data').html(template);
        doBindEvent()

        // lstComics.forEach(each => {
            //     let avatar =
            //         `<img width = '85px' height = '85px'
            //             class="bg-info rounded-circle"
            //             style="object-fit: cover"
            //             src = "${window.location.origin + '/' + each.avatar}" />`
    
            //     let url = "{{ route('admin.comics.chapters.index', ':slug') }}";
            //     url = url.replace(':slug', each.slug);
    
            //     let rate = '';
            //     for (let index = 1; index <= 5; index++) {
            //         if (index <= parseFloat(each.rate)) {
            //             rate += '<i class="fas fa-star fs12 _on"></i>'
            //         } else {
            //             rate += '<i class="fas fa-star fs12"></i>'
            //         }
            //     }
            //     let info =
            //         `<a href="${url}" 
            //             class="fw700">
            //             ${each.name}
            //         </a>
            //         ${each.alias ? ' - ' + each.alias : ''}
            //         <br>
            //         Author: <strong>${each.author}</strong>
            //         <br>
            //         <div class="rate">${rate} (${each.count_rate})</div>`
    
            //     let categories =
            //         `<span class="badge bg-info">${each.language}</span>`;
            //     each.categories.forEach(category => {
            //         categories +=
            //             `<span class="badge bg-info">${category.name}</span>`
            //     })
            //     let description = !!each.description ?
            //         `<span class='text-ellipsis' style="-webkit-line-clamp: 3;">${each.description}</span>` :
            //         ''
    
            //     let created_at = convertDateToDateTime(each.created_at)
            //     let action = `
            //         <a  class="btn btn-primary col-12 mb-1" 
            //             href="${window.location + '/edit/' + each.id}"
            //         >
            //             Edit
            //         </a>
            //         <form action=${window.location + '/destroy/' + each.id} method="POST" id="form-delete">
            //             @csrf
            //             <button class="btn btn-secondary col-12" onclick="submitDeleted()">Delete</button>
            //         </form>
            //         `
    
            //     $('#tbody-data').append($('<tr>')
            //         .append($('<td>').append(each.id))
            //         .append($('<td>').append(avatar))
            //         .append($('<td class="col-3">').append(info))
            //         .append($('<td class="col-1">').append(categories))
            //         .append($('<td class="col-2">').append(description))
            //         .append($('<td>').append(status))
            //         .append($('<td>').append(created_at))
            //         .append($('<td class="col-1">').append(action))
            //     )
            // });

        // $('.pagination').empty();
        // renderPagination(response.data.pagination);
    })
    .catch(response => {
        console.log('====================================');
        console.log(response);
        console.log('====================================');
        // const erorrs = Object.values(response.responseJSON.errors);
        // showError($('#errors-category'), [erorrs]);
    });
}

const doBindEvent = () => {
    $('.btn-delete-comic').off('click').on('click', function() {
        const id = $(this).attr("data-id");
        if(id <= 0) return;

        submitDeleted(id)
    })
}

$(document).ready(function() {
    //Show Data For Select2 Category
    $("#select-category").select2({
        ajax: {
            delay: 250,
            url: `{{ route('api.categories.index') }}`,
            data: function(params) {
                const queryParameters = {
                    q: params.term
                }

                return queryParameters;
            },
            processResults: function(data) {
                return {
                    results: $.map(data.data, function(item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },

        }
    });

    $('#select-status').change(function() {
        showDataTable();
    })

    $('#search').change(function() {
        showDataTable();
    });

    $('button#new').off('click').on('click', function() {
        $('#modal-edit-chapter').modal('show');
    });

    //Event Click Pagination
    $(document).on('click', '#pagination > li > a', function(e) {
        let page = $(this)[0].getAttribute('page') || 1;

        const url = new URL(window.location.href);
        url.searchParams.set('page', page);

        window.location.href = url;
    })
});