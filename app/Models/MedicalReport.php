<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['patient_id', 'type', 'content', 'file_path'])]
class MedicalReport extends Model
{
    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
