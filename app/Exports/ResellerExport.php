<?php

namespace App\Exports;

use App\Models\Reseller;
use Maatwebsite\Excel\Concerns\FromCollection;

class ResellerExport implements FromCollection
{
    // protected $kode_customer;

    // public function __construct($kode_customer)
    // {
    //     $this->kode_customer = $kode_customer;
    // }
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Reseller::all();
    }
}
