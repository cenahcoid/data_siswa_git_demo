<?php
class data_siswa_builder {
    private $siswa = [];

    public function add($nama, $kelas, $jenis_kelamin) {
        $data = new \stdClass();
        $data->nama = $nama;
        $data->kelas = $kelas;
        $data->jenis_kelamin = $jenis_kelamin;

        return $data;
    }
}