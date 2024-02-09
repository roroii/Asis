<?php

namespace App\Http\Livewire;

use App\Models\posgres_db\pis\pis_employee;
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

final class pg_pis_employee_powergrid extends PowerGridComponent
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
    * @return  \Illuminate\Database\Eloquent\Builder<\App\Models\posgres_db\pis\pis_employee>|null
    */

    public string $primaryKey = 'oid';
    public string $sortField = 'oid';

    public function datasource(): ?Builder
    {
        return pis_employee::query();
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
        ->addColumn('oid')
        ->addColumn('empid')
        ->addColumn('fullname')
        ->addColumn('birthdate')
        ->addColumn('payccno')
        ->addColumn('currentrank')
        ->addColumn('lastname')
        ->addColumn('firstname')
        ->addColumn('middlename')
        ->addColumn('suffix')
        ->addColumn('deptcode')
        ->addColumn('email');
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
                ->title('ID')
                ->field('empid')
                ->makeInputRange(),

            Column::add()
                ->title('Name')
                ->field('fullname')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('Birthdate')
                ->field('birthdate')
                ->sortable()
                ->searchable()
                ->editOnClick(),

            Column::add()
                ->title('payccno')
                ->field('payccno')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('currentrank')
                ->field('currentrank')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('lastname')
                ->field('lastname')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('firstname')
                ->field('firstname')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('middlename')
                ->field('middlename')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('suffix')
                ->field('suffix')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('deptcode')
                ->field('deptcode')
                ->sortable()
                ->searchable()
                ->makeInputText(),

            Column::add()
                ->title('email')
                ->field('email')
                ->sortable()
                ->searchable()
                ->makeInputText(),
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
     * PowerGrid pis_employee Action Buttons.
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
               ->route('pis_employee.edit', ['pis_employee' => 'id']),

           Button::add('destroy')
               ->caption('Delete')
               ->class('bg-red-500 cursor-pointer text-white px-3 py-2 m-1 rounded text-sm')
               ->route('pis_employee.destroy', ['pis_employee' => 'id'])
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
     * PowerGrid pis_employee Action Rules.
     *
     * @return array<int, \PowerComponents\LivewirePowerGrid\Rules\RuleActions>
     */

    /*
    public function actionRules(): array
    {
       return [

           //Hide button edit for ID 1
            Rule::button('edit')
                ->when(fn($pis_employee) => $pis_employee->id === 1)
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
     * PowerGrid pis_employee Update.
     *
     * @param array<string,string> $data
     */

    /*
    public function update(array $data ): bool
    {
       try {
           $updated = pis_employee::query()->findOrFail($data['id'])
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
    */
}
