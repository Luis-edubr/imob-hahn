@extends('layouts.home')

@section('content')
<div class="search-page">
    <!-- Top info bar with count and CTA -->
    <div class="search-page__header">
        <div class="search-page__info-section">
            <div class="search-page__count">
                <span class="search-page__count-text">{{ $properties->total() }} imóveis encontrados - {{ $properties->currentPage() }} de {{ $properties->lastPage() }} páginas</span>
            </div>

            <div class="search-page__cta-button">
                <div class="search-page__cta-content">
                    <span class="search-page__cta-text">Alguma dúvida? Fale Conosco!</span>
                    <a href="{{ route('contact.show') }}" class="search-page__cta-link">ENTRE EM CONTATO</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main content container: filters + grid -->
    <div class="search-page__container">
        <!-- Sidebar: Filter -->
        <aside class="search-page__sidebar">
            <div class="search-filter">
                <!-- Search Advanced Title -->
                <div class="search-filter__header">
                    <h3 class="search-filter__title">BUSCA AVANÇADA</h3>
                </div>

                <!-- Type & Sale filter -->
                <div class="search-filter__group">
                    <div class="search-filter__row">
                        <div class="search-filter__field">
                            <select class="search-filter__select">
                                <option>Venda</option>
                                <option>Aluguel</option>
                            </select>
                        </div>
                        <div class="search-filter__field">
                            <select class="search-filter__select">
                                <option>Tipo</option>
                                <option>Casa</option>
                                <option>Apartamento</option>
                                <option>Terreno</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- City -->
                <div class="search-filter__group">
                    <select class="search-filter__select">
                        <option>Cidade</option>
                        <option>Bagé</option>
                        <option>Pelotas</option>
                    </select>
                </div>

                <!-- Neighborhood -->
                <div class="search-filter__group">
                    <select class="search-filter__select">
                        <option>Bairro</option>
                        <option>Centro</option>
                        <option>Vera Cruz</option>
                    </select>
                </div>

                <!-- Price Range -->
                <div class="search-filter__section">
                    <h4 class="search-filter__section-title">VALOR</h4>
                    <div class="search-filter__price-range">
                        <input type="text" class="search-filter__input-price" placeholder="MÍNIMO">
                        <input type="text" class="search-filter__input-price" placeholder="MÁXIMO">
                    </div>
                </div>

                <!-- Bedrooms, Bathrooms, Garages -->
                <div class="search-filter__section">
                    <h4 class="search-filter__section-title">DORMITÓRIOS</h4>
                    <div class="search-filter__chips">
                        <button class="search-filter__chip">1</button>
                        <button class="search-filter__chip">2</button>
                        <button class="search-filter__chip">3</button>
                        <button class="search-filter__chip">4+</button>
                    </div>

                    <h4 class="search-filter__section-title">BANHEIROS</h4>
                    <div class="search-filter__chips">
                        <button class="search-filter__chip">1</button>
                        <button class="search-filter__chip">2</button>
                        <button class="search-filter__chip">3</button>
                        <button class="search-filter__chip">4+</button>
                    </div>

                    <h4 class="search-filter__section-title">VAGAS</h4>
                    <div class="search-filter__chips">
                        <button class="search-filter__chip">1</button>
                        <button class="search-filter__chip">2</button>
                        <button class="search-filter__chip">3</button>
                        <button class="search-filter__chip">4+</button>
                    </div>
                </div>

                <!-- Code Field -->
                <div class="search-filter__group">
                    <input type="text" class="search-filter__input" placeholder="Código">
                </div>

                <!-- Search Button -->
                <button class="search-filter__button-search">PESQUISAR</button>
            </div>
        </aside>

        <!-- Main content: Top bar + Grid -->
        <main class="search-page__main">
            <!-- Top sorting bar -->
            <div class="search-page__topbar">
                <div class="search-page__sort-container">
                    <label class="search-page__sort-label">Ordenar por</label>
                    <select class="search-page__sort-select">
                        <option>Maior preço</option>
                        <option>Menor preço</option>
                        <option>Mais recente</option>
                    </select>
                </div>

                <div class="search-page__view-toggle">
                    <button class="search-page__view-btn search-page__view-btn--list" title="List view">
                        <svg width="30" height="18" viewBox="0 0 30 18" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <line x1="0" y1="2" x2="30" y2="2" stroke="#333" stroke-width="2"/>
                            <line x1="0" y1="9" x2="30" y2="9" stroke="#333" stroke-width="2"/>
                            <line x1="0" y1="16" x2="30" y2="16" stroke="#333" stroke-width="2"/>
                        </svg>
                    </button>
                    <button class="search-page__view-btn search-page__view-btn--grid" title="Grid view">
                        <svg width="30" height="25" viewBox="0 0 30 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect x="1" y="1" width="8" height="8" stroke="#333" stroke-width="2" fill="none"/>
                            <rect x="11" y="1" width="8" height="8" stroke="#333" stroke-width="2" fill="none"/>
                            <rect x="21" y="1" width="8" height="8" stroke="#333" stroke-width="2" fill="none"/>
                            <rect x="1" y="11" width="8" height="8" stroke="#333" stroke-width="2" fill="none"/>
                            <rect x="11" y="11" width="8" height="8" stroke="#333" stroke-width="2" fill="none"/>
                            <rect x="21" y="11" width="8" height="8" stroke="#333" stroke-width="2" fill="none"/>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Properties Grid -->
            <div class="search-page__grid">
                @foreach ($properties as $property)
                    <x-listing-card
                        :image="$property->main_image?->url ?? 'https://placehold.co/600x400?text=Im%C3%B3vel'"
                        :title="$property->title"
                        :location="$property->display_location"
                        :beds="$property->bedrooms ?? 0"
                        :cars="$property->garages ?? ($property->parking_spaces ?? 0)"
                        :baths="$property->bathrooms ?? 0"
                        :code="$property->code"
                        :price="$property->formatted_price"
                    />
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="search-page__pagination">
                @if ($properties->currentPage() > 1)
                    <a href="{{ $properties->previousPageUrl() }}" class="search-page__pagination-arrow">
                        <svg width="10" height="8" viewBox="0 -5 10 30" fill="none">
                            <path d="M9 1L1 9L9 17" stroke="#333" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </a>
                @endif

                @for ($i = 1; $i <= $properties->lastPage(); $i++)
                    @if ($i === 1 || $i === $properties->lastPage() || abs($i - $properties->currentPage()) <= 2)
                        <a href="{{ $properties->url($i) }}"
                           class="search-page__pagination-number {{ $i === $properties->currentPage() ? 'search-page__pagination-number--active' : '' }}">
                            {{ $i }}
                        </a>
                    @elseif ($i === 2 || $i === $properties->lastPage() - 1)
                        <span class="search-page__pagination-ellipsis">...</span>
                    @endif
                @endfor

                @if ($properties->hasMorePages())
                    <a href="{{ $properties->nextPageUrl() }}" class="search-page__pagination-arrow">
                        <svg width="10" height="18" viewBox="0 0 10 18" fill="none">
                            <path d="M1 1L9 9L1 17" stroke="#333" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </a>
                @endif
            </div>
        </main>
    </div>
</div>

@vite('resources/css/search.scss')
@endsection
