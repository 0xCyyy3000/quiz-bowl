<div class="row">
    <div class="col">Hi</div>
    <div class="col">Hello</div>
    <div class="col">Shesh</div>
    <h2 class="text-center">
        {{ $question }}
    </h2>
    <button class="btn btn-outline-primary" wire:click="$emit('showQuestion', {{ $question }})"
        id="display_question">Display Question</button>

    <script>
        $(document).ready(function() {
            Livewire.on('showQuestion', question => {
                $.ajax({
                    url: `/setData.php?action=setLiveQuestion&type=${question.question_type}&mode=${question.mode}&id=${question.id}&question=${question.question}&choices=${question.choices}&timer=30`,
                    type: "GET",
                    dataType: 'json',
                    success: function(response) {
                        console.log('Question displayed!');
                    }
                });
            });
        });
    </script>
</div>
