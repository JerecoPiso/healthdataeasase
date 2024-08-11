<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AuditTrail extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'reference_id',
        'reference_table',
        'action',
        'status',
        'message',
        'data',
        'old_value'
    ];

    public static function createAuditTrail($user_id, $ref_id, $ref_table, $action, $status, $message, $data)
    {
        return self::create([
            'user_id' => $user_id,
            'reference_id' => !empty($ref_id) ? $ref_id : 0,
            'reference_table' => $ref_table,
            'action' => $action,
            'status' =>  $status,
            'message' => $message,
            'data' => $data,
        ]);
    }
}
