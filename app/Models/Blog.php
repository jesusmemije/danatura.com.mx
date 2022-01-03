<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;


class Blog extends Model{

    use HasFactory;

    protected $months = array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");

    public function getDateShowBlog(){
        $date = Carbon::parse( $this->created_at );
        $month = $this->months[($date->format('n')) - 1];
        return $date->format('d') . ' de ' . $month . ' a las ' . $date->format('H:m:s');
    }

    public function getDateAdminList(){
        $date = Carbon::parse( $this->created_at );
        $month = $this->months[($date->format('n')) - 1];
        return $date->format('d') . ' de ' . $month . ' de ' . $date->format('Y');
    }

}