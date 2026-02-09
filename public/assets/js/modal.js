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

        if (modalType === "add") {
            $("#addForm").attr("action", "/" + resource + "/create");
            openModal($("#modal-add"));
        }

        if (modalType === "edit") {
            const nom = $btn.data("nom");

            $("#editForm").attr("action", "/" + resource + "/" + id + "/edit");

            if ($("#editNom").length) {
                $("#editNom").val(nom);
            }

            openModal($("#modal-edit"));
        }

        if (modalType === "delete") {
            const nom = $btn.data("nom");

            $(".delete-msg").html(`Voulez-vous vraiment supprimer la catégorie "${nom}" ?`);

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
