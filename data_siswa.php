<?php
require_once 'data_siswa_builder.php';

class data_siswa {
    private $siswa = [];


    public function __construct() {
        $this->builder = new data_siswa_builder();
    }
    

    public function get() {
        return $this
            ->process()
            ->siswa;
    }

    private function __ahmad_xi_l()
    {
        $this->siswa[] = $this->
            builder->
                add(
                    'Ahmad', 
                    'XI', 
                    'L'
                );

        return $this;
    }

    private function __sinta_xi_l()
    {
        $this->siswa[] = $this->
            builder->
                add(
                    'Sinta', 
                    'XI', 
                    'P'
                );

        return $this;
    }

    private function __zzz_zz_l()
    {
        $this->siswa[] = $this->
            builder->
                add(
                    'Zzz', 
                    'ZZ', 
                    'L'
                );

        return $this;
    }

    // mulai ngoding disini

    // akhir ngoding disini

    private function process()
    {
        $this->
            __ahmad_xi_l()
            // jangan lupa panggil disini
            ->__sinta_xi_l()
        ;

        return $this;
    }
}