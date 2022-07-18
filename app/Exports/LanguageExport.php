<?php

namespace App\Exports;

use App\Models\LanguageModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class LanguageExport implements FromCollection,WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'Id',
            'Name',
            'Status',
            'Created_at',
            'Updated_at' 
        ];
    } 
    public function map($data): array
    {
         return[
             $data->id,
             $data->name,
             $data->status==1 ? 'Active' : 'Inactive',
             $data->created_at,
             $data->updated_at,
         ];
    }
    public function collection()
    {
        return LanguageModel::with('User')->get();
    }
}
