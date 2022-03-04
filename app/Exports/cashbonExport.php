<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Alignment as StyleAlignment;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class cashbonExport implements FromCollection, WithHeadings, WithColumnWidths, WithStyles
{
    protected $data;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function headings(): array
    {
        return[
            'Tgl Terima',
            'Nama Supplier',
            'Harga Penawaran',
            'Total Kasbon',
            'Sisa',
            'Tipe',
            'No nota',
            'Nama Project',
            'Deskripsi',
            'Jumlah',
        ];
    }

    public function collection()
    {
        return collect($this->data);
    }

    public function columnWidths(): array
    {
        return [
            // 'A' => 4,
            // 'B' => 35,
            // 'C' => 20,
            // 'D' => 30,
            // 'E' => 50,
            // 'F' => 15,
            // 'G' => 5,
            // 'H' => 10,
            // 'I' => 10,
            // 'J' => 20,

            'A' => 15,
            'B' => 25,
            'C' => 30,
            'D' => 30,
            'E' => 30,
            'F' => 10,
            'G' => 10,
            'H' => 35,
            'I' => 40,
            'J' => 30,
        ];
    }

    public function styles(Worksheet $data)
    {
        $data->getStyle('A')->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $data->getStyle('B')->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $data->getStyle('C')->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $data->getStyle('D')->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $data->getStyle('E')->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $data->getStyle('F')->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $data->getStyle('G')->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $data->getStyle('H')->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $data->getStyle('I')->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);
        $data->getStyle('J')->getAlignment()->setHorizontal(StyleAlignment::HORIZONTAL_CENTER);

        return [
            // Style the first row as bold text.
            1 => [
                'font' => ['bold' => true],
            ],
        ];
    }
}
