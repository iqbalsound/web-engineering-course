<?php
namespace App\Models;
use CodeIgniter\Model;

class NoteModel extends Model
{
    protected $table = 'notes';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'body'];
    protected $useTimestamps = true;
    protected $validationRules = [
        'title' => 'required|min_length[3]|max_length[120]',
        'body'  => 'permit_empty|max_length[2000]',
    ];
}
