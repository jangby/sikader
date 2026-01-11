<?php

namespace App\Exports;

use App\Models\Event;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Carbon\Carbon;

class ParticipantsExport implements FromQuery, WithHeadings, WithMapping, ShouldAutoSize, WithStyles, WithColumnFormatting, WithEvents
{
    protected $eventId;
    protected $filter;
    protected $rowNumber = 0;

    public function __construct(int $eventId, string $filter)
    {
        $this->eventId = $eventId;
        $this->filter  = $filter;
    }

    public function query()
    {
        $event = Event::findOrFail($this->eventId);
        $query = $event->registrations()->with('user.profile');

        if ($this->filter == 'Laki-laki') {
            $query->whereHas('user.profile', fn($q) => $q->where('jenis_kelamin', 'Laki-laki'));
        } elseif ($this->filter == 'Perempuan') {
            $query->whereHas('user.profile', fn($q) => $q->where('jenis_kelamin', 'Perempuan'));
        }

        return $query;
    }

    public function map($registration): array
    {
        $this->rowNumber++;
        $profile = $registration->user->profile;

        // 1. Format Tanggal Lahir (Cegah Error)
        $tglLahir = '-';
        if (!empty($profile->tanggal_lahir)) {
            try {
                $tglLahir = Carbon::parse($profile->tanggal_lahir)->format('d-m-Y');
            } catch (\Exception $e) {
                $tglLahir = $profile->tanggal_lahir;
            }
        }

        // 2. Format Alamat Lengkap (Gabungan)
        $alamatLengkap = sprintf(
            "%s, RT %s / RW %s, Ds. %s, Kec. %s, Kab. %s",
            $profile->alamat ?? '-',
            $profile->rt ?? '-',
            $profile->rw ?? '-',
            $profile->desa ?? '-',
            $profile->kecamatan ?? '-',
            $profile->kabupaten ?? '-'
        );

        return [
            $this->rowNumber,
            strtoupper($profile->nama_lengkap ?? $registration->user->name),
            $profile->jenis_kelamin ?? '-',
            $profile->no_hp ?? '-',
            $profile->asal_delegasi ?? '-',
            ($profile->tempat_lahir ?? '-') . ', ' . $tglLahir,
            $alamatLengkap, // <--- Data Alamat Masuk Disini
            strtoupper($registration->status),
        ];
    }

    public function headings(): array
    {
        return [
            ['DATA PESERTA KEGIATAN'], 
            ['Filter: ' . ($this->filter == 'all' ? 'Semua Peserta' : $this->filter)], 
            [
                'NO',
                'NAMA LENGKAP',
                'L/P',
                'NO HP (WA)',
                'ASAL DELEGASI',
                'TTL',
                'ALAMAT DOMISILI', // <--- Header Baru
                'STATUS'
            ]
        ];
    }

    public function columnFormats(): array
    {
        return [
            'D' => NumberFormat::FORMAT_TEXT, // No HP Text
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            3 => [
                'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF']],
                'fill' => [
                    'fillType' => Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5']
                ],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
            ],
            // Alignment Kolom
            'A' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]], // No
            'C' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]], // L/P
            'D' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]], // No HP
            'H' => ['alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER]], // Status (Geser ke H)
            
            // Kolom Alamat (G) dibiarkan rata kiri (default) agar mudah dibaca
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                $sheet = $event->sheet;
                $highestRow = $sheet->getHighestRow();
                // Karena tambah 1 kolom, range jadi H (A sampai H)
                $highestColumn = 'H'; 

                // Merge Judul (A1 sampai H1)
                $sheet->mergeCells('A1:H1');
                $sheet->setCellValue('A1', 'DATA PESERTA - ' . strtoupper(Event::find($this->eventId)->nama_acara));
                $sheet->getStyle('A1')->applyFromArray([
                    'font' => ['bold' => true, 'size' => 14],
                    'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
                ]);

                // Merge Sub-Judul
                $sheet->mergeCells('A2:H2');
                $sheet->getStyle('A2')->getFont()->setItalic(true);

                // Border
                $styleArray = [
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                    'alignment' => [
                        'vertical' => Alignment::VERTICAL_CENTER // Semua sel vertikal tengah
                    ]
                ];
                $sheet->getStyle('A3:' . $highestColumn . $highestRow)->applyFromArray($styleArray);
            },
        ];
    }
}