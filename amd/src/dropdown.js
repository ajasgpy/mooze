/**
 * @module     theme_mooze/dropdown
 * @copyright  2024 Your Name
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
define(['jquery'], function($) {
    'use strict';

    var init = function() {
        console.log('theme_mooze/dropdown: initialising');

        var userMenuButton = document.getElementById('userMenuButton');
        var userDropdown = document.getElementById('userDropdown');

        if (userMenuButton && userDropdown) {
            userMenuButton.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                userMenuButton.classList.toggle('active');
                userDropdown.classList.toggle('show');
                
                var isExpanded = userDropdown.classList.contains('show');
                userMenuButton.setAttribute('aria-expanded', isExpanded);
            });

            document.addEventListener('click', function(e) {
                if (!userMenuButton.contains(e.target) && !userDropdown.contains(e.target)) {
                    userMenuButton.classList.remove('active');
                    userDropdown.classList.remove('show');
                    userMenuButton.setAttribute('aria-expanded', 'false');
                }
            });
        }
    };

    return {
        init: init
    };
});