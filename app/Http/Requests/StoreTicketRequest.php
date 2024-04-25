<?php

namespace App\Http\Requests;

use App\Models\Ticket;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreTicketRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('ticket_create');
    }

    public function rules()
    {
        return [
            'proyecto_id' => [
                'required',
                'integer',
            ],
            'users.*' => [
                'integer',
            ],
            'users' => [
                'array',
            ],
            'asunto' => [
                'string',
                'nullable',
            ],
        ];
    }
}
