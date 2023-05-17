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
    </form>

    <script>
        $(document).ready(function() {
            let questionId = null;

            function startTimer(time) {
                const countDown = setInterval(() => {
                    if (time == 0) {
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
                                        <input class="form-check-input" type="radio" name="choices" 
                                        id="inlineRadio${index}" value="${index}">
                                        <label class="form-check-label" for="inlineRadio${index}">${choice}</label>
                                    </div>
                                `;
                            });

                        } else {
                            template += `
                                <div class="form-floating w-75 m-auto">
                                    <input type="text" class="form-control" name="answer" id="floatingInput" placeholder="name@example.com">
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
                        if (response.value != questionId) {
                            questionId = response.value;
                            loadQuestion();
                            console.log('displaying question...');
                        } else {
                            console.log('listening for new question...');
                        }
                    }
                });
            }, 1000);
        });
    </script>
</div>
