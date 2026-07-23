<?php

return [
    'required' => 'O campo :attribute é obrigatório.',
    'email' => 'O campo :attribute deve ser um endereço de e-mail válido.',
    'max' => [
        'string' => 'O campo :attribute não pode ser superior a :max caracteres.',
        'file' => 'O campo :attribute não pode ser superior a :max kilobytes.',
    ],
    'image' => 'O campo :attribute deve ser uma imagem.',
    'mimes' => 'O campo :attribute deve ser um ficheiro do tipo: :values.',
    'confirmed' => 'A confirmação de :attribute não corresponde.',
    'min' => [
        'string' => 'O campo :attribute deve ter pelo menos :min caracteres.',
    ],
    'current_password' => 'A palavra-passe está incorreta.',
    'unique' => 'O valor de :attribute já está em uso.',
    'attributes' => [
        'name' => 'nome',
        'email' => 'e-mail',
        'password' => 'palavra-passe',
        'current_password' => 'palavra-passe atual',
        'password_confirmation' => 'confirmação da palavra-passe',
        'avatar' => 'fotografia',
    ],
];
