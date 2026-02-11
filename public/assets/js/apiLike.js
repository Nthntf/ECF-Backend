$(document).on("click", ".like-btn", function (e) {
    e.preventDefault();

    let button = $(this);
    let bookId = button.data("id");
    let icon = button.find(".heart-icon");

    $.ajax({
        url: "/books/" + bookId + "/like",
        type: "POST",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                button.toggleClass("liked", response.liked);

                icon.addClass("scale-125");
                setTimeout(() => {
                    icon.removeClass("scale-125");
                }, 150);
            }
        },
        error: function () {
            alert("Erreur lors de la mise à jour");
        },
    });
});
