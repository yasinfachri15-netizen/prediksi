<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ModelTrainingRun extends Model
{
    protected $fillable = [
        'trained_by',
        'training_samples',
        'evaluation_samples',
        'evaluation_method',
        'evaluation_metrics',
        'parameters',
    ];

    protected $casts = [
        'evaluation_metrics' => 'array',
        'parameters' => 'array',
    ];
}
