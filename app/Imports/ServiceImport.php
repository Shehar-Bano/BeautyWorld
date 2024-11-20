<?php

namespace App\Imports;

use App\Models\Service;
use Maatwebsite\Excel\Concerns\ToModel;

class ServiceImport implements ToModel
{
    private $current=0;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    
    public function model(array $row)
    {
       $this->current++;
        if( $this->current>1){
             return new Service([
                'name'        => $row[0],  // Assumes column 1 in the CSV/Excel file is 'name'
                'description' => $row[1],  // Assumes column 2 is 'description'
                'price'       => $row[2],  // Assumes column 3 is 'price'
                'duration'    => $row[3],  // Assumes column 4 is 'duration'
                'status'      => $row[4],  // Assumes column 5 is 'status'
                'category_id' => $row[5],  // Assumes column 6 is 'category_id'
            ]);
        }
      
          
                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                
    }
}
