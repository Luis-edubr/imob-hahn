<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AnuncieController extends Controller
{
    public function show()
    {
        return view('anuncie');
    }

    public function store(Request $request)
    {
        // TODO: Implementar lógica de envio de email/mensagem
        $validated = $request->validate([
            // Dados Pessoais
            'name' => 'required|string|max:255',
            'cpf' => 'required|string|max:14',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            
            // Endereço do imóvel
            'address' => 'required|string|max:255',
            'zip' => 'required|string|max:9',
            'neighborhood' => 'required|string|max:255',
            'number' => 'required|string|max:10',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:2',
            'complement' => 'nullable|string|max:255',
            
            // Dados do imóvel
            'property_type' => 'required|string',
            'suites' => 'nullable|integer',
            'bedrooms' => 'nullable|integer',
            'bathrooms' => 'nullable|integer',
            'rooms' => 'nullable|integer',
            'garages' => 'nullable|integer',
            'bbq' => 'nullable|boolean',
            'additional_info' => 'nullable|string|max:2000',
            
            // Autorização
            'authorization' => 'required|accepted',
        ]);

        return redirect('/')
            ->with('success', 'Anúncio enviado com sucesso! Entraremos em contato em breve.');
    }
}
