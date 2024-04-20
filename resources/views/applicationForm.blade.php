@extends('layout.layout')

@section('header')
    @include('header')
@endsection

@section('body')


@php

$degreeType = 0; 
$jobType = 0; 
$lastname = "";
$firstName = "";
$email = "";
$mobile = "";
$havePdf = false;


if(old('degree-type'))
    $degreeType = old('degree-type');  

if(old('job-type'))
    $jobType = old('job-type'); 


if(old('lastName'))
    $lastname = old('lastName'); 

if(old('firstName'))
    $firstName = old('firstName'); 

if(old('email'))
    $email = old('email');   

if(old('mobile'))
    $mobile = old('mobile');   


@endphp

<div class="container">

    <div class="row justify-content-md-center mt-5">

            <div class="col-sm-12 col-12 col-md-4 col-xl-8">
                <form action="{{route('store.application')}}" method="post" enctype="multipart/form-data" >
                    @csrf 

                    <div class="mb-3">
                        <label for="lastName" class="form-label">lastName</label>
                        <input type="text" class="form-control" id="lastName" name="lastName" aria-describedby="lastName" value="{{$lastname}}" > 
                    </div> 
                    @if($errors->has('lastName'))
                        <div id="validationServer03Feedback" class="invalid-feedback d-block">
                            Field is empty!
                        </div>
                    @endif



                    <div class="mb-3">
                        <label for="firstName" class="form-label">firstName</label>
                        <input type="text" class="form-control" id="firstName" name="firstName" aria-describedby="firstName" value="{{ $firstName }}" > 
                    </div> 
                    @if($errors->has('firstName'))
                        <div id="validationServer03Feedback" class="invalid-feedback d-block">
                            Field is empty!
                        </div>
                    @endif




                    <div class="mb-3">
                        <label for="email" class="form-label">email</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="email" value="{{ $email }}" > 
                    </div> 
                    @if($errors->has('email'))
                        <div id="validationServer03Feedback" class="invalid-feedback d-block">
                            Field is empty Or the email not exists!
                        </div>
                    @endif




                    <div class="mb-3">
                        <label for="mobile" class="form-label">mobile</label>
                        <input type="text" class="form-control" id="mobile" name="mobile" pattern="\d{10}" aria-describedby="mobile" value="{{ $mobile }}" > 
                    </div> 
                    @if($errors->has('mobile'))
                        <div id="validationServer03Feedback" class="invalid-feedback d-block">
                            Field is empty or digits is not 10!
                        </div>
                    @endif




                    <div class="form-group">
                                <label for="degree-type" class="login-form-labels p-2">degree</label>                                
                                <select class="degree--types" name="degree-type" id="degree-type"> <!-- form-control --> </select>   
                                                             
                                @if($errors->has('degree-type') || old('degree-type')==-1)
                                    <div id="validationServer03Feedback" class="invalid-feedback d-block">
                                        Field is empty!
                                    </div>  
                                @endif

                                <input id="oldDegreeType" type="hidden" name="oldDegreeType" value="{{ $degreeType }}">
                    </div>




                    <div class="form-group">
                                <label for="url" class="login-form-labels p-2">resume</label>
                                <div class="row">
                                    <input type="file" name="pdfFile" accept=".pdf">
                                </div>
                                @if($errors->has('rememberPdf')) 
                                        <div class="alert alert-warning mt-2" role="alert">
                                            Insert again the pdf!
                                        </div>      
                                @endif
                                <input id="rememberPdf" type="hidden" name="rememberPdf">
                            </div>



                    <div class="form-group">
                                <label for="job-type" class="login-form-labels p-2">job</label>                                
                                <select class="job--types" name="job-type" id="job-type"> <!-- form-control --> </select>   
                                                             
                                @if($errors->has('job-type') || old('job-type')==-1)
                                    <div id="validationServer03Feedback" class="invalid-feedback d-block">
                                        Field is empty!
                                    </div>  
                                @endif

                                <input id="oldJobType" type="hidden" name="oldJobType" value="{{ $jobType }}">
                    </div>







                    @if(Session::has('success'))
                        <div class="alert alert-success mt-3" role="alert">
                            Application is saved!
                        </div>
                    @endif

                    

                    <div class="d-flex justify-content-center mt-5">
                        <button type="submit" class="btn btn-primary mt-5">Submit</button>
                    </div>

                </form>
            </div>
    </div>
</div>

@endsection