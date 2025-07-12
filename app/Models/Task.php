<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'status',
        'deadline',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    /**
     * Get the status options.
     */
    public static function getStatusOptions(): array
    {
        return [
            'todo' => 'Todo',
            'doing' => 'Doing',
            'done' => 'Done',
        ];
    }

    /**
     * Scope for tasks by status.
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope for overdue tasks.
     */
    public function scopeOverdue($query)
    {
        return $query->where('deadline', '<', now())
                    ->where('status', '!=', 'done');
    }

    /**
     * Scope for upcoming tasks.
     */
    public function scopeUpcoming($query)
    {
        return $query->where('deadline', '>', now())
                    ->where('status', '!=', 'done');
    }
} 