<?php

namespace App\Http\Livewire;

use App\Models\Question;
use App\Models\QuestionType;
use Illuminate\Database\Eloquent\Builder;
use Rappasoft\LaravelLivewireTables\Views\Column;
use Rappasoft\LaravelLivewireTables\DataTableComponent;
use Rappasoft\LaravelLivewireTables\Views\Columns\ButtonGroupColumn;
use Rappasoft\LaravelLivewireTables\Views\Columns\LinkColumn;

class QuestionTable extends DataTableComponent
{
    protected $model = Question::class;

    public function builder(): Builder
    {
        return Question::query();
    }

    public function configure(): void
    {
        $this->setPrimaryKey('id');
        $this->setSingleSortingDisabled();
        $this->setDefaultSort('id', 'desc');
    }

    public function columns(): array
    {
        return [
            Column::make("ID", "id")
                ->sortable(),
            Column::make("STATUS", "status")
                ->sortable()
                ->format(
                    fn ($value, $row, Column $column) =>
                    $row->status == 1 ? 'Active 🟢' : 'Inactive 🔴'
                ),
            Column::make("CATEGORY", "category.category")
                ->sortable()
                ->searchable(),
            Column::make("MODE", "mode.mode")
                ->sortable()
                ->searchable(),
            Column::make("TYPE", "type.type")
                ->sortable()
                ->searchable(),
            Column::make("QUESTION", "question")
                ->sortable()
                ->searchable(),
            ButtonGroupColumn::make('Actions')
                ->attributes(function ($row) {
                    return [
                        'class' => 'space-x-2',
                    ];
                })
                ->buttons([
                    LinkColumn::make('View') // make() has no effect in this case but needs to be set anyway
                        ->title(fn ($row) => 'See details')
                        ->location(fn ($row) => route('quiz.select', $row))
                ]),
        ];
    }
}
