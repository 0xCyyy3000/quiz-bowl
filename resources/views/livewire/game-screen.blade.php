<div>
    <!-- Button trigger modal -->
    <button type="button" class="btn" id="modalButton" data-bs-toggle="modal" data-bs-target="#staticBackdrop"></button>

    <!-- Modal -->
    <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header border-0">
                    {{-- <h1 class="modal-title fs-5" id="staticBackdropLabel">Modal title</h1> --}}
                    <button type="button" class="btn" id="close-modal" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <h1 class="text-center text-uppercase text-primary"
                        style="font-size: 5rem !important; font-weight:900 !important;" id="modal-title"></h1>
                </div>
                <div class="modal-footer border-0">
                    {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                    {{-- <button type="button" class="btn btn-primary">Understood</button> --}}
                </div>
            </div>
        </div>
    </div>
    <form action="" class="d-none" id="question-container">
        <div class="row m-auto w-75 mb-5" style="margin-top: 12rem !important;">
            <p class="text-center fs-4 text-muted">Time left: <span id="timer"></span> seconds</p>
            <p class="text-break text-center fs-3" id="question"></p>

            <div class="row p-3 w-75 m-auto">
                <div class="d-flex justify-content-between p-2" id="choices-container"></div>
            </div>
        </div>
    </form>

    <div class="container w-50 d-none" id="ranking">
        <h1 class="fw-semibold text-break text-center" id="recap_question" style="margin: 8% auto !important; "></h1>
        <h2 class="text-success text-break text-center" id="show_answer" style="margin: 8% auto !important; "></h2>
        <table class="table m-auto border-2 border-primary border" style="margin: 5% auto !important;">
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

    <script>
        $(document).ready(function() {
            // console.log('{{ Auth::user()->id }}');

            const auth = '{{ Auth::user()->role }}';
            const auth_id = '{{ Auth::user()->asContestant()->id }}';
            const auth_name = '{{ Auth::user()->name }}';

            const COUNTER_KEY = 'quiz-bowl-timer';
            const TIME_UP = 'quiz-time-up';

            let questionId = null,
                rawId = null,
                mode = null;

            const countDownTimer = window.sessionStorage.getItem(COUNTER_KEY);
            countDownTimer ? startTimer(parseInt(countDownTimer)) : null;

            function startTimer(time) {
                const countDown = setInterval(() => {
                    if (time <= 0) {
                        window.sessionStorage.removeItem(COUNTER_KEY);
                        if (auth != 100) {
                            let answer = $('input[name="choices[]"]:checked').val() ?
                                $('input[name="choices[]"]:checked').val() : $('#identification_answer')
                                .val();

                            answer = answer ? answer : 'x_x*;^_^';
                            $.ajax({
                                url: '/api/setData?action=time&answer=' + answer + '&question_id=' +
                                    rawId + '&auth_id=' + auth_id,
                                type: 'GET',
                                dataType: 'json',
                                success: function(response) {}
                            });
                        }

                        $.ajax({
                            url: `api/admin/result?action=read`,
                            type: "GET",
                            dataType: 'json',
                            success: function(response) {
                                $('#navbarSupportedContent').load(' #navbarSupportedContent');
                            }
                        });

                        $('#modalButton').click();
                        clearInterval(countDown);
                    } else {
                        window.sessionStorage.setItem(COUNTER_KEY, time);
                        $('#close-modal').click();
                    }

                    $('#timer').text(time--);

                }, 1000);
            }

            function loadQuestion() {
                $.ajax({
                    url: `/data.json`,
                    type: "GET",
                    dataType: 'json',
                    success: function(response) {
                        $('#recap_question').text(response.question);
                        // 1 = Multiple choice -> render radio buttons
                        // 2 = Identification  -> render input box
                        let template = ``;
                        if (response.type == 1) {
                            const choices = [
                                response.choices.a,
                                response.choices.b,
                                response.choices.c,
                                response.choices.d,
                            ];

                            choices.forEach((choice, index) => {
                                let letter = 'D. ';
                                if (index == 0) {
                                    letter = 'A. ';
                                } else if (index == 1) {
                                    letter = 'B. ';
                                } else {
                                    letter = 'C .';
                                }

                                template += `
                                    <div class="form-check form-check-inline p-1">
                                        <input class="form-check-input" type="radio" name="choices[]" 
                                        id="inlineRadio${index}" value="${index}">
                                        <label class="form-check-label" for="inlineRadio${index}">${letter} ${choice}</label>
                                    </div>
                                `;
                            });

                            const keys = Object.keys(response.choices);
                            $('#show_answer').text(response.answer.toUpperCase() + '. ' +
                                Object.values(response.choices)[keys.indexOf(
                                    response.answer.toLowerCase())] +
                                ' is the correct answer.');

                        } else {
                            template += `
                                <div class="form-floating w-75 m-auto">
                                    <input type="text" class="form-control" name="answer" id="identification_answer" placeholder="name@example.com">
                                    <label for="floatingInput" class="text-muted">Your answer</label>
                                </div>
                            `;

                            $('#show_answer').text(response.answer);
                        }

                        $('#choices-container').html('');
                        $('#choices-container').append(template);

                        $('#question').text(response.question);
                        if (countDownTimer == null) {
                            startTimer(response.timer);
                        }
                    }
                });
            }

            function loadRanking() {
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
                            let highlight = auth != 100 && auth_name == element.name ?
                                '#F5F5DC' : '';


                            template += `
                            <tr style="background: ${highlight}">
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
            }

            setInterval(() => {
                $.ajax({
                    url: '/trigger.json',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        // if (response.value == 'reveal') {
                        //     console.log('revealed!');
                        //     $('#close-modal').click();
                        // } else 
                        if (response.value == 'summary') {
                            $('#question-container').addClass('d-none');
                            $('#ranking').removeClass('d-none');
                            $('#close-modal').click();
                            loadRanking();
                        } else if (response.value == 'time') {
                            $('#modal-title').text("TIME'S UP!");
                            $('#staticBackdrop').modal('show');
                        } else if (response.value != questionId) {
                            $('#question-container').removeClass('d-none');
                            $('#ranking').addClass('d-none');
                            $('#close-modal').click();

                            rawId = response.value.substring(response.value.indexOf('_') +
                                1,
                                response.value.length);

                            questionId = response.value;
                            loadQuestion();
                            // console.log('displaying question...');
                        } else {
                            // console.log('listening for new question...');
                        }
                    }
                });
            }, 1000);

            $('#save_answer').click(function() {
                $.ajax({
                    url: '/api/contestant/save-answer',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        answer: $('input[name="choices[]"]:checked').val() ?
                            $('input[name="choices[]"]:checked').val() : $('#identification_answer')
                            .val(),
                        question_id: rawId
                    },
                    success: function(response) {
                        $('#modal-title').text('ANSWER HAS BEEN SAVED!');
                    }
                });
            });
        });
    </script>
</div>
