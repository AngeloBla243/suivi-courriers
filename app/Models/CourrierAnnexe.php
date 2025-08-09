<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourrierAnnexe extends Model
{
    protected $fillable = ['courrier_id', 'filename', 'label'];
    public function courrier()
    {
        return $this->belongsTo(Courrier::class);
    }
}
