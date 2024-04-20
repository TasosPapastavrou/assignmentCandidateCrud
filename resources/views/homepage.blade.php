@extends('layout.layout')

@section('header')
    @include('header')
@endsection

@section('body')
    

            <div class="container">

                    <div class="row justify-content-md-center">

                        <div class="col-sm-8">
                            <div class="row justify-content-between m-3">
                                <div class="col-4">
                                    <a href="{{route('form.candidate')}}"><button type="button" class="btn btn-primary">add candidate</button></a>
                                </div>
                                <div class="col-4">
                                    <a href="{{route('form.degree')}}"><button type="button" class="btn btn-primary">add degree</button></a>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-5">
                                <div class="col-sm-12">
                                    <table id="candidate-table" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>lastName</th>
                                                <th>firstName</th>
                                                <th>email</th>
                                                <th>mobile</th> 
                                                <th>job</th> 
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                        </div>

                    </div>
            </div>

@endsection