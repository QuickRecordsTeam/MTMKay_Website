$(document).ready(function () {
    $("#enrollmentBtn").on("click", function () {
        $("#success").fadeIn();
        $(".modal").modal("hide");
        $("#success").modal("show");
    });

    $("#closeModal").on("click", function (e) {
        $("#enrollmentForm").get(0).reset();
    });

    $("#enrollmentForm").submit(function (e) {
        e.preventDefault();
        var $form = $(this);
        var action = $("#enrollmentForm").attr("action");
        var method = $("#enrollmentForm").attr("method");

        $(".submit_enroll_button").css("display", "none");
        $(".loader").css("display", "block");

        $.ajax({
            url: action,
            type: method,
            data: $form.serialize(),
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                if (response.code === "NEW_ACCOUNT_CREATION") {
                    $("#success_new_account").fadeIn();
                    $(".modal").modal("hide");
                    $("#success_new_account").modal("show");
                } else if (response.code === "ENROLLED") {
                    $("#success_enrolled").fadeIn();
                    $(".modal").modal("hide");
                    $("#success_enrolled").modal("show");
                } else if (response.code === "MAXIMUM_ENROLLMENT_REACHED") {
                    $("#maximum-slot").fadeIn();
                    $(".modal").modal("hide");
                    $("#maximum-slot").modal("show");
                } else if (response.code === "PAYMENT_INITIATED") {
                    $("#payment-initiation").fadeIn();
                    $(".modal").modal("hide");
                    $("#payment-initiation").modal("show");
                } else if (response.code === "PAYMENT_FAILED") {
                    $("#payment-failed").fadeIn();
                    $(".modal").modal("hide");
                    $("#payment-failed").modal("show");
                } else {
                    $("#success_exist_acc").fadeIn();
                    $(".modal").modal("hide");
                    $("#success_exist_acc").modal("show");
                }
                $("#enrollmentForm").get(0).reset();

                $(".submit_enroll_button").css("display", "inline-block");
                $(".loader").css("display", "none");
            },
            error: function (error) {
                $(".submit_enroll_button").css("display", "inline-block");
                $(".loader").css("display", "none");

                var response = $.parseJSON(error.responseText);
                $.each(response.errors, function (key, val) {
                    $("#" + key)
                        .next()
                        .html(val[0])
                        .next()
                        .html(val[1]);
                    $("#" + key)
                        .next()
                        .removeClass("d-none");
                });
            },
        });
    });

    $("#contactForm").submit(function (e) {
        e.preventDefault();
        var $form = $(this);

        var action = $("#contactForm").attr("action");
        var method = $("#contactForm").attr("method");

        $(".btn-text").text("Sending Message...");
        $("#submit_btn").attr("disabled", true);

        $.ajax({
            url: action,
            type: method,
            data: $form.serialize(),
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            success: function (response) {
                $(".btn-text").text("Send Message");

                $("#success").fadeIn();
                $(".modal").modal("hide");
                $("#success").modal("show");

                // $form.reset();
            },
            error: function (error) {
                $("#error").fadeIn();
                $(".modal").modal("hide");
                $("#error").modal("show");
            },
        });
    });
});
