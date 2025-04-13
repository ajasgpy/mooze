define(['jquery'], function ($) {
  // Função para aplicar o estado inicial
  (function() {
    var sidebarCollapsed = localStorage.getItem('sidebarCollapsed') === 'true';
    if (sidebarCollapsed) {
      var sidebar = document.querySelector('#moozeSidebar');
      if (sidebar) {
        sidebar.classList.add('no-transition');
        sidebar.classList.add('collapsed');
        document.documentElement.classList.add('sidebar-collapsed');
        
        // Force reflow
        sidebar.offsetHeight;
        
        // Remove a classe no-transition após o reflow
        requestAnimationFrame(function() {
          sidebar.classList.remove('no-transition');
        });
      }
    }
  })();

  return {
    init: function init() {
      var sidebar = $('#moozeSidebar');
      var toggle = $('#sidebarToggle');
      var mainContent = $('.main-content');

      // Toggle do sidebar
      toggle.on('click', function () {
        sidebar.toggleClass('collapsed');
        mainContent.toggleClass('expanded');
        var isCollapsed = sidebar.hasClass('collapsed');

        // Salva o estado no localStorage
        localStorage.setItem('sidebarCollapsed', isCollapsed);
        // Atualiza a classe no HTML
        document.documentElement.classList.toggle('sidebar-collapsed', isCollapsed);
      });

      // Responsividade automática
      function checkWidth() {
        if (window.innerWidth < 768) {
          sidebar.addClass('mobile');
        } else {
          sidebar.removeClass('mobile');
        }
      }

      // Verifica no carregamento e no redimensionamento
      checkWidth();
      $(window).resize(checkWidth);
    }
  };
});
//# sourceMappingURL=sidebar.js.map
