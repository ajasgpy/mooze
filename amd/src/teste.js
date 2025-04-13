define("theme_mooze/teste", ["jquery"], function($) {
    "use strict";

    function init() {
        console.log("Texto da função 1!");
    }

    function toggle() {
        console.log("Texto da função 2!");
    }

    return {
        init,
        toggle
    };
});
