</main><!-- end .main-content -->

<script>
    // SIDEBAR TOGGLE FUNCTION
    function toggleSidebar() {
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebar-overlay');

        if (!sidebar || !overlay) return;

        sidebar.classList.toggle('mobile-open');
        overlay.classList.toggle('show');
    }

    // RESPONSIVE GRID HANDLER
    function handleResponsiveGrids() {
        const isMobile = window.innerWidth <= 768;
        const isSmall = window.innerWidth <= 640;
        const isTiny = window.innerWidth <= 480;

        // KPI Grid (4 columns -> 2 -> 1)
        const kpiGrids = document.querySelectorAll('[class*="kpi-grid"]');
        kpiGrids.forEach(grid => {
            if (isTiny) {
                grid.style.gridTemplateColumns = '1fr !important';
            } else if (isSmall || isMobile) {
                grid.style.gridTemplateColumns = 'repeat(2, 1fr) !important';
            }
        });

        // Recent Grid (2 columns -> 1)
        const recentGrids = document.querySelectorAll('[class*="recent-grid"]');
        recentGrids.forEach(grid => {
            if (isMobile) {
                grid.style.gridTemplateColumns = '1fr !important';
            }
        });

        // Blog Editor Grid
        const blogGrids = document.querySelectorAll('[class*="blog-editor-grid"]');
        blogGrids.forEach(grid => {
            if (isMobile) {
                grid.style.gridTemplateColumns = '1fr !important';
            }
        });

        // All grid elements with specific patterns
        const allGrids = document.querySelectorAll('[style*="grid-template-columns"]');
        allGrids.forEach(grid => {
            const style = grid.getAttribute('style');
            if (isTiny && style.includes('repeat(4')) {
                grid.style.gridTemplateColumns = '1fr !important';
            } else if (isSmall && style.includes('repeat(4')) {
                grid.style.gridTemplateColumns = 'repeat(2, 1fr) !important';
            } else if (isMobile && style.includes('repeat(')) {
                grid.style.gridTemplateColumns = '1fr !important';
            }
        });
    }

    // CLOSE SIDEBAR ON NAVIGATION
    document.addEventListener('DOMContentLoaded', function() {
        // Handle responsive grids
        handleResponsiveGrids();
        window.addEventListener('resize', handleResponsiveGrids);

        // Close sidebar when clicking a nav link on mobile
        document.querySelectorAll('.nav-item').forEach(function(item) {
            item.addEventListener('click', function() {
                if (window.innerWidth <= 768) {
                    const sidebar = document.getElementById('sidebar');
                    const overlay = document.getElementById('sidebar-overlay');
                    if (sidebar && overlay) {
                        sidebar.classList.remove('mobile-open');
                        overlay.classList.remove('show');
                    }
                }
            });
        });

        // Close sidebar when clicking overlay
        const overlay = document.getElementById('sidebar-overlay');
        if (overlay) {
            overlay.addEventListener('click', toggleSidebar);
        }

        // Handle window resize
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                const sidebar = document.getElementById('sidebar');
                const overlay = document.getElementById('sidebar-overlay');
                if (sidebar && overlay) {
                    sidebar.classList.remove('mobile-open');
                    overlay.classList.remove('show');
                }
            }
        });
    });

    // SMOOTH SCROLL TO TOP ON PAGE LOAD
    window.scrollTo(0, 0);

    // ADD ANIMATION TO ALERTS
    document.querySelectorAll('.alert').forEach(function(alert) {
        alert.style.animation = 'slideDown 0.3s ease-out';
    });

    // CSS ANIMATION
    const style = document.createElement('style');
    style.textContent = `
        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    `;
    document.head.appendChild(style);
</script>

</body>

</html>