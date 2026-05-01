@extends('layouts.home')

@section('content')
<div class="anuncie-page">
    <!-- Cabeçalho da página ANUNCIE -->
    <div class="anuncie-page__header">
        <h1 class="anuncie-page__title">ANUNCIE</h1>
    </div>

    <!-- Textos informativos -->
    <div class="anuncie-page__intro">
        <p class="anuncie-page__intro-text">
            Administramos o seu imóvel (rural ou urbano) de acordo com os seus interesses da melhor forma. Para cadastrar o imóvel, preencha os campos abaixo, logo em seguida clique em "Enviar" e aguarde o nosso contato.
        </p>
        <p class="anuncie-page__intro-note">
            Captamos imóveis com locações em andamento.
        </p>
    </div>

    <!-- Formulário de Anúncio -->
    <form class="anuncie-form" method="POST" action="{{ route('anuncie.store') }}">
        @csrf

        <!-- SEÇÃO: Dados Pessoais -->
        <section class="form-section form-section--green">
            <h2 class="form-section__title">Dados Pessoais</h2>
            <div class="form-section__divider"></div>

            <!-- Linha 1: Nome e CPF -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label form-label--light" for="name">Seu nome (obrigatório)</label>
                    <input 
                        class="form-input @error('name') is-invalid @enderror" 
                        type="text" 
                        id="name" 
                        name="name" 
                        placeholder="Insira seu nome completo"
                        value="{{ old('name') }}"
                        required
                    >
                    @error('name')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label form-label--light" for="cpf">CPF (obrigatório)</label>
                    <input 
                        class="form-input @error('cpf') is-invalid @enderror" 
                        type="text" 
                        id="cpf" 
                        name="cpf" 
                        placeholder="Ex: 123.456.789-00"
                        value="{{ old('cpf') }}"
                        required
                    >
                    @error('cpf')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Linha 2: E-mail e Celular -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label form-label--light" for="email">E-mail (obrigatório)</label>
                    <input 
                        class="form-input @error('email') is-invalid @enderror" 
                        type="email" 
                        id="email" 
                        name="email" 
                        placeholder="Ex: email@provedor.com"
                        value="{{ old('email') }}"
                        required
                    >
                    @error('email')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label form-label--light" for="phone">Número de celular (obrigatório)</label>
                    <input 
                        class="form-input @error('phone') is-invalid @enderror" 
                        type="tel" 
                        id="phone" 
                        name="phone" 
                        placeholder="ex: (53) 00000-0000"
                        value="{{ old('phone') }}"
                        required
                    >
                    @error('phone')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </section>

        <!-- SEÇÃO: Endereço do imóvel -->
        <section class="form-section form-section--green">
            <h2 class="form-section__title">Endereço do imóvel</h2>
            <div class="form-section__divider"></div>

            <!-- Linha 1: Endereço e CEP -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label form-label--light" for="address">Endereço (obrigatório)</label>
                    <input 
                        class="form-input @error('address') is-invalid @enderror" 
                        type="text" 
                        id="address" 
                        name="address" 
                        placeholder="Ex: Rua dos alfeneiros"
                        value="{{ old('address') }}"
                        required
                    >
                    @error('address')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label form-label--light" for="zip">CEP (obrigatório)</label>
                    <input 
                        class="form-input @error('zip') is-invalid @enderror" 
                        type="text" 
                        id="zip" 
                        name="zip" 
                        placeholder="Ex: 96.000-100"
                        value="{{ old('zip') }}"
                        required
                    >
                    @error('zip')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Linha 2: Bairro e Número -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label form-label--light" for="neighborhood">Bairro (obrigatório)</label>
                    <input 
                        class="form-input @error('neighborhood') is-invalid @enderror" 
                        type="text" 
                        id="neighborhood" 
                        name="neighborhood" 
                        placeholder="Digite o bairro"
                        value="{{ old('neighborhood') }}"
                        required
                    >
                    @error('neighborhood')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label form-label--light" for="number">Número (obrigatório)</label>
                    <input 
                        class="form-input @error('number') is-invalid @enderror" 
                        type="text" 
                        id="number" 
                        name="number" 
                        placeholder="Digite o número"
                        value="{{ old('number') }}"
                        required
                    >
                    @error('number')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Linha 3: Cidade e Estado -->
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label form-label--light" for="city">Cidade (obrigatório)</label>
                    <input 
                        class="form-input @error('city') is-invalid @enderror" 
                        type="text" 
                        id="city" 
                        name="city" 
                        placeholder="Digite a cidade"
                        value="{{ old('city') }}"
                        required
                    >
                    @error('city')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label form-label--light" for="state">Estado (obrigatório)</label>
                    <input 
                        class="form-input @error('state') is-invalid @enderror" 
                        type="text" 
                        id="state" 
                        name="state" 
                        placeholder="Ex: RS"
                        value="{{ old('state') }}"
                        maxlength="2"
                        required
                    >
                    @error('state')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Linha 4: Complemento -->
            <div class="form-row">
                <div class="form-group form-group--full">
                    <label class="form-label form-label--light" for="complement">Complemento (opcional)</label>
                    <input 
                        class="form-input @error('complement') is-invalid @enderror" 
                        type="text" 
                        id="complement" 
                        name="complement" 
                        placeholder="Apt., sala, etc."
                        value="{{ old('complement') }}"
                    >
                    @error('complement')
                        <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </section>

        <!-- SEÇÃO: Dados do imóvel -->
        <section class="form-section form-section--green">
            <h2 class="form-section__title">Dados do imóvel</h2>
            <div class="form-section__divider"></div>

            <div class="dados-imovel">
                <!-- Row 1: left = property type (full), right = suites + bbq side-by-side -->
                <div class="dados-imovel__row">
                    <div class="dados-imovel__col dados-imovel__col--left">
                        <div class="form-group form-group--full">
                            <label class="form-label form-label--light" for="property_type">Tipo de imóvel (obrigatório)</label>
                            <div class="form-select-wrapper">
                                <select 
                                    class="form-select @error('property_type') is-invalid @enderror" 
                                    id="property_type" 
                                    name="property_type"
                                    required
                                >
                                    <option value="">Selecione</option>
                                    <option value="casa" {{ old('property_type') === 'casa' ? 'selected' : '' }}>Casa</option>
                                    <option value="apartamento" {{ old('property_type') === 'apartamento' ? 'selected' : '' }}>Apartamento</option>
                                    <option value="terreno" {{ old('property_type') === 'terreno' ? 'selected' : '' }}>Terreno</option>
                                    <option value="comercial" {{ old('property_type') === 'comercial' ? 'selected' : '' }}>Comercial</option>
                                    <option value="rural" {{ old('property_type') === 'rural' ? 'selected' : '' }}>Rural</option>
                                </select>
                            </div>
                            @error('property_type')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>

                    <div class="dados-imovel__col dados-imovel__col--right">
                        <div class="dados-imovel__small-row">
                            <div class="form-group">
                                <label class="form-label form-label--light" for="suites">Suítes (opcional)</label>
                                <div class="form-select-wrapper">
                                    <select class="form-select form-select--small" id="suites" name="suites">
                                        <option value="">0</option>
                                        <option value="1" {{ old('suites') === '1' ? 'selected' : '' }}>1</option>
                                        <option value="2" {{ old('suites') === '2' ? 'selected' : '' }}>2</option>
                                        <option value="3" {{ old('suites') === '3' ? 'selected' : '' }}>3</option>
                                        <option value="4" {{ old('suites') === '4' ? 'selected' : '' }}>4</option>
                                        <option value="5+" {{ old('suites') === '5+' ? 'selected' : '' }}>5+</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label form-label--light" for="bbq">Churrasqueira (opcional)</label>
                                <div class="form-select-wrapper">
                                    <select class="form-select form-select--small" id="bbq" name="bbq">
                                        <option value="">Não</option>
                                        <option value="1" {{ old('bbq') === '1' ? 'selected' : '' }}>Sim</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Row 2: left split into two columns (each with two stacked selects), right = textarea -->
                <div class="dados-imovel__row">
                    <div class="dados-imovel__col dados-imovel__col--left">
                        <div class="dados-imovel__left-split">
                            <div class="dados-imovel__stack">
                                <div class="form-group">
                                    <label class="form-label form-label--light" for="rooms">Salas (opcional)</label>
                                    <div class="form-select-wrapper">
                                        <select class="form-select form-select--small" id="rooms" name="rooms">
                                            <option value="">0</option>
                                            <option value="1" {{ old('rooms') === '1' ? 'selected' : '' }}>1</option>
                                            <option value="2" {{ old('rooms') === '2' ? 'selected' : '' }}>2</option>
                                            <option value="3" {{ old('rooms') === '3' ? 'selected' : '' }}>3</option>
                                            <option value="4+" {{ old('rooms') === '4+' ? 'selected' : '' }}>4+</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label form-label--light" for="bathrooms">Banheiros (opcional)</label>
                                    <div class="form-select-wrapper">
                                        <select class="form-select form-select--small" id="bathrooms" name="bathrooms">
                                            <option value="">0</option>
                                            <option value="1" {{ old('bathrooms') === '1' ? 'selected' : '' }}>1</option>
                                            <option value="2" {{ old('bathrooms') === '2' ? 'selected' : '' }}>2</option>
                                            <option value="3" {{ old('bathrooms') === '3' ? 'selected' : '' }}>3</option>
                                            <option value="4+" {{ old('bathrooms') === '4+' ? 'selected' : '' }}>4+</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="dados-imovel__stack">
                                <div class="form-group">
                                    <label class="form-label form-label--light" for="bedrooms">Dormitórios (opcional)</label>
                                    <div class="form-select-wrapper">
                                        <select class="form-select form-select--small" id="bedrooms" name="bedrooms">
                                            <option value="">0</option>
                                            <option value="1" {{ old('bedrooms') === '1' ? 'selected' : '' }}>1</option>
                                            <option value="2" {{ old('bedrooms') === '2' ? 'selected' : '' }}>2</option>
                                            <option value="3" {{ old('bedrooms') === '3' ? 'selected' : '' }}>3</option>
                                            <option value="4" {{ old('bedrooms') === '4' ? 'selected' : '' }}>4</option>
                                            <option value="5+" {{ old('bedrooms') === '5+' ? 'selected' : '' }}>5+</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="form-label form-label--light" for="garages">Vagas de garagem (opcional)</label>
                                    <div class="form-select-wrapper">
                                        <select class="form-select form-select--small" id="garages" name="garages">
                                            <option value="">0</option>
                                            <option value="1" {{ old('garages') === '1' ? 'selected' : '' }}>1</option>
                                            <option value="2" {{ old('garages') === '2' ? 'selected' : '' }}>2</option>
                                            <option value="3" {{ old('garages') === '3' ? 'selected' : '' }}>3</option>
                                            <option value="4+" {{ old('garages') === '4+' ? 'selected' : '' }}>4+</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="dados-imovel__col dados-imovel__col--right">
                        <div class="form-group form-group--full">
                            <label class="form-label form-label--light" for="additional_info">Mais informações (opcional)</label>
                            <textarea 
                                class="form-textarea @error('additional_info') is-invalid @enderror"
                                id="additional_info"
                                name="additional_info"
                                placeholder="Digite sua mensagem"
                                rows="6"
                            >{{ old('additional_info') }}</textarea>
                            @error('additional_info')
                                <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Checkbox de Autorização -->
        <div class="form-authorization">
            <input 
                class="form-checkbox" 
                type="checkbox" 
                id="authorization" 
                name="authorization" 
                value="1"
                {{ old('authorization') ? 'checked' : '' }}
                required
            >
            <label class="form-checkbox-label" for="authorization">
                Eu autorizo a Imobiliária Hahn a entrar em contato comigo pelos meios de contatos descritos no formulário acima.
            </label>
            @error('authorization')
                <span class="form-error">{{ $message }}</span>
            @enderror
        </div>

        <!-- Botão Enviar -->
        <div class="form-submit-wrapper">
            <button type="submit" class="form-submit">ENVIAR</button>
        </div>
    </form>
</div>
@vite('resources/css/anuncie.scss')
@endsection
