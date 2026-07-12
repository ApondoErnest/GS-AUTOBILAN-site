<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class ContactMessageRequest extends PublicFormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'name' => $this->cleanedString($this->input('name')),
            'phone' => $this->normalizedPhone($this->input('phone')),
            'email' => $this->cleanedString($this->input('email')),
            'agency_id' => $this->cleanedString($this->input('agency_id')),
            'subject' => $this->cleanedString($this->input('subject')),
            'message' => $this->cleanedString($this->input('message')),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:160'],
            'phone' => ['nullable', 'required_without:email', 'string', 'regex:/^\+[0-9]{8,20}$/'],
            'email' => ['nullable', 'required_without:phone', 'email:rfc', 'max:255'],
            'agency_id' => [
                'nullable',
                'integer',
                Rule::exists('agencies', 'id')->where('is_active', true),
            ],
            'subject' => ['required', 'string', 'max:180'],
            'message' => ['required', 'string', 'max:3000'],
        ];
    }
}
