$(document).ready(function () {
    $("form").submit(function (e) {
        e.preventDefault();
        const statusText = $(".formStatus");

        statusText.css("color", "#2D90FF").show().text("Sending Data...");

        $.ajax({
            type: "POST",
            url: "contact.php",
            data: $(this).serialize(),
            success: function (response) {
                if (response.indexOf("Thank you!") !== -1) {
                    statusText.css("color", "green");
                    $("form")[0].reset();
                } else {
                    statusText.css("color", "red");
                }
                statusText.text(response);
                setTimeout(function () {
                    statusText.hide();
                }, 3000);
            },
            error: function () {
                statusText.css("color", "#2D90FF").text("Thank you sent your message!.");
            }
        });
    });
});
