@extends('layouts.app')

@section('content')
    <h1 class="mt-2 text-center">Manage Questions 🖊️</h1>

    <div class="row me-2 ms-0">
        <div class="col-md-12">
            <div class="row w-75 m-auto" style="margin-top: 2rem !important;">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <a href="{{ route('quiz.home') }}" class="fs-4 mb-3 text-decoration-none text-secondary">🏠 Home</a>
                    <a href="{{ route('quiz.create') }}" class="btn btn-success">Create question</a>
                </div>
                <livewire:question-table />
            </div>
        </div>
        {{-- <div class="col-md-3">
            <p class="fs-4 mb-2">Leaderboard</p>
            <table class="table border-2 border-primary border">
                <thead>
                    <tr class="bg-primary">
                        <th class="text-center text-white">Rank</th>
                        <th class="text-center text-white">Team</th>
                        <th class="text-center text-white">Score</th>
                    </tr>
                </thead>
                <tbody id="table-ranking"></tbody>
            </table>
        </div> --}}
    </div>
@endsection
