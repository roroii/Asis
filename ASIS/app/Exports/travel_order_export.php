<?php

namespace App\Exports;

use App\Models\travel_order\to_travel_orders;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithBackgroundColor;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithDefaultStyles;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class travel_order_export implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithBackgroundColor , WithStyles , WithDefaultStyles , WithColumnWidths
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;
    // php artisan make:export travel_order_export --model=travel_order/to_travel_orders

    public function collection()
    {
        return export_travel_order();
    }

    public function headings(): array
    {
        return ["#", "Employee ID", "Full Name", "Date", "Departure Date", "Return Date", "Position/Designation", "Station", "Destination", "Purpose"];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:J1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(12)->setBold(true);
            },
        ];
    }

    public function backgroundColor()
    {
        // Return RGB color code.
        // return '000000';

        // Return a Color instance. The fill type will automatically be set to "solid"
        // return new Color(Color::COLOR_BLUE);

        // Or return the styles array
        // return [
        //      'fillType'   => Fill::FILL_GRADIENT_LINEAR,
        //      'startColor' => ['argb' => Color::COLOR_RED],
        // ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('B1:B3')->getFont()->setBold(true);

        // return [
        //     // Style the first row as bold text.
        //     1    => ['font' => ['bold' => true]],

        //     // Styling a specific cell by coordinate.
        //     'B2' => ['font' => ['italic' => true]],

        //     // Styling an entire column.
        //     'C'  => ['font' => ['size' => 16]],
        // ];
    }

    public function defaultStyles(Style $defaultStyle)
    {
        // Configure the default styles
        return $defaultStyle->getFill()->setFillType(Fill::FILL_SOLID);

        // Or return the styles array
        // return [
        //     'fill' => [
        //         'fillType'   => Fill::FILL_SOLID,
        //         'startColor' => ['argb' => Color::COLOR_RED],
        //     ],
        // ];
    }

    public function columnWidths(): array
    {
        return [
            // 'A' => 55,
            // 'B' => 45,
        ];
    }

    // public function drawings()
    // {
    //     $drawing = new Drawing();
    //     $drawing->setName('Logo');
    //     $drawing->setDescription('This is my logo');
    //     $drawing->setPath(public_path('/uploads/settings/1_theG1683191339.png'));
    //     $drawing->setHeight(50);
    //     $drawing->setCoordinates('B7');

    //     // $drawing2 = new Drawing();
    //     // $drawing2->setName('Other image');
    //     // $drawing2->setDescription('This is a second image');
    //     // $drawing2->setPath(public_path('/uploads/settings/1_theG1683191339.png'));
    //     // $drawing2->setHeight(120);
    //     // $drawing2->setCoordinates('G2');

    //     return [$drawing];
    // }


}
