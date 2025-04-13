define("theme_mooze/dropdown", ["jquery"], function($) {
    "use strict";

    function init() {
        const userMenuButton = $("#userMenuButton");
        const dropdownMenu = $("#userDropdown");

        // Toggle dropdown ao clicar no botão
        userMenuButton.on("click", function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const isExpanded = $(this).attr("aria-expanded") === "true";
            
            // Toggle classes e aria-expanded
            $(this).toggleClass("active").attr("aria-expanded", !isExpanded);
            dropdownMenu.toggleClass("show");
        });

        // Fechar dropdown ao clicar fora
        $(document).on("click", function(e) {
            if (!$(e.target).closest(".user-menu").length) {
                userMenuButton.removeClass("active").attr("aria-expanded", "false");
                dropdownMenu.removeClass("show");
            }
        });

        // Fechar dropdown ao pressionar ESC
        $(document).on("keyup", function(e) {
            if (e.key === "Escape") {
                userMenuButton.removeClass("active").attr("aria-expanded", "false");
                dropdownMenu.removeClass("show");
            }
        });
    }

    return {
        init: init
    };
});
