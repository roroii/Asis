<?php

namespace App\Http\Livewire;

use App\Models\ASIS_Models\Clearance\clearance_signatories;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class StudentsListPowergrid extends Component
{
    public $students = [];
    private $pagination = [];
    use WithPagination;

    public function mount(): void
    {
        // Fetch and set signatories data
        $this->fetchSignatoriesData();
        $this->pagination = User::where('active', 1)->paginate(10);
    }

    private function fetchSignatoriesData()
    {
        // Fetch signatories data from the database using the model
        $get_students = User::where('active', 1)->paginate(10);

        // Transform and store the data in the $signatories property
        $this->students = $get_students->map(function ($data) {

            $student_id = $data->studid;

            if ($data) {

                $fullName = $data->fullname;

            } else {
                $fullName = 'No Data';
            }

            if($data->designation)
            {
                $designation = $data->designation;
            }else
            {
                $designation = 'N/A';
            }

            $active = $data->active ? 'Active' : 'Inactive';

            return [
                'student_id' => $student_id,
                'full_name' => $fullName,
                'designation' => $designation,
                'status' => $active,
            ];
        })->toArray();
    }
    public function render()
    {
        return view('livewire.students-list-powergrid');
    }
}
