<?php

namespace App\Exports;

use App\Models\DocumentModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Support\Types\LanguageType;

class DocumentExport implements FromCollection,WithHeadings,WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function headings():array{
        return[
            'Id',
            'Uuid',
            'Title',
            'Description',
            'Year',
            'Deity',
            'Version',
            'Language',
            'Uploaded By',
            'Total Favourites',
            'Total Views',
            'Document',
            'Status',
            'Restricted',
            'Created_at',
            'Updated_at' 
        ];
    } 
    public function map($data): array
    {
         return[
             $data->id,
             $data->uuid,
             $data->title,
             $data->description_unformatted,
             $data->year,
             $data->deity,
             $data->version,
             $data->LanguageModel->name,
             $data->user->name,
             $data->favourites,
             $data->views,
             $data->document,
             $data->status==1 ? 'Active' : 'Inactive',
             $data->restricted==1 ? 'Yes' : 'No',
             $data->created_at,
             $data->updated_at,
         ];
    }
    public function collection()
    {
        return DocumentModel::with(['User','LanguageModel'])->get();
    }
}
