<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReturnRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'user_id',
        'reason',
        'description',
        'solution',
        'photos',
        'contact_name',
        'contact_phone',
        'sender_address',
        'sender_city',
        'sender_state',
        'sender_zip',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'photos' => 'array',
    ];

    // Reason labels
    public const REASONS = [
        'damaged' => 'Produk Rusak/Cacat',
        'not_as_described' => 'Produk Tidak Sesuai Deskripsi',
        'wrong_item' => 'Salah Kirim Produk',
        'changed_mind' => 'Berubah Pikiran',
        'other' => 'Lainnya',
    ];

    // Solution labels
    public const SOLUTIONS = [
        'refund' => 'Pengembalian Dana',
        'exchange' => 'Penukaran Barang',
    ];

    // Status labels
    public const STATUSES = [
        'pending' => 'Menunggu Persetujuan',
        'approved' => 'Disetujui',
        'rejected' => 'Ditolak',
        'completed' => 'Selesai',
    ];

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getReasonLabelAttribute()
    {
        return self::REASONS[$this->reason] ?? $this->reason;
    }

    public function getSolutionLabelAttribute()
    {
        return self::SOLUTIONS[$this->solution] ?? $this->solution;
    }

    public function getStatusLabelAttribute()
    {
        return self::STATUSES[$this->status] ?? $this->status;
    }
}
