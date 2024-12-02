<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use App\Models\Global\CatalogType;

class PostsExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return CatalogType::all();
    }
}
