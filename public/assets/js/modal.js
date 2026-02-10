$(function () {
    function openModal($modal) {
        $(".modal").removeClass("flex").addClass("hidden");
        $modal.removeClass("hidden").addClass("flex");
    }

    function closeModal($modal) {
        $modal.removeClass("flex").addClass("hidden");
    }

    function getResource($input) {
        return $input.data("resource");
    }

    function getId($input) {
        return $input.data("id");
    }

    $(".open-modal").on("click", function () {
        const $btn = $(this);
        const modalType = $btn.data("modal");
        const resource = getResource($btn);
        const id = getId($btn);

        // ===== ADD =====
        if (modalType === "add") {
            $("#addForm").attr("action", "/" + resource + "/add");
            openModal($("#modal-add"));
        }

        // ===== UPDATE =====
        if (modalType === "update") {
            $("#updateForm").attr("action", "/" + resource + "/" + id + "/update");

            // ===== CATEGORIES =====
            if (resource === "categories") {
                $("#updateNom").val($btn.data("nom"));
            }

            // ===== AUTHORS =====
            if (resource === "authors") {
                $("#updatePrenom").val($btn.data("prenom"));
                $("#updateNom").val($btn.data("nom"));
                $("#updateBiographie").val($btn.data("biographie"));
            }

            // ===== BOOKS =====
            if (resource === "books") {
                $("#updateTitre").val($btn.data("titre"));
                $("#updateAuteurId").val($btn.data("auteur_id"));
                $("#updateCategorieId").val($btn.data("categorie_id"));
                $("#updateAnnee").val($btn.data("annee_publication"));
                $("#updateIsbn").val($btn.data("isbn"));
                $("#updateDisponible").val($btn.data("disponible"));
                $("#updateLike").val($btn.data("like"));
                $("#updateSynopsis").val($btn.data("synopsis"));
            }

            openModal($("#modal-update"));
        }

        // ===== DELETE =====
        if (modalType === "delete") {
            let message = "";

            if (resource === "categories") {
                message = `Voulez-vous vraiment supprimer la catégorie "<strong>${$btn.data("nom")}</strong>" ?`;
            }

            if (resource === "authors") {
                message = `Voulez-vous vraiment supprimer l'auteur "<strong>${$btn.data("fullname")}</strong>" ?`;
            }

            if (resource === "books") {
                message = `Voulez-vous vraiment supprimer le livre "<strong>${$btn.data("titre")}</strong>" ?`;
            }

            $(".delete-msg").html(message);
            $("#deleteForm").attr("action", "/" + resource + "/" + id + "/delete");

            openModal($("#modal-delete"));
        }
    });

    $(".close-modal").on("click", function () {
        closeModal($(this).closest(".modal"));
    });

    $(".modal").on("click", function (e) {
        if (e.target === this) {
            closeModal($(this));
        }
    });
});
