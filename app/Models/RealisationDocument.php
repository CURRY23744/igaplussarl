<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RealisationDocument extends Model
{
    use HasFactory;

    protected $table = 'realisation_documents';

    protected $fillable = [
        'realisation_id',
        'file_path',
        'file_name',
        'file_type',
        'file_size',
    ];

    /**
     * Relation : un document appartient à une réalisation
     */
    public function realisation()
    {
        return $this->belongsTo(Realisation::class);
    }
}