$(function () {
    // Ouvre une modal spécifique et cache les autres
    function openModal($modal) {
        $(".modal").removeClass("flex").addClass("hidden");
        $modal.removeClass("hidden").addClass("flex");
    }

    // Ferme une modal spécifique
    function closeModal($modal) {
        $modal.removeClass("flex").addClass("hidden");
    }

    // Récupère la ressource (nom de la page via data-set) associée à un bouton
    function getResource($input) {
        return $input.data("resource");
    }

    // Récupère l'ID associé à un bouton
    function getId($input) {
        return $input.data("id");
    }

    // Gestion du clic sur les boutons d'ouverture de modal
    $(".open-modal").on("click", function () {
        const $btn = $(this);
        const modalType = $btn.data("modal");
        const resource = getResource($btn);
        const id = getId($btn);

        // ===== AJOUT =====
        if (modalType === "add") {
            $("#addForm").attr("action", "/" + resource + "/add"); // Définit l'action du formulaire
            openModal($("#modal-add"));
        }

        // ===== MODIFICATION =====
        if (modalType === "update") {
            $("#updateForm").attr("action", "/" + resource + "/" + id + "/update");

            // Remplissage des champs selon la ressource
            if (resource === "categories") {
                $("#updateNom").val($btn.data("nom"));
            }

            if (resource === "authors") {
                $("#updatePrenom").val($btn.data("prenom"));
                $("#updateNom").val($btn.data("nom"));
                $("#updateBiographie").val($btn.data("biographie"));
            }

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

        // ===== SUPPRESSION =====
        if (modalType === "delete") {
            let message = "";

            // Message de confirmation selon la ressource
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

    // Fermeture de modal via le bouton "close"
    $(".close-modal").on("click", function () {
        closeModal($(this).closest(".modal"));
    });

    // Fermeture de modal en cliquant en dehors du contenu
    $(".modal").on("click", function (e) {
        if (e.target === this) {
            closeModal($(this));
        }
    });
});
