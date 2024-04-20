<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Degree;
use App\Models\Candidate;
use Symfony\Component\HttpFoundation\Response;

class CandidateController extends Controller
{

    public $jobApplied = [ 
                            ['id'=>1,'text'=>'PHP Developer'],
                            ['id'=>2,'text'=>'JAVA Developer'],
                            ['id'=>3,'text'=>'PYTHON Developer'],
                            ['id'=>4,'text'=>'ERP Support'],
                            ['id'=>5,'text'=>'Sales'],
                            ['id'=>6,'text'=>'Technician'], 
                        ];

    public function getJobAppliedFor(Request $request){
        $allJobs = $this->jobApplied;  
        $AppliedJob = $request->get('job');
        $isSelected = true;

        foreach($allJobs as $key => $job){  
            if($job['text']==$AppliedJob || $job['id']==$AppliedJob){
                $allJobs[$key]['selected'] = true;  
            }
        }

        if(!empty($AppliedJob) && $AppliedJob!=-1)
            $isSelected = false;

        return ['data' => $allJobs, 'selected' => $isSelected];
    }

    public function getDegrees(Request $request){

        $selectedDegree = $request->get('degree');
        $isSelected = true;

        $degrees = Degree::query()->get(['id', 'degreeTitle'])
                ->map(function($degree) use ($selectedDegree){
                    $selected = (($selectedDegree == $degree->id) && !is_null($selectedDegree) ) ? true : false;
                        return [
                        'id' => $degree->id,
                        'text' => $degree->degreeTitle,
                        "selected" => $selected
                        ];
                    })
                    ->toArray();

        if(!empty($selectedDegree && $selectedDegree!=-1)){
            $isSelected = false;
        }

        return ['data' => $degrees, 'selected' => $isSelected];
    }


    public function storedegree(Request $request){
        $data = $request->validate([
            "title"=>"required", 
        ]);

        $newRecord = new Degree();
        $newRecord->degreeTitle = $data['title']; 
        $newRecord->save();  
        
        session()->flash('success',true);
        return redirect()->back();

    }
    public function storeApplication(Request $request){

        $customValidations = [
            "lastName"=>"required",
            "firstName"=>"required",
            "email"=> ['email:rfc,dns','required'],
            "degree-type"=>"required",
            "job-type"=>"required",  
        ];

        if($request->has('pdfFile')){
            if($request->get('lastName') == null || $request->get('firstName') == null || $request->get('email') == null || $request->get('degree-type') == "-1" || $request->get('job-type') == "-1" ){
                $customValidations['rememberPdf'] =  'required';
            }
        }
        
        $data = $request->validate($customValidations);
        $pdfFile = null;
        
        if($request->hasFile('pdfFile')){
            $pdfFile = $request->file('pdfFile');
        }

        $allJobs = $this->jobApplied;  
        $AppliedJob = $data['job-type'];
        $AppliedJobName = null;

        foreach($allJobs as $key => $job){  
            if($job['id']==$AppliedJob){
                $AppliedJobName = $job['text'];  
            }
        }


        $mobile = null;
        if($request->has('mobile'))
            $mobile = $request->get('mobile');


        $newRecord = new Candidate();
        $newRecord->lastName = $data['lastName'];
        $newRecord->firstName = $data['firstName'];  
        $newRecord->email = $data['email']; 
        $newRecord->mobile = $mobile; 
        $newRecord->degrees_id = $data['degree-type']; 
        $newRecord->resume = $newRecord->saveCV($pdfFile); 
        $newRecord->jobAppliedFor = $AppliedJobName;
        $newRecord->applicationDate = now();
        $newRecord->save();  
        
        session()->flash('success',true);
        return redirect()->back();

    }







    public function editApplication(Request $request,$id){

        $customValidations = [
            "lastName"=>"required",
            "firstName"=>"required",
            "email"=> ['email:rfc,dns','required'],
            "degree-type"=>"required",
            "job-type"=>"required",  
        ];

        if($request->has('pdfFile')){
            if($request->get('lastName') == null || $request->get('firstName') == null || $request->get('email') == null || $request->get('degree-type') == "-1" || $request->get('job-type') == "-1" ){
                $customValidations['rememberPdf'] =  'required';
            }
        }
        
        $data = $request->validate($customValidations);
        $pdfFile = null;
        
        if($request->hasFile('pdfFile')){
            $pdfFile = $request->file('pdfFile');
        }

        $allJobs = $this->jobApplied;  
        $AppliedJob = $data['job-type'];
        $AppliedJobName = null;

        foreach($allJobs as $key => $job){  
            if($job['id']==$AppliedJob){
                $AppliedJobName = $job['text'];  
            }
        }


        $mobile = null;
        if($request->has('mobile'))
            $mobile = $request->get('mobile');


        $updateRecord = Candidate::find($id);
        $updateRecord->lastName = $data['lastName'];
        $updateRecord->firstName = $data['firstName'];  
        $updateRecord->email = $data['email']; 
        $updateRecord->mobile = $mobile; 
        $updateRecord->degrees_id = $data['degree-type']; 
        
        if($pdfFile){
            $updateRecord->deleteCV();
            $updateRecord->resume = $updateRecord->saveCV($pdfFile); 
        }
      
        
        $updateRecord->jobAppliedFor = $AppliedJobName;
        $updateRecord->applicationDate = now();
        $updateRecord->save();  
        
        session()->flash('success',true);
        return redirect()->back();


    } 



    public function applicationDataTables(Request $request){

        $input = $request->input(); 
  
        $draw = $input['draw'];
        $start = $input['start'];
        $rowPerPage = $input['length'];   
        $search = $input['search']['value'];        
        $column = $input['order'][0]['column'];
        $dir = $input['order'][0]['dir'];
        $columnKey = $input['columns'][$column]['data'];
 
        $candidates = Candidate::filterCandidates($search)->orderBy($columnKey,$dir);

        $recordsTotal = $candidates->count();
        $recordsFiltered = $recordsTotal;
        $candidates = $candidates->skip($start)->take($rowPerPage);        
        $candidates = $candidates->get();
        
        $response = array(                
            "draw"=> intval($draw),
            "recordsTotal"=>$recordsTotal,
            "recordsFiltered"=> $recordsFiltered,
            "data"=>$candidates
            );
        
        return  $response; 
    }


    public function applicationDelete($id){

        $candidate = Candidate::find($id);
 
         $candidate->deleteCV();
         $candidate->delete();
 
         return redirect()->back()->with('success','true');
 
     }


    public function showForm(){
        return view('homepage');
    }


    public function ApplicationForm(){
        return view('applicationForm');
    }


    public function degreeForm(){
        return view('degreeForm');
    }

    public function editApplicationForm($id){

        $candidate = Candidate::findOrFail($id); 

        return view('editApplicationForm',compact('candidate'));
    }


    public function deletePdf($id){

            $candidate = Candidate::findOrFail($id);

            if($candidate){
                $candidate->deleteCV();
                $candidate->resume = null;
                $candidate->save();
                return true;
            }else{
                return false;
            }
           

    }
}
