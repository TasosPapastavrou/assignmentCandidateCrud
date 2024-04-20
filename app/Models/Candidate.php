<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Degree;
use Illuminate\Database\Eloquent\Builder;

class Candidate extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $table = "candidates";

    protected $fillable = [
        'lastName','firstName','email', 'mobile', 'jobAppliedFor',
    ];

    private $path = 'cv';

    public function degree(){
        return $this->belongsTo(Degree::class);
    } 

    public function getPath(){
        return $this->path;
    }

    public function saveCV($pdf){

        if($pdf != null){
            $path = $this->getPath();
            $image_path = $path.'/'.time() . '_' . $pdf->getClientOriginalName();
            // $pdf->move($path, $image_path);


            $pdf->move(public_path('cv'), $image_path);

            return $image_path;   
        }else{
            return $pdf;
        }

    }



    public function scopefilterCandidates(Builder $query, $search)
    {
        $query->when($search ?? null, function ($query) use ($search) {
            $query->where(function ($query) use ($search) {
                $query->where('jobAppliedFor', 'LIKE', '%' . $search . '%');
            });
        });
    }

    public function deleteCV(){

        if($this->resume){
            if (file_exists(public_path($this->resume))) {
                unlink(public_path($this->resume));
            }
        }

    }

    public function getJobAppliedIs(){

        $textJob = $this->jobAppliedFor;
        $list = collect([ 
            ['id'=>1,'text'=>'PHP Developer'],
            ['id'=>2,'text'=>'JAVA Developer'],
            ['id'=>3,'text'=>'PYTHON Developer'],
            ['id'=>4,'text'=>'ERP Support'],
            ['id'=>5,'text'=>'Sales'],
            ['id'=>6,'text'=>'Technician'], 
        ]);
        $record = $list->where('text', $textJob)->first();

        return $record['id'];

    }

}
