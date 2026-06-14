<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BookIssue extends Model
{
    use HasFactory;

    protected $table = 'book_issues';

    protected $fillable = [
        'user_id',
        'book_id',
        'request_type',
        'status',
        'issue_date',
        'due_date',
        'return_date',
        'fine_per_day',
        'fine_amount',
        'admin_id',
        'admin_comment',
    ];

    protected $casts = [
        'issue_date' => 'date',
        'due_date' => 'date',
        'return_date' => 'date',
        'fine_per_day' => 'decimal:2',
        'fine_amount' => 'decimal:2',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function isPendingIssue(): bool
    {
        return $this->status === 'pending_issue';
    }

    public function isPendingReturn(): bool
    {
        return $this->status === 'pending_return';
    }
}
