@extends('layout.layout')

@section('header')
    @include('header')
@endsection

@section('body')
    

            <div class="container">

                    <div class="row justify-content-md-center mt-5">
                                <div class="col-sm-4 col-4">
                                    <form action="{{route('store.degree')}}" method="post" enctype="multipart/form-data" >
                                    @csrf 
                                        <div class="mb-3">
                                            <label for="degree-title" class="form-label">degree title</label>
                                            <input type="text" class="form-control" id="degree-title" name="title" aria-describedby="degree-title"> 
                                        </div> 
                                        @if($errors->has('title'))
                                            <div id="validationServer03Feedback" class="invalid-feedback d-block">
                                                Field is empty!
                                            </div>
                                        @endif
                                        @if(Session::has('success'))
                                            <div class="alert alert-success mt-3" role="alert">
                                                Degree title is saved!
                                            </div>
                                        @endif
                                        <button type="submit" class="btn btn-primary">Submit</button>
                                    </form>
                                </div>
                        </div>
            </div>

@endsection