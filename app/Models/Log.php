<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $table = 'logs';

    // disattiviamo updated_at
    const UPDATED_AT = null;

    // permettiamo il fill di questi campi
    protected $fillable = [
        'level',
        'context',
        'message',
        'extra',
        'created_at',
    ];

    public static function new(string $message, string $level = 'info', ?string $context = null, ?array $extra = null): static
    {
        return self::create([
            'level'      => $level,
            'context'    => $context,
            'message'    => $message,
            'extra'      => $extra ? json_encode($extra) : null,
            'created_at' => now(),
        ]);
    }
}
