import { CODE_API_YES, PATH_API_CATEGORY, PATH_API_CHECK_SLUG, PATH_API_COMIC, PATH_API_PRIV, PATH_API_STORE, PATH_API_TRANSLATOR, PATH_APT_VIEW, RES_CODE, RES_COUNT } from "../../constants.js";
import { reqObjectFromFormData, reqPathApi, slugify } from '../../helper.js';

const checkSlug = (slug) => {
    const apiUrl = PATH_API_PRIV + PATH_API_COMIC + PATH_API_CHECK_SLUG;

    fetch(apiUrl, {
        method: "POST",
        headers: {
            "Content-Type": "application/json"
        },
        body: JSON.stringify({
            slug: slug
        }),
    })
    .then(res => {
        return res.json();
    })
    .then(data => {
        if(data[RES_CODE] == CODE_API_YES && data[RES_COUNT] <= 0) {
            submitForm('comic');
        }
    })
    .catch(response => {
        const erorrs = Object.values(response.responseJSON.errors);
        showError($('#errors-category'), [erorrs]);
    });
}

const genarateSlug = (name, alias) => {
    if(name || alias) {
        $('#slug').val(slugify(name + " " + alias));
    }
}

const doObjFormatedBeforeSend = (obj) => {
    //Categories
    obj["categories"] = obj["categories[]"];
    delete obj["categories[]"];

    //Delete avatar
    delete obj["avatar"];

    //Delete token
    delete obj["_token"];
}

const submitForm = (name) => {
    const form      = $(`#form-create-${name}`);
    const formData  = new FormData(form[0]);
    const objData   = reqObjectFromFormData(formData);
    doObjFormatedBeforeSend(objData);

    const apiUrl = PATH_API_PRIV + reqPathApi(name) + PATH_API_STORE;

    fetch(apiUrl, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(objData),
        })
        .then(res => {
            return res.json();
        })
        .then(data => {
            $('#errors-category').empty();
            notifySuccess(response.message);

            form.trigger("reset");

            if (name === 'comic') {
                $('#select-category').empty();
                $('#select-translator-create').empty();
                $('#pic').attr('src', '');
            }
        })
        .catch(response => {
            const erorrs = Object.values(response.responseJSON.errors);
            showError($('#errors-category'), [erorrs]);
        });

    // $.ajax({
    //     url: form.attr('action'),
    //     type: form.attr('method'),
    //     dataType: 'json',
    //     data: formData,
    //     processData: false,
    //     contentType: false,
    //     encytype: 'multipart/form-data',
    //     success: function(response) {
    //         $('#errors-category').empty();
    //         notifySuccess(response.message);

    //         form.trigger("reset");

    //         if (name === 'comic') {
    //             $('#select-category').empty();
    //             $('#select-translator-create').empty();
    //             $('#pic').attr('src', '');
    //         }
    //     },
    //     error: function(response) {
    //         const erorrs = Object.values(response.responseJSON.errors);
    //         showError($('#errors-category'), [erorrs]);
    //     }
    // });
}

$(document).ready(function() {
    $(document).on('change', '#name, #alias', function() {
        genarateSlug($('#name').val(), $('#alias').val());
    })

    //Review Avatar
    $('#pic').on('click', function() {
        $('#overlay')
            .css({
                backgroundImage: `url(${this.src})`
            })
            .addClass('open')
            .one('click', function() {
                $(this).removeClass('open');
            });
    });

    //Show Data For Select2 Category
    const apiUrlCat = PATH_API_PRIV + PATH_API_CATEGORY + PATH_APT_VIEW;
    $("#select-category").select2({
        ajax: {
            delay: 250,
            url: apiUrlCat,
            data: function(params) {
                var queryParameters = {
                    q: params.term
                }

                return queryParameters;
            },
            processResults: function(data) {
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.name,
                            id: item.id
                        }
                    })
                };
            },
            error: function(response) {
                notifyError(response.responseJSON.message);
            }
        }
    });

    const apiUrlReqTrans = PATH_API_PRIV + PATH_API_TRANSLATOR;
    $('#select-translator-create').select2({
        ajax: {
            delay: 250,
            url: apiUrlReqTrans,
            data: function(params) {
                var queryParameters = {
                    q: params.term
                }

                return queryParameters;
            },
            processResults: function(data) {
                if (this.$element[0].id == 'select-translator') {
                    data.unshift({
                        id: -1,
                        name: "All",
                    })
                }
                return {
                    results: $.map(data, function(item) {
                        return {
                            text: item.name + (item.nickname ?
                                ' - ' + item.nickname : ''),
                            id: item.id
                        }
                    })
                };
            },

        }
    })

    $('#close-modal-category-1, #close-modal-category-2').click(() => {
        $('#modal-category').modal('hide')
    })
});

const do_binding_event = () => {
    $("#btn_submit").off("click").on("click", () => {
        checkSlug($('#slug').val());
    })
}

const main = () => {
    do_binding_event();
}

main();