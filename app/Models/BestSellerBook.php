<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BestSeller;

class BestSellerBook extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'best_seller_books';
    protected $casts = [
        'buy_links' => 'array',
    ];
    protected $fillable = [
        'list_id',
        'title',
        'author',
        'book_rank',
        'weeks_on_list',
        'image',
        'buy_links',
    ];

    /**
     * Get the List.
     */
    public function list()
    {
        return $this->hasOne(BestSeller::class, 'list_id', 'list_id');
    }
}
