<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Email;
use App\Core\Validate;

class contatoController extends Controller
{
    public function index($request, $response)
    {
        $this->view('contato', ['title' => 'Contato', 'dados' => 'Fale Conosco']);
    }

    public function store($request, $response, $args)
    {
        $validate = new Validate;
        $data = $validate->validate([
            'email' => 'required',
            'nome' => 'required',
            'mensagem' => 'required',
        ]);

        if ($validate->hasErrors()) {
            return $this->create();
        }
        $email = new Email;
        $email->data([
            'toName' => $data->nome,
            'toEmail' => $data->email,
            'fromName' => 'Fisio Evol',
            'fromEmail' => 'contato@fisio.com',
            'mensagem' => $data->mensagem,
        ])->send();
        return back();
    }
}
