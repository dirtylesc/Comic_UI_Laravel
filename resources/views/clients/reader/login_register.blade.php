<script>
    // ////Log_In And Sign_Up
    var log_in_btn = document.getElementById("ha");
    var sign_up_btn = document.getElementById("dha");
    var forget_pass_btn = document.getElementById("fa");
    var log_in_temp = document.querySelector(".log_in");

    var form_login;
    var form_register = $("#form_register").detach();
    var form_content = $("#form_content");

    if (log_in_temp)
        log_in_temp.onclick = () => {
            $('.log_function').addClass('hold_show')
        }

    sign_up_btn.onclick = () => {
        form_login = $("#form_login").detach();
        form_content.prepend(form_register);
    };

    log_in_btn.onclick = () => {
        form_register = $("#form_register").detach();
        form_content.prepend(form_login)
    };

    $(document).ready(function() {
        $('#form_login').on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            $.ajax({
                url: "{{ route('api.check_user') }}",
                type: 'POST',
                dataType: 'json',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.success) {
                        $('.login_errors').empty();

                        let string =
                            `<div class="alert alert-info" role="alert">${data.message}</div>`

                        $('.success').html(string);

                        setTimeout(function() {
                            e.currentTarget.submit();
                        }, 1000);
                    }
                },
                error: function(data) {
                    if (data.responseJSON.errors) {
                        const errors = Object.values(data.responseJSON.errors);
                        showError($('.login_errors'), errors);
                    } else if (!data.success) {
                        $('.login_errors').empty();
                        let string =
                            `<div class="alert alert-danger" role="alert">${data.responseJSON.message}</div>`

                        $('.login_errors').html(string);
                    }
                }
            });
        });

        $('#form_register').on('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(this);

            $.ajax({
                url: "{{ route('api.registering') }}",
                type: 'POST',
                dataType: 'json',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                success: function(data) {
                    if (data.success) {
                        $('#ha').click();
                        $('.register_errors').empty();

                        let string =
                            '<span class="alert alert-info" role="alert">Register Account Success..</span>'

                        $('.success').html(string);
                    }
                },
                error: function(data) {
                    if (data.responseJSON.errors) {
                        const errors = Object.values(data.responseJSON.errors);
                        showError($('.register_errors'), errors);
                    }
                }
            });
        });

        $("#nothing_").click(function() {
            $(".log_function").removeClass("hold_show");
            console.log(123);
        });
    });
</script>
