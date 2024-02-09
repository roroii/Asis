<?php

namespace App\Http\Livewire;

use App\Models\faculty_monitoring\fm_class_schedule;
use Auth;
use Illuminate\Support\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Database\Eloquent\Builder;
use PowerComponents\LivewirePowerGrid\Button;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\Traits\ActionButton;
use PowerComponents\LivewirePowerGrid\Rules\Rule;

final class monitoring_schedule_livewire extends PowerGridComponent
{
    use ActionButton;

    //Messages informing success/error data is updated.
    // public bool $showUpdateMessages = true;

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): void
    {
        $this
        ->showCheckBox()
        ->showPerPage()
        ->showToggleColumns()
        ->showRecordCount('full')
        ->showSearchInput()
        ->showExportOption('download', ['excel', 'csv']);
    }

    /*
    |--------------------------------------------------------------------------
    |  Datasource
    |--------------------------------------------------------------------------
    | Provides data to your Table using a Model or Collection
    |
    */

    /**
    * PowerGrid datasource.
    *
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\faculty_monitoring\fm_class_schedule>|null
    */
    public function datasource(): ?Builder
    {
        return fm_class_schedule::query()->where('created_by',Auth::user()->employee);
    }

    /*
    |--------------------------------------------------------------------------
    |  Relationship Search
    |--------------------------------------------------------------------------
    | Configure here relationships to be used by the Search and Table Filters.
    |
    */

    /**
     * Relationship search.
     *
     * @return array<string, array<int, string>>
     */
    public function relationSearch(): array
    {
        return [];
    }

    /*
    |--------------------------------------------------------------------------
    |  Add Column
    |--------------------------------------------------------------------------
    | Make Datasource fields available to be used as columns.
    | You can pass a closure to transform/modify the data.
    |
    */
    public function addColumns(): ?PowerGridEloquent
    {
        return PowerGrid::eloquent()
            ->addColumn('id')
            ->addColumn('agency_id')
            ->addColumn('subject_name')
            ->addColumn('subject_code')
            ->addColumn('type')
            ->addColumn('days')
            ->addColumn('date_time')
            ->addColumn('complete')
            ->addColumn('status')
            ->addColumn('active')
            ->addColumn('created_by')
            ->addColumn('created_at')
            ->addColumn('updated_at');
    }

    /*
    |--------------------------------------------------------------------------
    |  Include Columns
    |--------------------------------------------------------------------------
    | Include the columns added columns, making them visible on the Table.
    | Each column can be configured with properties, filters, actions...
    |
    */

     /**
     * PowerGrid Columns.
     *
     * @return array<int, Column>
     */
    public function columns(): array
    {
        $canEdit = true;
        $canCopy = true;

        return [
            Column::add()
                ->title('ID')
                ->field('id')
                ->makeInputRange(),

            Column::add()
                ->title('AGENCY ID')
                ->field('agency_id')
                ->sortable()
                ->searchable()
                ->makeInputText(),

                Column::add()
                ->title('SUBJECT NAME')
                ->field('subject_name')
                ->sortable()
                ->searchable()
                ->editOnClick(),
                // ->toggleable($canEdit, 'yes', 'no')
                // ->clickToCopy($canCopy, 'Copy name to clipboard'),


            Column::add()
                ->title('SUBJECT CODE')
                ->field('subject_code')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('TYPE')
                ->field('type')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('DAYS')
                ->field('days')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('DATE TIME')
                ->field('date_time')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('COMPLETE')
                ->field('complete')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('STATUS')
                ->field('status')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('ACTIVE')
                ->field('active')
                ->sortable()
                ->searchable()
                ->makeInputText(),
                // ->toggleable($canEdit, 'yes', 'no'),

            Column::add()
                ->title('CREATED BY')
                ->field('created_by')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('CREATED AT')
                ->field('created_at')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('UPDATED AT')
                ->field('updated_at')
                ->sortable()
                ->searchable()
                ->makeInputText(),

        ]
;
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

     /**
     * PowerGrid fm_class_schedule Action Buttons.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */


    public function actions(): array
    {
        $canClickButton = true;
        return [
            Button::add('edit')
                ->caption('<i class="icofont-edit text-success"></i>')
                ->tooltip('Edit')
                ->class('w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400 text-slate-400 zoom-in tooltip')
                ->route('rc', ['fm_class_schedule' => 'id'])
                ->can($canClickButton),

            Button::add('destroy')
                ->caption('<i class="icofont-trash text-danger"></i>')
                ->tooltip('Delete')
                ->class('w-8 h-8 rounded-full flex items-center justify-center border dark:border-darkmode-400text-slate-400 zoom-in tooltip')
                ->route('rc', ['fm_class_schedule' => 'id'])
                ->method('delete')
                ->can($canClickButton)
         ];
    }


    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

     /**
     * PowerGrid fm_class_schedule Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */


    public function actionRules(): array
    {
        return [

            //Hide button edit for ID 1
            //  Rule::button('edit')
            //      ->when(fn($fm_class_schedule) => $fm_class_schedule->id === 1)
            //      ->hide(),

             Rule::rows()
                 ->when(function ($fm_class_schedule) {
                    //  return $fm_class_schedule->price > 0 && $dish->in_stock == false;
                     return $fm_class_schedule->active == 0 ;
                 })
                 ->setAttribute('class', 'bg-red-200'),
         ];
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Method
    |--------------------------------------------------------------------------
    | Enable the method below to use editOnClick() or toggleable() methods.
    | Data must be validated and treated (see "Update Data" in PowerGrid doc).
    |
    */

     /**
     * PowerGrid fm_class_schedule Update.
     *
     * @param array<string,string> $data
     */


    public function update(array $data ): bool
    {
       try {
           $updated = fm_class_schedule::query()->findOrFail($data['id'])
                ->update([
                    $data['field'] => $data['value'],
                ]);
       } catch (QueryException $exception) {
           $updated = false;
       }
       return $updated;
    }

    public function updateMessages(string $status = 'error', string $field = '_default_message'): string
    {
        $updateMessages = [
            'success'   => [
                '_default_message' => __('Data has been updated successfully!'),
                //'custom_field'   => __('Custom Field updated successfully!'),
            ],
            'error' => [
                '_default_message' => __('Error updating the data.'),
                //'custom_field'   => __('Error updating custom field.'),
            ]
        ];

        $message = ($updateMessages[$status][$field] ?? $updateMessages[$status]['_default_message']);

        return (is_string($message)) ? $message : 'Error!';
    }

}