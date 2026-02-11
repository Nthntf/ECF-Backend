$(document).on("click", ".like-btn", function (e) {
    e.preventDefault();

    let button = $(this);
    let bookId = button.data("id");
    let icon = button.find(".heart-icon");

    // Requête AJAX pour toggle le like du livre
    $.ajax({
        url: "/books/" + bookId + "/like",
        type: "POST",
        dataType: "json",
        success: function (response) {
            if (response.success) {
                // Met à jour l'état du bouton
                button.toggleClass("liked", response.liked);

                // Animation rapide du coeur
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
