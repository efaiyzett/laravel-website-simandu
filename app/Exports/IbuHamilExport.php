<?php

namespace App\Exports;

use App\Models\IbuHamil;
use App\Models\PemeriksaanIbuHamil;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class IbuHamilExport implements FromCollection, WithHeadings
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
            $query = IbuHamil::query();
            if ($this->keterangan != 'semua') {
                $query->where(
                    'id',
                    $this->keterangan
                );
            }

            return $query
                ->select(
                    'nama',
                    'nik',
                    'tempat_lahir',
                    'tgl_lahir',
                    'alamat'
                )
                ->get();
        }

        $query = IbuHamil::with([
            'pemeriksaan',
            'tensi'
        ]);

        if ($this->keterangan != 'semua') {
            $query->where(
                'id',
                $this->keterangan
            );
        }
        return $query->get()
            ->map(function ($item) {
                return [
                    'Nama' => $item->nama,
                    'HPHT' => $item->pemeriksaan?->hpht ?? '-',
                    'HPL' => $item->pemeriksaan?->hpl ?? '-',
                    'Berat (kg)' => $item->pemeriksaan?->berat ?? '-',
                    'Pemeriksaan Darah' => $item->pemeriksaan?->pemeriksaan_darah ?? '-',
                    'Tanggal Pemeriksaan' => $item->pemeriksaan?->tanggal_pemeriksaan ?? '-',
                    'Riwayat Tensi' =>
                    $item->tensi
                        ->map(function ($tensi) {
                            return
                                $tensi->tensi
                                . ' ('
                                . $tensi->tanggal_periksa
                                . ')';
                        })
                        ->implode(', ')
                ];
            });
    }

    public function headings(): array
    {
        if ($this->jenis == 'master') {
            return [
                'Nama',
                'NIK',
                'Tempat Lahir',
                'Tanggal Lahir',
                'Alamat'
            ];
        }

        return [
            'Nama',
            'HPHT',
            'HPL',
            'Berat (kg)',
            'Pemeriksaan Darah',
            'Tanggal Pemeriksaan',
            'Riwayat Tensi'
        ];
    }
}
