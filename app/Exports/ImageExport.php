<?php

namespace App\Exports;

use App\Models\ImageModel;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use App\Support\Types\LanguageType;

class ImageExport implements FromCollection,WithHeadings,WithMapping
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
            'Image',
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
             LanguageType::lists()[$data->language],
             $data->user->name,
             $data->favourites,
             $data->views,
             $data->image,
             $data->status==1 ? 'Active' : 'Inactive',
             $data->restricted==1 ? 'Yes' : 'No',
             $data->created_at,
             $data->updated_at,
         ];
    }
    public function collection()
    {
        return ImageModel::with('User')->get();
    }
}
