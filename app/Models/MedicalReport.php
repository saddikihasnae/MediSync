<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MedicalReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_id', 
        'patient_id', 
        'type', 
        'report_date', 
        'result_summary'
    ];

    protected $casts = [
        'report_date' => 'date',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }
}
