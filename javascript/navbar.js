document.addEventListener('DOMContentLoaded', function() {
    const userMenuButton = document.getElementById('userMenuButton');
    const userDropdown = document.getElementById('userDropdown');

    if (userMenuButton && userDropdown) {
        // Toggle dropdown ao clicar no botão
        userMenuButton.addEventListener('click', function(e) {
            e.stopPropagation();
            userMenuButton.classList.toggle('active');
            userDropdown.classList.toggle('show');
        });

        // Fechar dropdown ao clicar fora
        document.addEventListener('click', function(e) {
            if (!userMenuButton.contains(e.target) && !userDropdown.contains(e.target)) {
                userMenuButton.classList.remove('active');
                userDropdown.classList.remove('show');
            }
        });
    }
}); 