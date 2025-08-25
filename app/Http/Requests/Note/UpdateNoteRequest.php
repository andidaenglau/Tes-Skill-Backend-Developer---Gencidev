<?php
namespace App\Http\Requests\Note;


use Illuminate\Foundation\Http\FormRequest;


class UpdateNoteRequest extends FormRequest
{
public function authorize(): bool { return true; }
public function rules(): array {
return [
'title' => 'sometimes|required|string|max:150',
'content' => 'nullable|string',
];
}
}