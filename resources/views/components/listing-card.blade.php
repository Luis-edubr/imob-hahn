@props([
    'image' => '#',
    'title' => 'TÍTULO DO IMÓVEL',
    'location' => 'Localização',
    'beds' => 2,
    'cars' => 1,
    'baths' => 1,
    'code' => '0000',
    'price' => 'R$ 0,00',
])

<div class="listing-card">
    <div class="listing-card__image">
        <img src="{{ $image }}" alt="{{ $title }}" class="listing-card__img">
    </div>
    
    <div class="listing-card__info-box">
        <div class="listing-card__title">
            {{ $title }}
        </div>
        
        <div class="listing-card__location">
            <svg class="listing-card__location-icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M12 2C6.48 2 2 6.48 2 12c0 4.08 2.76 7.56 6.48 8.76C8.92 20.64 10.4 19.32 10.4 17.6v-2.4h1.2v2.4c0 1.72 1.48 3.04 2.92 3.76 3.72-1.2 6.48-4.68 6.48-8.76 0-5.52-4.48-10-10-10zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z" fill="currentColor"/>
            </svg>
            <span class="listing-card__location-text">{{ $location }}</span>
        </div>
        
        <div class="listing-card__divider"></div>
        
        <div class="listing-card__features">
            <div class="listing-card__feature">
                <svg class="listing-card__feature-icon" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M10 10.5h4v3h-4z" fill="currentColor"/>
                    <path d="M16 2H8c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm-4 18c-.55 0-1-.45-1-1s.45-1 1-1 1 .45 1 1-.45 1-1 1zm4-3H8V4h8v13z" fill="currentColor"/>
                </svg>
                <span class="listing-card__feature-value">{{ $beds }}</span>
            </div>
            
            <div class="listing-card__feature">
                <svg class="listing-card__feature-icon" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM7 9h10v2H7z" fill="currentColor"/>
                </svg>
                <span class="listing-card__feature-value">{{ $cars }}</span>
            </div>
            
            <div class="listing-card__feature">
                <svg class="listing-card__feature-icon" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7 8c0 2.21 1.79 4 4 4s4-1.79 4-4-1.79-4-4-4-4 1.79-4 4zm6 0c0 1.1-.9 2-2 2s-2-.9-2-2 .9-2 2-2 2 .9 2 2zm3 7c-.29 0-.77.18-1.63.74-.9.59-2.64 1.52-4.37 1.52s-3.47-.93-4.37-1.52c-.86-.56-1.34-.74-1.63-.74-.39 0-.67.27-.67.67 0 .38.29.72.75 1.01.96.62 2.73 1.57 4.63 1.92V20h2v-1.47c1.9-.35 3.67-1.3 4.63-1.92.46-.29.75-.63.75-1.01 0-.4-.28-.67-.67-.67z" fill="currentColor"/>
                </svg>
                <span class="listing-card__feature-value">{{ $baths }}</span>
            </div>
        </div>
        
        <div class="listing-card__footer">
            <span class="listing-card__code">Cód: {{ $code }}</span>
            <span class="listing-card__price">{{ $price }}</span>
        </div>
    </div>
</div>
