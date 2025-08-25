<?php
namespace App\Http\Controllers\Api;


use App\Http\Controllers\Controller;
use App\Http\Requests\Note\StoreNoteRequest;
use App\Http\Requests\Note\UpdateNoteRequest;
use App\Models\Note;
use Illuminate\Http\JsonResponse;


class NoteController extends Controller
{
public function index(): JsonResponse
{
$notes = Note::where('user_id', auth('api')->id())
->latest('id')->paginate(10);
return response()->json($notes);
}


public function store(StoreNoteRequest $request): JsonResponse
{
$note = Note::create([
'title' => $request->title,
'content' => $request->content,
'user_id' => auth('api')->id(),
]);
return response()->json($note, 201);
}


public function show(Note $note): JsonResponse
{
$this->authorizeNote($note);
return response()->json($note);
}


public function update(UpdateNoteRequest $request, Note $note): JsonResponse
{
$this->authorizeNote($note);
$note->update($request->validated());
return response()->json($note);
}


public function destroy(Note $note): JsonResponse
{
$this->authorizeNote($note);
$note->delete();
return response()->json(['message' => 'Deleted']);
}


private function authorizeNote(Note $note): void
{
abort_if($note->user_id !== auth('api')->id(), 403, 'Forbidden');
}
}