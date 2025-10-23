@extends('layouts.main')

@section('title', 'Customer Create')

@section('content')

<form action="{{ route('food.store') }}" method="post" enctype="multipart/form-data">
    @csrf
    @include( 'food.form',

    [
        'çardTitle'=>'Add Food Details ',
        'btnColor'=>'success',
        'btnText'=>'Save'
    ]

    )
</form>

@endsection


