<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Candidate;

class Degree extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = "degrees";

    protected $fillable = [
        'degreeTitle',
    ];

    public function candidates(){
        return $this->hasMany(Candidate::class);
    }
}
