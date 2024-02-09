<?php

namespace App\Imports;

use App\Models\tblemployee;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ImportProfile implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new tblemployee([
            "agencyid" => $row["agencyid"],
            "lastname" => $row["lastname"],
            "firstname" => $row["firstname"],
            "mi" => $row["mi"],
            "extension" =>  $row["extension"],
            "dateofbirth" =>  $row["dateofbirth"],
            "placeofbirth" => $row["placeofbirth"],
            "sex" => $row["sex"],
            "citizenship" => $row["citizenship"],
            "email" => $row["email"],
        ]);
    }
}
