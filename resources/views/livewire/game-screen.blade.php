<div>
    <form action="">
        <div class="row m-auto w-75 mb-5" style="margin-top: 12rem !important;">
            <p class="text-center fs-4 text-muted">Time left: <span id="timer"></span> seconds</p>
            <p class="text-break text-center fs-3" id="question"></p>

            <div class="row p-3 w-75 m-auto">
                <div class="d-flex justify-content-between p-2" id="choices-container"></div>
            </div>
        </div>

        @auth
            <div class="row w-50 m-auto mt-5">
                <button type="button" id="show_answer" class="btn btn-outline-primary m-auto" style="width: 8rem">
                    Show Answer</button>
            </div>
        @else
            <div class="row w-50 m-auto mt-5">
                <button type="button" id="save_answer" class="btn btn-outline-primary m-auto" style="width: 8rem">
                    Save Answer</button>
            </div>
        @endauth

        <!-- Button trigger modal -->
        <button type="button" class="btn" id="modalButton" data-bs-toggle="modal"
            data-bs-target="#staticBackdrop"></button>

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
                            style="font-size: 5rem !important; font-weight:900 !important;">
                            Times up!</h1>
                    </div>
                    <div class="modal-footer border-0">
                        {{-- <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button> --}}
                        {{-- <button type="button" class="btn btn-primary">Understood</button> --}}
                    </div>
                </div>
            </div>
        </div>
    </form>

    <div class="container w-50 m-auto">
        <table class="table m-auto">
            <thead>
                <tr class="bg-secondary">
                    <th class="text-center text-white">Rank</th>
                    <th class="text-center text-white">Group</th>
                    <th class="text-center text-white">Score</th>
                </tr>
            </thead>
            <tbody>
                <tr class="bg-warning">
                    <td class="fs-3 text-center">1</td>
                    <td class="fs-3 text-center">Mark</td>
                    <td class="fs-3 text-center">3 pts</td>
                </tr>
                <tr class="bg-light">
                    <td class="fs-3 text-center">2</td>
                    <td class="fs-3 text-center">Jacob</td>
                    <td class="fs-3 text-center">3 pts</td>
                </tr>
                <tr class="">
                    <td class="fs-3 text-center">3</td>
                    <td class="fs-3 text-center">Larry the Bird</td>
                    <td class="fs-3 text-center">3 pts</td>
                </tr>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            let questionId = null,
                rawId = null,
                mode = null;

            function startTimer(time) {
                const countDown = setInterval(() => {
                    if (time == 0) {
                        $('#modalButton').click();
                        clearInterval(countDown);
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
                                template += `
                                    <div class="form-check form-check-inline p-1">
                                        <input class="form-check-input" type="radio" name="choices[]" 
                                        id="inlineRadio${index}" value="${index}">
                                        <label class="form-check-label" for="inlineRadio${index}">${choice}</label>
                                    </div>
                                `;
                            });

                        } else {
                            template += `
                                <div class="form-floating w-75 m-auto">
                                    <input type="text" class="form-control" name="answer" id="identification_answer" placeholder="name@example.com">
                                    <label for="floatingInput" class="text-muted">Your answer</label>
                                </div>
                            `;
                        }

                        $('#choices-container').html('');
                        $('#choices-container').append(template);

                        $('#question').text(response.question);
                        $('#timer').text(response.timer)

                        startTimer(response.timer);
                    }
                });
            }
            setInterval(() => {
                $.ajax({
                    url: '/trigger.json',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.value == 'reveal') {
                            console.log('revealed!');
                            $('#close-modal').click();
                        } else if (response.value != questionId) {
                            rawId = response.value.substring(response.value.indexOf('_') + 1,
                                response.value.length);

                            questionId = response.value;
                            loadQuestion();
                            console.log('displaying question...');
                        } else {
                            console.log('listening for new question...');
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

                    }
                });
            });
        });
    </script>
</div>
