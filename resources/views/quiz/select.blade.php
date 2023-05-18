@extends('layouts.app')

@section('content')
    <h1 class="mt-2 text-center">Manage Questions 🖊️</h1>

    <div class="row me-2 ms-0">
        <div class="col-md-12">
            <div class="row w-75 m-auto shadow-lg rounded-4 p-4" style="margin-top: 2rem !important;">
                <a href="{{ route('quiz.home') }}" class="mb-3 text-decoration-none text-secondary">🏠 Home</a>
                <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '>';">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ route('quiz.manage') }}">Manage Questions</a></li>
                        <li class="breadcrumb-item active" aria-current="page">Question ID #{{ $question->id }}</li>
                    </ol>
                </nav>
                <div class="row">
                    <form class="row g-3" method="POST"
                        action="{{ route('quiz.select.update', ['id' => $question->id]) }}">
                        @csrf
                        <div class="col-md-12">
                            <div class="col-md-3">
                                <label for="">Status: </label>
                                <select class="form-select" name="status">
                                    <option @selected($question->status == 1) value="1">Active 🟢</option>
                                    <option @selected($question->status == 0) value="0">Inactive 🔴</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="question_category" class="form-label">Category</label>
                            <select class="form-select @error('category') @enderror" name="category" id="question_category">
                                @foreach ($categories as $category)
                                    <option @selected($question->category_id == $category->id) value="{{ $category->id }}">
                                        {{ $category->category }}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="invalid-feedback">
                                    Please select a category
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="question_mode" class="form-label">Mode</label>
                            <select class="form-select @error('mode') @enderror" name="mode" id="question_mode">
                                @foreach ($modes as $mode)
                                    <option @selected($question->mode_id == $mode->id) value="{{ $mode->id }}">
                                        {{ $mode->mode }}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="invalid-feedback">
                                    Please select a mode
                                </div>
                            @enderror
                        </div>
                        <div class="col-md-6">
                            <label for="question_type" class="form-label">Question type</label>
                            <select class="form-select @error('type') @enderror" name="type" id="question_type">
                                @foreach ($types as $type)
                                    <option @selected($question->type_id == $type->id) value="{{ $type->id }}">
                                        {{ $type->type }}</option>
                                @endforeach
                            </select>
                            @error('category')
                                <div class="invalid-feedback">
                                    Please select a question type
                                </div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label for="question_itself" class="form-label">Question</label>
                            <input type="text" class="form-control @error('question') @enderror" name="question"
                                id="question_itself" placeholder="Question here" value="{{ $question->question }}">
                            @error('question')
                                <div class="invalid-feedback">
                                    Question is required
                                </div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <div class="mul-choices @if ($question->type_id != 1) d-none @endif">
                                <label for="question_answer" class="form-label">Choices</label>
                                @php
                                    $choices = ['a', 'b', 'c', 'd'];
                                    $given_choices = [];
                                    $choice_index = 0;
                                    $answer = null;
                                @endphp
                                <div class="row">
                                    <div class="btn-group d-block mb-2 @error('choices') @enderror" role="group"
                                        aria-label="Basic radio toggle button group">
                                        @foreach (json_decode($question->choices) as $choice)
                                            <div class="d-flex align-items-center gap-3 w-50 ms-3 mb-2">
                                                <label class="form-label"
                                                    for="">{{ strtoupper($choices[$choice_index]) }}</label>
                                                <input type="text" class="form-control" name="choices[]"
                                                    value="{{ $choice }}">
                                            </div>
                                            @php
                                                $choice_index++;
                                            @endphp
                                        @endforeach
                                    </div>
                                    @error('choices')
                                        <div class="invalide-feedback">
                                            Choices are required
                                        </div>
                                    @enderror
                                    <div class="col-6">
                                        <label for="question_answer" class="form-label">Correct answer</label>
                                        <select class="form-select @error('correct_answer') @enderror"
                                            name="mul_correct_answer" id="">
                                            @php
                                                $choice_index = 0;
                                            @endphp
                                            @foreach (json_decode($question->choices) as $choice)
                                                <option @selected(strtoupper($choices[$choice_index]) == strtoupper($question->correct_answer))
                                                    value="{{ strtoupper($choices[$choice_index]) }}">
                                                    {{ strtoupper($choices[$choice_index]) . '. ' . $choice }}</option>
                                                @php
                                                    $choice_index++;
                                                @endphp
                                            @endforeach
                                        </select>
                                        @error('correct_answer')
                                            <div class="invalid-feedback">
                                                Answer is required
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="not-mul-choices @if ($question->type_id == 1) d-none @endif">
                                <label for="question_answer" class="form-label">Correct answer</label>
                                <input type="text" class="form-control @error('correct_answer') @enderror"
                                    id="question_answer" name="correct_answer" placeholder="Question here"
                                    value="{{ $question->correct_answer ? $question->correct_answer : '' }}">
                                @error('correct_answer')
                                    <div class="invalid-feedback">
                                        Answer is required
                                    </div>
                                @enderror
                            </div>

                        </div>
                        <div class="col-12">
                            <div class="float-end d-flex justify-content-between gap-4 p-3 align-items-center">
                                <a href="{{ route('quiz.manage') }}"
                                    class="btn btn-link text-decoration-none text-secondary">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">Submit changes</button>
                            </div>
                        </div>
                    </form>
                </div>

                <script>
                    $(document).ready(function() {
                        $('#question_type').change(function() {
                            console.log(this.value);
                            if (this.value != 1 && this.value <= 3) {
                                $('.not-mul-choices').removeClass('d-none');
                                $('.mul-choices').addClass('d-none');
                            } else if (this.value == 1) {
                                $('.not-mul-choices').addClass('d-none');
                                $('.mul-choices').removeClass('d-none');
                            }
                        });
                    });
                </script>
            </div>
        </div>
    </div>
@endsection
