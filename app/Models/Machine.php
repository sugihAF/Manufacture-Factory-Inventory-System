<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Machine extends Model
{
    protected $fillable = ['id', 'factory_id', 'name', 'status'];

    public $incrementing = false;
    protected $keyType = 'string';

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            // Generate custom ID in 'MCHN-001' format
            $latestId = DB::table('machines')
                ->select(DB::raw('MAX(CAST(SUBSTRING(id, 6) AS UNSIGNED)) as latest_id'))
                ->value('latest_id');

            $number = $latestId ? $latestId + 1 : 101; // Start from 101
            $model->id = 'MCHN-' . $number;
        });
    }

    public function factory()
    {
        return $this->belongsTo(Factory::class);
    }
}