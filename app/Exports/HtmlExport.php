<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromHtml;
use PhpOffice\PhpSpreadsheet\Writer\Html as HtmlWriter;
use PhpOffice\PhpSpreadsheet\Spreadsheet;

class HtmlExport implements FromHtml
{
    protected $html;

    public function __construct($html)
    {
        $this->html = $html;
    }

    public function html(): string
    {
        return $this->html;
    }
}
