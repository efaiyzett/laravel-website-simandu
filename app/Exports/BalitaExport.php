<?php

namespace App\Exports;

use App\Models\Balita;
use App\Models\PemeriksaanBalita;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BalitaExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    protected $jenis;
    protected $keterangan;
    public function __construct($jenis, $keterangan)
    {
        $this->jenis = $jenis;
        $this->keterangan = $keterangan;
    }

    public function collection()
    {
        if ($this->jenis == 'master') {
            $query = Balita::query();
            if ($this->keterangan != 'semua') {
                $query->where('id', $this->keterangan);
            }
            return $query
                ->select(
                    'nama',
                    'nik',
                    'nama_ortu',
                    'tempat_lahir',
                    'tgl_lahir',
                    'alamat'
                )
                ->get();
        }

        $query = PemeriksaanBalita::with([
            'balita',
            'imunisasi'
        ]);
        if ($this->keterangan != 'semua') {
            $query->where(
                'balita_id',
                $this->keterangan
            );
        }
        return $query->get()
            ->map(function ($item) {
                return [
                    'Nama Balita' => $item->balita->nama,
                    'Tanggal Pemeriksaan' => $item->tanggal_pemeriksaan,
                    'Berat Badan (kg)' => $item->berat,
                    'Tinggi Badan (cm)' => $item->tinggi,
                    'Imunisasi' => $item->imunisasi?->imunisasi ?? '-',
                    'Jenis Imunisasi' => $item->imunisasi?->jenis ?? '-',
                    'Catatan' => $item->catatan ?? '-',
                ];
            });
    }

    public function headings(): array
    {
        if ($this->jenis == 'master') {
            return [
                'Nama',
                'NIK',
                'Nama Orang Tua',
                'Tempat Lahir',
                'Tanggal Lahir',
                'Alamat'
            ];
        }

        return [
            'Nama Balita',
            'Tanggal Pemeriksaan',
            'Berat Badan (kg)',
            'Tinggi Badan (cm)',
            'Imunisasi',
            'Jenis Imunisasi',
            'Catatan'
        ];
    }
}
