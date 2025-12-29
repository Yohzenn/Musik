<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $clientId = $this->route('client')?->id;

        return [
            'email' => ['required', 'email', 'max:255', 'unique:clients,email,' . $clientId],
            'civility' => ['required', 'string', 'in:Monsieur,Madame'],
            'company' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'first_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string'],
            'postal_code' => ['required', 'string', 'digits:5'],
            'city' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'email.required' => 'L\'adresse email est obligatoire.',
            'email.email' => 'L\'adresse email n\'est pas valide.',
            'email.unique' => 'Cette adresse email est déjà utilisée.',
            'civility.required' => 'La civilité est obligatoire.',
            'civility.in' => 'La civilité doit être Monsieur ou Madame.',
            'last_name.required' => 'Le nom est obligatoire.',
            'first_name.required' => 'Le prénom est obligatoire.',
            'address.required' => 'L\'adresse postale est obligatoire.',
            'postal_code.required' => 'Le code postal est obligatoire.',
            'postal_code.digits' => 'Le code postal doit contenir exactement 5 chiffres.',
            'city.required' => 'La ville est obligatoire.',
            'country.required' => 'Le pays est obligatoire.',
        ];
    }
}
