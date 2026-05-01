@extends('layouts.home')

@section('content')
<div class="contact-page">
    <!-- Cabeçalho da página CONTATO -->
    <div class="contact-page__header">
        <h1 class="contact-page__title">CONTATO</h1>
    </div>

    <!-- Seção de Informações + Mapa -->
    <div class="contact-page__container">
        <!-- Informações para contato -->
        <div class="contact-info">
            <div class="contact-info__title">
                <svg class="contact-info__icon" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm.5-13H11v6l5.25 3.15.75-1.23-4.5-2.67z" fill="#408C40"/>
                </svg>
                <h2 class="contact-info__heading">Informações para contato</h2>
            </div>

            <!-- Endereço -->
            <div class="contact-info__item">
                <div class="contact-info__icon-wrapper">
                    <svg class="contact-info__icon--small" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm0-14c-3.31 0-6 2.69-6 6s2.69 6 6 6 6-2.69 6-6-2.69-6-6-6z" fill="currentColor"/>
                    </svg>
                </div>
                <p class="contact-info__text">Rua Antenor Gonçalves Pereira, 787, sala 02, centro, Bagé/RS</p>
            </div>

            <!-- E-mail -->
            <div class="contact-info__item">
                <div class="contact-info__icon-wrapper">
                    <svg class="contact-info__icon--small" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20 4H4c-1.1 0-1.99.9-1.99 2L2 18c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 4l-8 5-8-5V6l8 5 8-5v2z"/>
                    </svg>
                </div>
                <p class="contact-info__text">imobiliariahahn@gmail.com</p>
            </div>

            <!-- Telefone -->
            <div class="contact-info__item">
                <div class="contact-info__icon-wrapper">
                    <svg class="contact-info__icon--small" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.92 7.02C15.8915026 3.18278201 11.7971543 1.03654881 7.59 2.76c-1.46.7-2.64 1.6-3.44 2.8-.8 1.2-.78 2.29 0 3.58 1.26 2.07 2.31 2.16 2.97 3.13.3.39.37.92.25 1.39-.41 1.77-3.85 5.74-5.4 7.74l-.44.62c-.14.181-.35.574-.04.87.31.295.688.101.87-.04l.62-.44c1.44-1.28 5.36-5.01 7.99-5.35.47-.124.99-.05 1.39.25.97.66 1.06 1.71 3.13 2.97 1.29 1.1 2.36 1.12 3.58 0 1.2-.8 2.1-1.98 2.8-3.44 1.31-3.99-.63-8.75-4.14-11.18zM5.5 9.5c0-.55.45-1 1-1s1 .45 1 1-.45 1-1 1-1-.45-1-1z"/>
                    </svg>
                </div>
                <p class="contact-info__text">(53) 999728251 - (53) 33121482</p>
            </div>

            <!-- WhatsApp -->
            <div class="contact-info__item">
                <div class="contact-info__icon-wrapper">
                    <svg class="contact-info__icon--small" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.67-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.076 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421-7.403h-.004c-1.052 0-2.082.356-2.901.999l-.208.16-2.155-.56.567 2.083.134.214c-.718.906-1.123 2.05-1.123 3.267 0 3.038 2.474 5.512 5.512 5.512 1.472 0 2.853-.57 3.888-1.604 1.036-1.036 1.604-2.416 1.604-3.888 0-3.038-2.474-5.512-5.512-5.512m5.846-1.466c-1.205-.49-2.501-.766-3.848-.766-5.364 0-9.754 4.39-9.754 9.754 0 1.718.425 3.413 1.234 4.924L1 23l5.239-1.374c1.45.886 3.122 1.357 4.785 1.357 5.364 0 9.754-4.39 9.754-9.754 0-2.633-1.055-5.116-2.993-6.989"/>
                    </svg>
                </div>
                <p class="contact-info__text">(53) 999728251 - (53) 999620352</p>
            </div>

            <!-- Instagram -->
            <div class="contact-info__item">
                <svg class="contact-info__insta-icon" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                    <path d="M7.8 2h8.4C19.4 2 22 4.6 22 7.8v8.4c0 3.2-2.6 5.8-5.8 5.8H7.8C4.6 22 2 19.4 2 16.2V7.8C2 4.6 4.6 2 7.8 2m-.5 2c-2.1 0-3.8 1.7-3.8 3.8v8.4c0 2.1 1.7 3.8 3.8 3.8h8.4c2.1 0 3.8-1.7 3.8-3.8V7.8c0-2.1-1.7-3.8-3.8-3.8H7.3m9.2 1.8c.4 0 .8.4.8.8s-.4.8-.8.8-.8-.4-.8-.8.4-.8.8-.8m-5.5 1.4c3.1 0 5.6 2.5 5.6 5.6s-2.5 5.6-5.6 5.6-5.6-2.5-5.6-5.6 2.5-5.6 5.6-5.6m0 2c-2 0-3.6 1.6-3.6 3.6s1.6 3.6 3.6 3.6 3.6-1.6 3.6-3.6-1.6-3.6-3.6-3.6z"/>
                </svg>
                <p class="contact-info__insta-text">@imobiliariahahn</p>
            </div>
        </div>

        <!-- Mapa -->
        <div class="contact-page__map-container">
            <iframe 
                id="contact-map" 
                class="contact-page__map"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3496.8558886577937!2d-54.00455432346876!3d-31.34268867391965!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x9509d3e8f9f9f9f9%3A0x9f9f9f9f9f9f9f!2sRua%20Antenor%20Gon%C3%A7alves%20Pereira%2C%20787%20-%20Centro%2C%20Bag%C3%A9%20-%20RS!5e0!3m2!1spt-BR!2sbr!4v1234567890"
                width="100%" 
                height="100%" 
                style="border:0;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>

    <!-- Formulário de Contato -->
    <div class="contact-form-section">
        <form class="contact-form" method="POST" action="{{ route('contact.store') }}">
            @csrf

            <!-- Linha 1: Nome e CPF -->
            <div class="contact-form__row">
                <div class="contact-form__group">
                    <label class="contact-form__label" for="name">Seu nome</label>
                    <input 
                        class="contact-form__input @error('name') is-invalid @enderror" 
                        type="text" 
                        id="name" 
                        name="name" 
                        placeholder="Insira seu nome completo"
                        value="{{ old('name') }}"
                        required
                    >
                    @error('name')
                        <span class="contact-form__error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="contact-form__group">
                    <label class="contact-form__label" for="cpf">CPF</label>
                    <input 
                        class="contact-form__input @error('cpf') is-invalid @enderror" 
                        type="text" 
                        id="cpf" 
                        name="cpf" 
                        placeholder="Ex: 123.456.789-00"
                        value="{{ old('cpf') }}"
                        required
                    >
                    @error('cpf')
                        <span class="contact-form__error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Linha 2: E-mail e Celular -->
            <div class="contact-form__row">
                <div class="contact-form__group">
                    <label class="contact-form__label" for="email">E-mail</label>
                    <input 
                        class="contact-form__input @error('email') is-invalid @enderror" 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="Ex: email@provedor.com"
                        value="{{ old('email') }}"
                        required
                    >
                    @error('email')
                        <span class="contact-form__error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="contact-form__group">
                    <label class="contact-form__label" for="phone">Número de celular (com DDD)</label>
                    <input 
                        class="contact-form__input @error('phone') is-invalid @enderror" 
                        type="tel" 
                        id="phone" 
                        name="phone" 
                        placeholder="ex: (53) 00000-0000"
                        value="{{ old('phone') }}"
                        required
                    >
                    @error('phone')
                        <span class="contact-form__error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Assunto -->
            <div class="contact-form__group contact-form__group--full">
                <label class="contact-form__label" for="subject">Assunto</label>
                <input 
                    class="contact-form__input @error('subject') is-invalid @enderror" 
                    type="text" 
                    id="subject" 
                    name="subject" 
                    placeholder="O que você precisa?"
                    value="{{ old('subject') }}"
                    required
                >
                @error('subject')
                    <span class="contact-form__error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Mensagem -->
            <div class="contact-form__group contact-form__group--full">
                <label class="contact-form__label" for="message">Mensagem</label>
                <textarea 
                    class="contact-form__textarea @error('message') is-invalid @enderror" 
                    id="message" 
                    name="message" 
                    rows="8"
                    placeholder="Escreva aqui a sua mensagem completa"
                    required
                >{{ old('message') }}</textarea>
                @error('message')
                    <span class="contact-form__error">{{ $message }}</span>
                @enderror
            </div>

            <!-- Botão Enviar -->
            <div class="contact-form__submit-wrapper">
                <button type="submit" class="contact-form__submit">ENVIAR</button>
            </div>
        </form>
    </div>
</div>
@vite('resources/css/contact.scss')
@endsection
