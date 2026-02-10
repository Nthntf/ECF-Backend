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
                const nom = $btn.data("nom");
                $("#updateNom").val(nom);
            }

            // ===== AUTHORS =====
            if (resource === "authors") {
                const prenom = $btn.data("prenom");
                const nom = $btn.data("nom");
                const biographie = $btn.data("biographie");

                $("#updatePrenom").val(prenom);
                $("#updateNom").val(nom);
                $("#updateBiographie").val(biographie);
            }

            openModal($("#modal-update"));
        }
        // ===== DELETE =====
        if (modalType === "delete") {
            let message = "";

            if (resource === "categories") {
                const nom = $btn.data("nom");
                message = `Voulez-vous vraiment supprimer la catégorie "<strong>${nom}</strong>" ?`;
            }

            if (resource === "authors") {
                const nom = $btn.data("nom");
                message = `Voulez-vous vraiment supprimer l'auteur "<strong>${nom}</strong>" ?`;
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
