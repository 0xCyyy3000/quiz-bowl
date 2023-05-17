@extends('layouts.app')

@section('content')
    {{-- {{ $dummy_question }} --}}
    <livewire:admin-screen :question="$dummy_question" />
@endsection
