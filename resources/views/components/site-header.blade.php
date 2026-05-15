<header class="site-header" aria-label="Cabecalho principal">

    <div class="site-header__inner">
        <!-- Logo -->
        <div class="site-header__logo">
            <img src="{{ asset('logo.png') }}" alt="Imobiliaria Hahn" />
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
                        <img src="{{ asset('icons/facebook.svg') }}" alt="" />
                    </a>
                    <a class="site-header__social-button site-header__social-button--instagram" href="#" aria-label="Instagram">
                        <img src="{{ asset('icons/instagram.svg') }}" alt="" />
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