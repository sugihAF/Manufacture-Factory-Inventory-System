<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Invoice extends Model
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
        'request_id',
        'total_amount',
        'invoice_date',
        'payment_date',
        'status',
        'due_date',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'invoice_date' => 'datetime',
        'payment_date' => 'datetime',
        'due_date' => 'datetime',
    ];

    /**
     * Boot function from Laravel.
     */
    protected static function boot()
    {
        parent::boot();

        // Automatically generate the custom ID and calculate total_amount and due_date when creating a new Invoice
        static::creating(function ($model) {
            if (empty($model->id)) {
                $model->id = $model->generateCustomId();
            }

            // Calculate total_amount
            $sparepartRequest = SparepartRequest::with('sparepart')->find($model->request_id);
            if ($sparepartRequest) {
                $model->total_amount = $sparepartRequest->qty * $sparepartRequest->sparepart->price;
            }

            // Set due_date to one week after invoice_date
            $model->due_date = Carbon::now()->addWeek();
        });
    }

    /**
     * Generate a custom ID in the format 'INVC-001'.
     *
     * @return string
     */
    public function generateCustomId()
    {
        // Fetch the latest Invoice ID
        $latest = self::latest('created_at')->first();

        if (!$latest) {
            $number = 1;
        } else {
            // Extract the numeric part from the latest ID
            $latestIdNumber = intval(substr($latest->id, -3));
            $number = $latestIdNumber + 1;
        }

        // Pad the number with leading zeros
        $number_padded = str_pad($number, 3, '0', STR_PAD_LEFT);

        return 'INVC-' . $number_padded;
    }

    /**
     * Get the Distributor that owns the Invoice.
     */
    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }

    /**
     * Get the SparepartRequest associated with the Invoice.
     */
    public function sparepartRequest()
    {
        return $this->belongsTo(SparepartRequest::class, 'request_id', 'id');
    }
}
