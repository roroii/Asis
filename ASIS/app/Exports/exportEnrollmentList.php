<?php

namespace App\Exports;

use App\Models\ASIS_Models\enrollment\enrollment_list;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;
use Carbon\Carbon;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ExportEnrollmentList implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents
{
    protected $year;
    protected $sem;
    protected $yearLevel;
    protected $program;
    protected $status;

    public function __construct($year, $sem, $yearLevel, $program, $status)
    {
        $this->year = $year;
        $this->sem = $sem;
        $this->yearLevel = $yearLevel;
        $this->program = $program;
        $this->status = $status;
    }

    public function collection()
    {
        $columns = ['studid', 'fullname', 'studmajor', 'section', 'year_level', 'status' ,'number', 'created_at'];

        $query = enrollment_list::query()->whereDoesntHave('isAdmin')->select($columns);

        if ($this->year) {
            $query->where('year', $this->year);
        }

        if ($this->sem) {
            $query->where('sem', $this->sem);
        }

        if ($this->yearLevel) {
            $query->where('year_level', $this->yearLevel);
        }

        if ($this->program) {
            $query->where('studmajor', $this->program);
        }

        if ($this->status !== null) {
            $query->where('status', $this->status);
        }
        $collection = $query->get();

        foreach ($collection as $i => $item) {
            $item->count = $i + 1;
            $item->created_at_text = $item->created_at->format('F j, Y h:i:s A');
            
            // Remove the 'created_at' property
            unset($item->created_at);
        }

        // Rearrange the collection to keep only 'count' and 'created_at_text'
        $collection = $collection->map(function ($item) {
            return [
                'count' => $item->count, 
                'studid' => $item->studid, 
                'fullname' => $item->fullname, 
                'studmajor' => $item->studmajor, 
                'section' => $item->section, 
                'year_level' => $item->year_level, 
                'status' => $item->status, 
                'number' => $item->number, 
                'created_at_text' => $item->created_at_text
            ];
        });

        return $collection;
    }

    public function headings(): array
    {
        return ["#", "Student ID", "Full Name", "Course/Program", "Section", "Current Year Level", "Status", "Contact Number", "Date Submitted"];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $cellRange = 'A1:H1'; // All headers

                // Set font and size for headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12)->setBold(true);

                // Set font and size for title
                $title = 'Enrollment List'; // Your desired title
                $event->sheet->setTitle($title);
            },
        ];
    }
}
