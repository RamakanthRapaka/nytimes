<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\BestSellerBook;

class BestSeller extends Model
{
    use HasFactory;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'best_sellers';
    protected $fillable = [
        'list_id',
        'list_name',
        'bestsellers_date',
    ];

    /**
     * Get the books.
     */
    public function books()
    {
        return $this->hasMany(BestSellerBook::class, 'list_id', 'list_id');
    }
}
