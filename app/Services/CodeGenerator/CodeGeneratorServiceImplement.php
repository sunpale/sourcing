<?php

namespace App\Services\CodeGenerator;

use Illuminate\Database\Eloquent\Collection;

class CodeGeneratorServiceImplement implements CodeGeneratorService
{
    private string $generatedCode = '';
    private int $firstNumber = 1;

    public static function generate(Collection $queryResult, string $prefix = '', int $startIndex = 0, int $length = 4,string $colname = ''): string
    {
        if ($queryResult->count() == 0){
            $generatedCode = str_repeat('0', $length - 1);
            return $prefix.$generatedCode.'1';
        }
        $lastNumber = (int) substr($queryResult[0][$colname],$startIndex,$length)+1; //ambil baris terakhir data, lalu nomernya ditambah 1
        //cek panjang last number, jika sudah sama dengan nilai length, maka tidak perlu di tambah 0
        $generatedCode = strlen($lastNumber)===$length ? '' : str_repeat('0',$length-1);
        return $prefix.$generatedCode.$lastNumber;
    }

    public static function generate_random_code(code_type $type, int $length = 4): string
    {
        $stringList = $type ===code_type::ALPHA ? 'ABCDEFGHIJKLMNOPQRSTUVWXYZ' : ($type===code_type::NUMERIC ? '0123456789' : 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
        $code = '';
        while (strlen($code) < $length){
            $position = rand(0,strlen($stringList)-1);
            $character = $stringList[$position];
            $code .= $character;
        }
        return $code;
    }
}
