<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Workload extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'request_id',
        'factory_id',
        'machine_id',
        'start_date',
        'completion_date',
        'status',
        'supervisor_approval',
        // Add other fillable fields as necessary
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'completion_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $latestId = self::max('id');
            $number = $latestId ? ((int) substr($latestId, 5)) + 1 : 1;
            $model->id = 'WKLD-' . str_pad($number, 3, '0', STR_PAD_LEFT);
            // $model->status = 'Pending';
            // $model->factory_id = 1; // Default factory ID
            // $model->start_date = NULL;
        });
    }

    // Relationships
    public function sparepartRequest()
    {
        return $this->belongsTo(SparepartRequest::class, 'request_id', 'id');
    }

    public function factory()
    {
        return $this->belongsTo(Factory::class, 'factory_id', 'id');
    }

    public function supervisor()
    {
        return $this->belongsTo(Supervisor::class, 'supervisor_approval', 'id');
    }
}