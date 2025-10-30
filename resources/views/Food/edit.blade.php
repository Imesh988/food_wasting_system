@extends('layouts.main')

@section('title', 'Customer Edit')

@section('content')

<form action="{{ route('food.update',$food->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    @include( 'food.form',

    [
        'çardTitle'=>'Update Food Details ',
        'btnColor'=>'success',
        'btnText'=>'Update'
    ]

    )
</form>

@endsection
