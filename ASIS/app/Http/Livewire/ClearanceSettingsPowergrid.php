<?php

namespace App\Http\Livewire;

use App\Models\ASIS_Models\Clearance\clearance_signatories;
use App\Models\ASIS_Models\enrollment\enrollment_settings;
use Illuminate\Database\QueryException;
use Livewire\Component;
use PowerComponents\LivewirePowerGrid\Column;
use PowerComponents\LivewirePowerGrid\PowerGrid;
use PowerComponents\LivewirePowerGrid\PowerGridComponent;
use PowerComponents\LivewirePowerGrid\PowerGridEloquent;

class ClearanceSettingsPowergrid extends PowerGridComponent
{

    public $signatories = [];
    public $designation;
    public $isEditing = false;

    public function mount(): void
    {
        // Set initial data
        $this->clearanceLevel = 'High';

        // Fetch and set signatories data
        $this->fetchSignatoriesData();

    }

    public function submitForm()
    {
        // Handle form submission logic if needed

        // Emit a browser event to trigger Livewire component refresh
        $this->emit('refreshComponent');
    }

    private function fetchSignatoriesData()
    {
        // Fetch signatories data from the database using the model
        $clearanceSignatories = clearance_signatories::with('get_Employee_Data')->where('active', 1)->get();

        // Transform and store the data in the $signatories property
        $this->signatories = $clearanceSignatories->map(function ($data) {
            $signatory_id = $data->signatory_id;

            if ($data->get_Employee_Data) {
                $firstName = $data->get_Employee_Data->firstname;
                $lastName = $data->get_Employee_Data->lastname;
                $mi = GLOBAL_MIDDLE_NAME_GENERATOR($data->get_Employee_Data->lastname);

                $fullName = strtoupper($firstName) . ' ' . strtoupper($mi) . ' ' . strtoupper($lastName);
            } else {
                $fullName = 'No Data';
            }

            $designation = $data->designation;
            $active = $data->active ? 'Active' : 'Inactive';

            return [
                'signatory_id' => $signatory_id,
                'full_name' => $fullName,
                'designation' => $designation,
                'status' => $active,
            ];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.clearance-settings-powergrid');
    }

    public function editDesignation($signatoryId, $newDesignation)
    {

    }
    public function updateDesignation($signatoryId, $newDesignation)
    {
        $signatory = clearance_signatories::where('signatory_id', $signatoryId)->first();

        if ($signatory) {
            $signatory->designation = $newDesignation;
            $signatory->save();
        }

        // Refresh the signatories data after updating
        $this->fetchSignatoriesData();

    }

    public function deleteSignatory($signatoryId)
    {
        $signatory = clearance_signatories::where('signatory_id', $signatoryId)->first();

        if ($signatory) {
            $signatory->active = 0;
            $signatory->save();
        }

        // Refresh the signatories data after updating
        $this->fetchSignatoriesData();

    }
}
