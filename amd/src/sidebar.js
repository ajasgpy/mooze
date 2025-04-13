define(['jquery'], function ($) {
  // Função para aplicar o estado inicial imediatamente
  (function() {
    // Adiciona script ao head para garantir execução o mais cedo possível
    var style = document.createElement('style');
    style.textContent = 'html.no-transition * { transition: none !important; }';
    document.head.appendChild(style);
    
    // Aplica estado inicial
    document.documentElement.classList.add('no-transition');
    if (localStorage.getItem('sidebarCollapsed') === 'true') {
      document.documentElement.classList.add('sidebar-collapsed');
    }

    // Remove a classe no-transition após o primeiro paint
    requestAnimationFrame(function() {
      requestAnimationFrame(function() {
        document.documentElement.classList.remove('no-transition');
      });
    });
  })();

  return {
    init: function init() {
      var toggle = $('#sidebarToggle');
      var toggleIcon = $('.toggle-icon');
      var sidebar = $('.mooze-sidebar');

      // Adiciona classes para animação
      sidebar.addClass('animate-sidebar');
      
      // Toggle do sidebar com animação suave
      toggle.on('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        toggleSidebar();
      });

      function toggleSidebar() {
        var isCollapsed = !document.documentElement.classList.contains('sidebar-collapsed');
        
        // Adiciona classe de animação
        sidebar.addClass('is-transitioning');
        
        requestAnimationFrame(function() {
          // Toggle das classes
          document.documentElement.classList.toggle('sidebar-collapsed', isCollapsed);
          
          // Anima o ícone com transform
          toggleIcon.css({
            transform: isCollapsed ? 'rotate(180deg)' : 'rotate(0deg)',
            transition: 'transform 0.5s cubic-bezier(0.4, 0, 0.2, 1)'
          });
          
          // Salva o estado
          localStorage.setItem('sidebarCollapsed', isCollapsed);
          
          // Remove a classe de animação após a transição
          setTimeout(function() {
            sidebar.removeClass('is-transitioning');
          }, 500); // Tempo igual à duração da transição CSS
        });
      }

      // Responsividade automática com animação suave
      function checkWidth() {
        if (window.innerWidth < 768 && !document.documentElement.classList.contains('sidebar-collapsed')) {
          toggleSidebar();
        }
      }

      // Verifica no carregamento e no redimensionamento com debounce
      checkWidth();
      var resizeTimer;
      $(window).on('resize', function() {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(checkWidth, 250);
      });
    }
  };
});
//# sourceMappingURL=sidebar.js.map
