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
                        <li class="breadcrumb-item active" aria-current="page">Question ID #{{ $id }}</li>
                    </ol>
                </nav>
                <div class="row">
                    @if ($errors->any())
                        {!! implode('', $errors->all('<div class="text-danger">:message</div>')) !!}
                    @endif
                    <form class="row g-3" method="POST" action="{{ route('quiz.store') }}">
                        @csrf
                        {{-- <label for="">Status: {{ $question->status == 1 ? 'Active 🟢' : 'Inactive 🔴' }}</label> --}}
                        <div class="col-md-6">
                            <label for="question_category" class="form-label">Category</label>
                            <select class="form-select  " name="category" id="question_category">
                                <option value="">Select category</option>
                                @foreach ($categories as $category)
                                    <option @selected($category->id == old('category')) value="{{ $category->id }}">
                                        {{ $category->category }}</option>
                                @endforeach
                            </select>



                        </div>
                        <div class="col-md-6">
                            <label for="question_mode" class="form-label">Mode</label>
                            <select class="form-select  " name="mode" id="question_mode">
                                <option value="">Select mode</option>
                                @foreach ($modes as $mode)
                                    <option @selected($mode->id == old('mode')) value="{{ $mode->id }}">
                                        {{ $mode->mode }}</option>
                                @endforeach
                            </select>



                        </div>
                        <div class="col-md-6">
                            <label for="question_type" class="form-label">Question type</label>
                            <select class="form-select  " name="type" id="question_type">
                                <option value="">Select question type</option>
                                @foreach ($types as $type)
                                    <option @selected($type->id == old('type')) value="{{ $type->id }}">
                                        {{ $type->type }}</option>
                                @endforeach
                            </select>



                        </div>
                        <div class="col-12">
                            <label for="question_itself" class="form-label">Question</label>
                            <input type="text" class="form-control  " name="question" id="question_itself"
                                placeholder="Question here" value="{{ old('question') }}">



                        </div>
                        <div class="col-12">
                            <div class="mul-choices  d-none ">
                                <label for="question_answer" class="form-label">Choices</label>
                                @php
                                    $choices = ['a', 'b', 'c', 'd'];
                                    $given_choices = [];
                                    $choice_index = 0;
                                    $answer = null;
                                @endphp
                                <div class="row">
                                    <div class="btn-group d-block mb-2  " role="group"
                                        aria-label="Basic radio toggle button group">
                                        <div class="d-flex align-items-center gap-3 w-50 ms-3 mb-2">
                                            <label class="form-label" for="">A</label>
                                            <input type="text" class="form-control" name="choices[]" value=""
                                                placeholder="Choice">
                                        </div>
                                        <div class="d-flex align-items-center gap-3 w-50 ms-3 mb-2">
                                            <label class="form-label" for="">B</label>
                                            <input type="text" class="form-control" name="choices[]" value=""
                                                placeholder="Choice">
                                        </div>
                                        <div class="d-flex align-items-center gap-3 w-50 ms-3 mb-2">
                                            <label class="form-label" for="">C</label>
                                            <input type="text" class="form-control" name="choices[]" value=""
                                                placeholder="Choice">
                                        </div>
                                        <div class="d-flex align-items-center gap-3 w-50 ms-3 mb-2">
                                            <label class="form-label" for="">D</label>
                                            <input type="text" class="form-control" name="choices[]" value=""
                                                placeholder="Choice">
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <label for="question_answer" class="form-label">Correct answer</label>
                                        <select class="form-select" name="mul_correct_answer" id="">
                                            <option value="A">A</option>
                                            <option value="B">B</option>
                                            <option value="C">C</option>
                                            <option value="D">D</option>
                                        </select>



                                    </div>
                                </div>
                            </div>

                            <div class="not-mul-choices ">
                                <label for="question_answer" class="form-label">Correct answer</label>
                                <input type="text" class="form-control  " id="question_answer" name="correct_answer"
                                    placeholder="Correct answer here" value="{{ old('correct_answer') }}">
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
