<div class="row">
    <div class="col">Hi</div>
    <div class="col">Hello</div>
    <div class="col">Shesh</div>
    <h2 class="text-center">
        {{ $question }}
    </h2>
    <button class="btn btn-outline-primary mb-2" wire:click="$emit('showQuestion', {{ $question }})"
        id="display_question">Display question</button>

    <button class="btn btn-outline-secondary" wire:click="$emit('showResult', {{ $question }})" id="see_result">
        See result</button>

    <script>
        $(document).ready(function() {
            Livewire.on('showQuestion', question => {
                $.ajax({
                    url: `/setData.php?action=setLiveQuestion&type=${question.question_type}&mode=${question.mode}&id=${question.id}&question=${question.question}&choices=${question.choices}&answer=${question.correct_answer}`,
                    type: "GET",
                    dataType: 'json',
                    success: function(response) {
                        console.log('Question displayed!');
                    }
                });
            });

            Livewire.on('showResult', question => {
                $.ajax({
                    url: `/setData.php?action=seeResult&question=${question.id}`,
                    type: "GET",
                    dataType: 'json',
                    success: function(response) {
                        console.log('Result has been revealed!');
                    }
                });

                $.ajax({
                    url: `api/admin/result`,
                    type: "GET",
                    dataType: 'json',
                    success: function(response) {
                        const summary = response.summary.sort((a, b) => b.score - a.score);
                        console.log(summary);
                    }
                });
            });
        });
    </script>
</div>
