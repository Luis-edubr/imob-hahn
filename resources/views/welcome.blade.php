<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'Imobiliária Hahn') }}</title>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">

        @vite(['resources/css/app.scss', 'resources/js/app.js'])
    </head>
    <body class="home-page">
        <!-- HEADER -->
        <x-site-header />

        <!-- HERO & SEARCH -->
        <section class="hero">
            <div class="hero__bg">
                <img src="https://www.figma.com/api/mcp/asset/eff0a503-16be-4bc1-8a97-677668fce1fc" alt="Hero background" class="hero__img">
                <div class="hero__veil"></div>
            </div>

            <!-- Hero headline (positioned per Figma node 27:1092) -->
            <p class="hero__headline">O LAR DOS SEUS SONHOS está a um passo de se tornar realidade. Descubra as melhores opções com a nossa imobiliária e transforme sua vida hoje mesmo!</p>

            <div class="hero__inner">
                <div class="hero__text">
                    <p class="hero__subtitle">&nbsp;</p>
                </div>
            </div>

            <!-- Filter wrapper centered below the headline (Figma 27:345) -->
            <div class="hero__filter-wrapper" aria-hidden="false">
                <div class="hero__filter-actions">
                    <button class="btn--green">COMPRAR</button>
                    <button class="btn--green btn--ghost">ALUGAR</button>
                </div>

                <div class="hero__filter">
                    <div class="hero__filter-row">
                        <button class="filter-pill">TIPO <img src="https://www.figma.com/api/mcp/asset/db18014a-e75c-438f-95c6-ab660e95370e" alt="arrow"></button>
                        <button class="filter-pill">BAIRRO <img src="https://www.figma.com/api/mcp/asset/0a9f56e6-89ae-4347-9ecb-3b8ddcbc4172" alt="arrow"></button>
                        <button class="filter-pill">DORMITÓRIOS <img src="https://www.figma.com/api/mcp/asset/0a9f56e6-89ae-4347-9ecb-3b8ddcbc4172" alt="arrow"></button>
                        <button class="filter-pill">CIDADE <img src="https://www.figma.com/api/mcp/asset/0a9f56e6-89ae-4347-9ecb-3b8ddcbc4172" alt="arrow"></button>
                        <div class="filter-pill filter-pill--code">CÓDIGO</div>
                    </div>
                </div>

                <div class="hero__search-center">
                    <button class="btn--search">BUSCAR <img src="https://www.figma.com/api/mcp/asset/f141d3fb-811d-470e-9b00-fc0bd73c23a2" alt="lupa"></button>
                </div>
            </div>
        </section>

        <!-- DESTAQUES DE VENDA -->
        <section class="listings-section">
            <h2 class="section-title">DESTAQUES DE VENDA</h2>
            <div class="listings-grid">
                <x-listing-card 
                    image="https://www.figma.com/api/mcp/asset/9cc55c21-2025-4882-b3c4-9658da4fe4c0"
                    title="INDUSTRIAL I - BAGÉ"
                    location="Rua Doutor Pena"
                    beds="2"
                    cars="1"
                    baths="1"
                    code="2842"
                    price="R$ 500.000,00"
                />
                <x-listing-card 
                    image="https://www.figma.com/api/mcp/asset/9cc55c21-2025-4882-b3c4-9658da4fe4c0"
                    title="INDUSTRIAL I - BAGÉ"
                    location="Rua Doutor Pena"
                    beds="2"
                    cars="1"
                    baths="1"
                    code="2842"
                    price="R$ 500.000,00"
                />
                <x-listing-card 
                    image="https://www.figma.com/api/mcp/asset/9cc55c21-2025-4882-b3c4-9658da4fe4c0"
                    title="INDUSTRIAL I - BAGÉ"
                    location="Rua Doutor Pena"
                    beds="2"
                    cars="1"
                    baths="1"
                    code="2842"
                    price="R$ 500.000,00"
                />
                <x-listing-card 
                    image="https://www.figma.com/api/mcp/asset/9cc55c21-2025-4882-b3c4-9658da4fe4c0"
                    title="INDUSTRIAL I - BAGÉ"
                    location="Rua Doutor Pena"
                    beds="2"
                    cars="1"
                    baths="1"
                    code="2842"
                    price="R$ 500.000,00"
                />
            </div>
        </section>

        <!-- BARBADA DA SEMANA -->
        <section class="featured-deal">
            <div class="featured-deal__content">
                <h2 class="featured-deal__title">BARBADA DA SEMANA</h2>
                <div class="featured-deal__description">
                    <p><strong>VENDA</strong></p>
                    <p><strong>CASA NO CAMPO</strong></p>
                </div>
                <ul class="featured-deal__features">
                    <li>2 Banheiros</li>
                    <li>3 Dormitórios</li>
                    <li>1 Suíte</li>
                    <li>1 Sala com lareira</li>
                    <li>1 Sala de estar</li>
                    <li>1 Sala de janta</li>
                    <li>Garagem ampla</li>
                    <li>Pátio com piscina</li>
                </ul>
            </div>
            <div class="featured-deal__image">
                <img src="https://www.figma.com/api/mcp/asset/eda60452-83d4-492c-913c-c2a2a1f83782" alt="Casa no Campo">
            </div>
        </section>

        <!-- DESTAQUES DE ALUGUÉIS -->
        <section class="listings-section">
            <h2 class="section-title">DESTAQUES DE ALUGUÉIS</h2>
            <div class="listings-grid">
                <x-listing-card 
                    image="https://www.figma.com/api/mcp/asset/c63b5e62-92e2-42ef-8c7d-3ae51ce60fa7"
                    title="INDUSTRIAL I - BAGÉ"
                    location="Rua Doutor Pena"
                    beds="2"
                    cars="1"
                    baths="1"
                    code="2842"
                    price="R$ 800,00"
                />
                <x-listing-card 
                    image="https://www.figma.com/api/mcp/asset/c63b5e62-92e2-42ef-8c7d-3ae51ce60fa7"
                    title="INDUSTRIAL I - BAGÉ"
                    location="Rua Doutor Pena"
                    beds="2"
                    cars="1"
                    baths="1"
                    code="2842"
                    price="R$ 800,00"
                />
                <x-listing-card 
                    image="https://www.figma.com/api/mcp/asset/c63b5e62-92e2-42ef-8c7d-3ae51ce60fa7"
                    title="INDUSTRIAL I - BAGÉ"
                    location="Rua Doutor Pena"
                    beds="2"
                    cars="1"
                    baths="1"
                    code="2842"
                    price="R$ 800,00"
                />
                <x-listing-card 
                    image="https://www.figma.com/api/mcp/asset/c63b5e62-92e2-42ef-8c7d-3ae51ce60fa7"
                    title="INDUSTRIAL I - BAGÉ"
                    location="Rua Doutor Pena"
                    beds="2"
                    cars="1"
                    baths="1"
                    code="2842"
                    price="R$ 800,00"
                />
            </div>
        </section>

        <!-- FOOTER -->
        <!-- FOOTER COMPONENT -->
        <x-site-footer />
    </body>
</html>