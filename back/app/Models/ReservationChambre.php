<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationChambre extends Model
{
    use HasFactory;
    protected $table = 'reservation_chambres';
    protected $primaryKey = 'ID';
    protected $fillable = [

        'ID_Chambre',
        'type_Chambre',
        'Nom_Client',
        'Telephone',
        'Date_Debut',
        'Date_Fin',
        'Nombre_Nuits',
        'Prix_Total',
        'Statut'
    ];

    public $timestamps = false;

    public function chambre()
    {
        return $this->belongsTo(chambre::class, 'ID_Chambre');
        return $this->belongsTo(chambre::class, 'type_Chambre');
    }
}
