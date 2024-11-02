<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SparepartRequest extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'distributor_id',
        'sparepart_id',
        'invoice_id',
        'qty',
        'status',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'request_date' => 'datetime',
    ];

    /**
     * Boot function from Laravel.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->status = 'Submitted';
        });
        // Automatically generate the custom ID when creating a new SparepartRequest
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = $model->generateCustomId();
            }
        });
    }

    /**
     * Generate a custom ID in the format 'SPRT-RQ-001'.
     *
     * @return string
     */
    public function generateCustomId()
    {
        // Fetch the latest SparepartRequest ID
        $latest = self::latest('created_at')->first();

        if (!$latest) {
            $number = 1;
        } else {
            // Extract the numeric part from the latest ID
            $number = intval(substr($latest->id, -3)) + 1;
        }

        // Pad the number with leading zeros
        $number_padded = str_pad($number, 3, '0', STR_PAD_LEFT);

        return 'SPRT-RQ-' . $number_padded;
    }

    /**
     * Get the client that owns the SparepartRequest.
     */
    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }

    /**
     * Get the sparepart associated with the SparepartRequest.
     */
    public function sparepart()
    {
        return $this->belongsTo(Sparepart::class, 'sparepart_id', 'id');
    }
}
