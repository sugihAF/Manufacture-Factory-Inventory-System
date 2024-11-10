<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Workload extends Model
{
    protected $fillable = [
        'id',
        'request_id',
        'factory_id',
        'machine_id',
        'start_date',
        'completion_date',
        'status',
        'supervisor_approval',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Generate custom ID in 'WKLD-001' format
            $latestId = self::max('id');
            $number = $latestId ? ((int) substr($latestId, 5)) + 1 : 1;
            $model->id = 'WKLD-' . str_pad($number, 3, '0', STR_PAD_LEFT);
        });
    }

    // Relationship to SparepartRequest
    public function sparepartRequest()
    {
        return $this->belongsTo(SparepartRequest::class, 'request_id', 'id');
    }
}