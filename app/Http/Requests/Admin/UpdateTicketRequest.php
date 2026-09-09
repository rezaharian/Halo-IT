<?php

namespace App\Http\Requests\Admin;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTicketRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->can('update', $this->route('ticket')) ?? false;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'integer', Rule::exists('categories', 'id')->where('is_active', true)],
            'assigned_to' => ['nullable', 'integer', Rule::exists('users', 'id')->where('role', 'admin')],
            'priority' => ['required', Rule::in(TicketPriority::values())],
            'status' => ['required', Rule::in(TicketStatus::values())],
        ];
    }
}
