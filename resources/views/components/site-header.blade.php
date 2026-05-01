<header class="site-header" aria-label="Cabecalho principal">
    <div class="site-header__background">
        <img src="https://www.figma.com/api/mcp/asset/0e610f44-8a60-4398-b944-07cf7d8c3a64" alt="" />
    </div>

    <div class="site-header__inner">
        <!-- Logo -->
        <div class="site-header__logo">
            <img src="https://www.figma.com/api/mcp/asset/bfd4c9bd-bba4-4688-b03e-c58c000b6ff2" alt="Imobiliaria Hahn" />
        </div>

        <!-- Right container: Navigation + Socials -->
        <div class="site-header__actions">
            <!-- Hamburger Menu Button (Mobile only) -->
            <button class="site-header__menu-toggle" id="menuToggle" aria-label="Abrir menu" aria-expanded="false">
                <span class="site-header__menu-icon"></span>
                <span class="site-header__menu-icon"></span>
                <span class="site-header__menu-icon"></span>
            </button>

            <div class="site-header__actions-group">
                <!-- Navigation -->
                <nav class="site-header__nav" id="mobileMenu" aria-label="Navegacao principal">
                    <a class="site-header__link" href="#">ALUGUEL</a>
                    <a class="site-header__link" href="#">VENDA</a>
                    <a class="site-header__link" href="#">ANUNCIE</a>
                    <a class="site-header__link" href="#">CONTATO</a>
                    <a class="site-header__link" href="#">AREA DO CLIENTE</a>
                </nav>

                <!-- Social buttons -->
                <div class="site-header__socials" aria-label="Redes sociais">
                    <a class="site-header__social-button site-header__social-button--facebook" href="#" aria-label="Facebook">
                        <img src="https://www.figma.com/api/mcp/asset/9c4a72f2-c309-4414-b4d2-ddf95ec6c5ca" alt="" />
                    </a>
                    <a class="site-header__social-button site-header__social-button--instagram" href="#" aria-label="Instagram">
                        <img src="https://www.figma.com/api/mcp/asset/388c169f-bb51-4edd-914f-3dba725f0126" alt="" />
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const menuToggle = document.getElementById('menuToggle');
        const mobileMenu = document.getElementById('mobileMenu');
        const siteHeader = document.querySelector('.site-header');

        if (!menuToggle || !mobileMenu || !siteHeader) {
            return;
        }

        const openMenu = () => {
            siteHeader.classList.add('site-header--menu-open');
            menuToggle.setAttribute('aria-expanded', 'true');
        };

        const closeMenu = () => {
            siteHeader.classList.remove('site-header--menu-open');
            menuToggle.setAttribute('aria-expanded', 'false');
        };

        const toggleMenu = () => {
            if (window.innerWidth > 768) {
                return;
            }

            if (siteHeader.classList.contains('site-header--menu-open')) {
                closeMenu();
            } else {
                openMenu();
            }
        };

        menuToggle.addEventListener('click', function(event) {
            event.stopPropagation();
            toggleMenu();
        });

        // Close menu when a link is clicked
        mobileMenu.querySelectorAll('.site-header__link').forEach(link => {
            link.addEventListener('click', function() {
                closeMenu();
            });
        });

        // Close menu when clicking outside the header
        document.addEventListener('click', function(event) {
            if (!siteHeader.contains(event.target)) {
                closeMenu();
            }
        });

        // Close when resizing to desktop or hitting Escape
        window.addEventListener('resize', function() {
            if (window.innerWidth > 768) {
                closeMenu();
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeMenu();
            }
        });
    });
</script>