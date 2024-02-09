<?php

namespace App\Http\Livewire;

use App\Models\posgres_db\srgb\srgb_semsubject;
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

final class srgb_semsubject_powergrid extends PowerGridComponent
{
    use ActionButton;

    //Messages informing success/error data is updated.
    public bool $showUpdateMessages = true;

    /*
    |--------------------------------------------------------------------------
    |  Features Setup
    |--------------------------------------------------------------------------
    | Setup Table's general features
    |
    */
    public function setUp(): void
    {
        $this->showCheckBox()
            ->showPerPage()
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
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\posgres_db\srgb\srgb_semsubject>|null
    */
    public string $primaryKey = 'oid';
    public string $sortField = 'oid';
    public function datasource(): ?Builder
    {
        return srgb_semsubject::query();
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
        ->addColumn('sy')
        ->addColumn('sem')
        ->addColumn('subjcode')
        ->addColumn('section')
        ->addColumn('subjsecno')
        ->addColumn('days')
        ->addColumn('time')
        ->addColumn('room')
        ->addColumn('bldg')
        ->addColumn('block')
        ->addColumn('maxstud')
        ->addColumn('facultyid')
        ->addColumn('forcoll')
        ->addColumn('fordept')
        ->addColumn('lock')
        ->addColumn('tuitionfee')
        ->addColumn('lockgraduating')
        ->addColumn('offertype')
        ->addColumn('semsubject_id')
        ->addColumn('editable')
        ->addColumn('fused_lec_to');
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
        return [
            Column::add()
                ->title('sy')
                ->field('sy')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('sem')
                ->field('sem')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('subjcode')
                ->field('subjcode')
                ->sortable()
                ->searchable()
                ->editOnClick(),

            Column::add()
                ->title('section')
                ->field('section')
                ->sortable()
                ->searchable(),
                // ->makeInputText(),

            Column::add()
                ->title('subjsecno')
                ->field('subjsecno')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('days')
                ->field('days')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('time')
                ->field('time')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('room')
                ->field('room')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('bldg')
                ->field('bldg')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('block')
                ->field('block')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('maxstud')
                ->field('maxstud')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('facultyid')
                ->field('facultyid')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('forcoll')
                ->field('forcoll')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('fordept')
                ->field('fordept')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('lock')
                ->field('lock')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('facultyload')
                ->field('facultyload')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('tuitionfee')
                ->field('tuitionfee')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('lockgraduating')
                ->field('lockgraduating')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('offertype')
                ->field('offertype')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('semsubject_id')
                ->field('semsubject_id')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('editable')
                ->field('editable')
                ->sortable()
                ->searchable(),

            Column::add()
                ->title('fused_lec_to')
                ->field('fused_lec_to')
                ->sortable()
                ->searchable(),

        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Actions Method
    |--------------------------------------------------------------------------
    | Enable the method below only if the Routes below are defined in your app.
    |
    */

     /**
     * PowerGrid srgb_semsubject Action Buttons.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Button>
     */

    /*
    public function actions(): array
    {
       return [
           Button::add('edit')
               ->caption('Edit')
               ->class('bg-indigo-500 cursor-pointer text-white px-3 py-2.5 m-1 rounded text-sm')
               ->route('srgb_semsubject.edit', ['srgb_semsubject' => 'id']),

           Button::add('destroy')
               ->caption('Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('srgb_semsubject.destroy', ['srgb_semsubject' => 'id'])
               ->method('delete')
        ];
    }
    */

    /*
    |--------------------------------------------------------------------------
    | Actions Rules
    |--------------------------------------------------------------------------
    | Enable the method below to configure Rules for your Table and Action Buttons.
    |
    */

     /**
     * PowerGrid srgb_semsubject Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($srgb_semsubject) => $srgb_semsubject->id === 1)
                ->hide(),
        ];
    }
    */

    /*
    |--------------------------------------------------------------------------
    | Edit Method
    |--------------------------------------------------------------------------
    | Enable the method below to use editOnClick() or toggleable() methods.
    | Data must be validated and treated (see "Update Data" in PowerGrid doc).
    |
    */

     /**
     * PowerGrid srgb_semsubject Update.
     *
     * @param array<string,string> $data
     */


    public function update(array $data ): bool
    {
       try {
           $updated = srgb_semsubject::query()->findOrFail($data['id'])
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
