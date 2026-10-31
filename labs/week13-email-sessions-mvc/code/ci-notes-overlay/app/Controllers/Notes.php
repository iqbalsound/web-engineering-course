<?php
namespace App\Controllers;
use App\Models\NoteModel;

class Notes extends BaseController
{
    public function index(): string
    {
        $model = new NoteModel();
        return view('notes/index', ['notes' => $model->orderBy('id', 'DESC')->paginate(5), 'pager' => $model->pager]);
    }
    public function store()
    {
        $model = new NoteModel();
        if (! $model->insert($this->request->getPost(['title', 'body']))) {
            return redirect()->back()->withInput()->with('errors', $model->errors());
        }
        return redirect()->to('/notes')->with('message', 'Note saved.');
    }
    public function delete(int $id)
    {
        (new NoteModel())->delete($id);
        return redirect()->to('/notes')->with('message', 'Note deleted.');
    }
}
