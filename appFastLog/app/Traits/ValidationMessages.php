<?php

namespace App\Traits;

trait ValidationMessages
{
    protected function getUserValidationMessages(): array
    {
        return [
            'nome.required' => 'O nome é obrigatório.',
            'nome.string' => 'O nome deve ser um texto.',
            'nome.max' => 'O nome não pode ter mais que :max caracteres.',

            'telefone.required' => 'O telefone é obrigatório.',
            'telefone.phone' => 'O telefone informado não é válido.',

            'endereco.required' => 'O endereço é obrigatório.',
            'endereco.string' => 'O endereço deve ser um texto.',
            'endereco.max' => 'O endereço não pode ter mais que :max caracteres.',

            'email.required' => 'O e-mail é obrigatório.',
            'email.email' => 'O e-mail informado não é válido.',
            'email.unique' => 'Este e-mail já está em uso.',
            'email.max' => 'O e-mail não pode ter mais que :max caracteres.',

            'password.required' => 'A senha é obrigatória.',
            'password.min' => 'A senha deve ter no mínimo :min caracteres.',
            'password.confirmed' => 'A confirmação da senha não corresponde.',
        ];
    }

    protected function getPedidoValidationMessages(): array
    {
        return array_merge($this->getCommonValidationMessages(), [
            'numeroPedido.required' => 'O número do pedido é obrigatório.',
            'numeroPedido.max' => 'O número do pedido não pode ter mais que :max caracteres.',
            'numeroPedido.unique' => 'Este número de pedido já está em uso.',

            'destinatarioNome.required' => 'O nome do destinatário é obrigatório.',
            'destinatarioNome.max' => 'O nome do destinatário não pode ter mais que :max caracteres.',

            'destinatarioEndereco.required' => 'O endereço do destinatário é obrigatório.',
            'destinatarioEndereco.max' => 'O endereço não pode ter mais que :max caracteres.',

            'destinatarioTelefone.required' => 'O telefone do destinatário é obrigatório.',
            'destinatarioTelefone.phone' => 'O telefone informado não é válido.',

            'itemDescricao.required' => 'A descrição do item é obrigatória.',
            'itemDescricao.max' => 'A descrição do item não pode ter mais que :max caracteres.',

            'entregador_id.required' => 'O entregador é obrigatório.',
            'entregador_id.exists' => 'O entregador selecionado não existe.',

            'status.required' => 'O status é obrigatório.',
            'status.in' => 'O status informado é inválido.'
        ]);
    }

    protected function getEntregadorValidationMessages(): array
    {
        return array_merge($this->getCommonValidationMessages(), [
            'tipoVeiculo.required' => 'O tipo de veículo é obrigatório.',
            'tipoVeiculo.in' => 'O tipo de veículo informado é inválido.'
        ]);
    }

    protected function getCommonValidationMessages(): array
    {
        return [
            'required' => 'O campo :attribute é obrigatório.',
            'string' => 'O campo :attribute deve ser um texto.',
            'max' => 'O campo :attribute não pode ter mais que :max caracteres.',
            'phone' => 'O campo :attribute deve ser um telefone válido.', // se você quiser, porque usou phone:BR
        ];
    }
}
