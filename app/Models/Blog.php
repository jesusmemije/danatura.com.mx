<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    use HasFactory;

    protected $months = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];

    protected $months_en = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];

    public function getDateShowBlog()
    {

        $date = Carbon::parse($this->created_at);

        $month = $this->months[($date->format('n')) - 1];

        return $date->format('d').' de '.$month.' a las '.$date->format('H:m:s');

    }

    public function getDateEnShowBlog()
    {

        $date = Carbon::parse($this->created_at);

        $months_en = $this->months_en[($date->format('n')) - 1];

        return $date->format('d').' of '.$months_en.' at '.$date->format('H:m:s');

    }

    public function getDateAdminList()
    {

        $date = Carbon::parse($this->created_at);

        $month = $this->months[($date->format('n')) - 1];

        return $date->format('d').' de '.$month.' de '.$date->format('Y');

    }
}
