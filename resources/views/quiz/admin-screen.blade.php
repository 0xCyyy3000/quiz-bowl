@extends('layouts.app')

@section('content')
    <h1 class="mt-2 text-center">Bring it on 😎</h1>

    <div class="row me-2 ms-0">
        <div class="col-md-9">
            <div class="row w-75 m-auto" style="margin-top: 2rem !important;">
                <a href="{{ route('quiz.manage') }}" class="mb-3 text-decoration-none text-secondary">⚙️ Manage Questions</a>
                <div class="shadow rounded-4 mb-5 p-5 btn-group btn-group-lg" role="group"
                    aria-label="Basic radio toggle button group">
                    <input type="radio" class="btn-check mode-button" name="btnradio[]" value="1" id="btnEasy"
                        autocomplete="off">
                    <label class="btn btn-outline-primary fs-3 p-5 mx-4" for="btnEasy">Easy</label>

                    <input type="radio" class="btn-check mode-button" name="btnradio[]" value="2" id="btnModerate"
                        autocomplete="off">
                    <label class="btn btn-outline-primary fs-3 p-5 mx-4" for="btnModerate">Moderate</label>

                    <input type="radio" class="btn-check mode-button" name="btnradio[]" value="3" id="btnDifficult"
                        autocomplete="off">
                    <label class="btn btn-outline-primary fs-3 p-5 mx-4" for="btnDifficult">Difficult</label>
                </div>

                <div class="cotainer shadow rounded-4 p-4 mb-3">
                    <div class="row m-auto mb-3">
                        <p id="question-category" class="text-center text-primary fs-5 mb-0">Category</p>
                        <section class="mt-2">
                            <p class="text-center text-break text-muted mb-0">Generated question:</p>
                            <h3 class="text-center text-break fw-semibold fs-2" id="question-here">Please generate a
                                question</h3>
                        </section>
                        <section class="mt-2" id="choice-label">
                            <p class="text-center text-break text-muted mb-0">Choices:</p>
                            <p class="text-center text-break fw-semibold" id="question-choices"></p>
                        </section>
                        <section class="mt-2" id="answer-label">
                            <p class="text-center text-break text-success mb-0">Correct answer:</p>
                            <h4 class="text-center text-break text-success fw-bold" id="the-answer"></h4>
                        </section>
                    </div>
                    <livewire:admin-screen />
                </div>
            </div>
        </div>
        <div class="col-md-3">
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
        </div>
    </div>

    <script>
        $(document).ready(function() {
            let generatedQuestion = null;

            function triggerResult() {
                $.ajax({
                    url: `api/admin/result`,
                    type: "GET",
                    dataType: 'json',
                    success: function(response) {}
                });
            }

            $('#live_preview').click(function() {
                console.log(generatedQuestion);
                $.ajax({
                    url: `/api/setData?action=setLiveQuestion&type=${generatedQuestion.type_id}&mode=${generatedQuestion.mode_id}&id=${generatedQuestion.id}&question=${generatedQuestion.question}&choices=${JSON.stringify(generatedQuestion.choices)}&answer=${generatedQuestion.correct_answer}`,
                    type: "GET",
                    dataType: 'json',
                    success: function(response) {
                        console.log('Question displayed!');
                    }
                });
            });

            $('#see_result').click(function() {
                triggerResult();
            });

            $('.mode-button').click(function() {
                if (!this.checked) {
                    return;
                }
                $.ajax({
                    url: '/api/generate/question?mode=' + this.value,
                    type: 'GET',
                    dataType: 'JSON',
                    success: function(response) {
                        $('#question-here').text(response.question.question);
                        $('#question-category').text(
                            response.categories.find(cat =>
                                cat.id == response.question.category_id).category);
                        generatedQuestion = response.question;

                        if (response.question.type_id == 1) {
                            let choice_template = `
                                <p class='mb-0'>A. ${response.question.choices.a}</p>
                                <p class='mb-0'>B. ${response.question.choices.b}</p>
                                <p class='mb-0'>C. ${response.question.choices.c}</p>
                                <p class='mb-0'>D. ${response.question.choices.d}</p>
                            `;

                            const keys = Object.keys(response.question.choices);
                            $('#choice-label').removeClass('d-none');
                            $('#the-answer').text(
                                response.question.correct_answer.toUpperCase() + '. ' +
                                Object.values(response.question.choices)[keys.indexOf(
                                    response.question.correct_answer.toLowerCase())]
                            );

                            $('#question-choices').html('');
                            $('#question-choices').append(choice_template);
                        } else {
                            $('#the-answer').text(response.question.correct_answer);
                            $('#choice-label').addClass('d-none');
                            $('#question-choices').html('');
                        }
                    }
                });
            });

            setInterval(() => {
                let template = ``;
                $.ajax({
                    url: '/ranking.json',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        response.forEach((element, index) => {
                            let rank = index + 1;
                            if (rank == 1) {
                                rank = '🥇';
                            } else if (rank == 2)
                                rank = '🥈';
                            else if (rank == 3)
                                rank = '🥉';

                            let fontsize = index <= 2 ? 'fs-2' : 'fs-5';

                            template += `
                            <tr>
                                <td class="${fontsize} text-center">${rank}</td>
                                <td class="fs-3 text-center">${element.name}</td>
                                <td class="fs-3 text-center">${element.score} pts</td>
                            </tr>
                            `;
                        });
                        $('#table-ranking').html('');
                        $('#table-ranking').append(template);
                    }
                });
            }, 1000);
        });
    </script>
@endsection
