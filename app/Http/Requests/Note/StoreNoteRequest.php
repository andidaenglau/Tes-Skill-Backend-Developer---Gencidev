<?php
namespace App\Http\Requests\Note;


use Illuminate\Foundation\Http\FormRequest;


class StoreNoteRequest extends FormRequest
{
public function authorize(): bool { return true; }
public function rules(): array {
return [
'title' => 'required|string|max:150',
'content' => 'nullable|string',
];
}
}