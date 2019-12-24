<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $fillable = ['ideventos',
                            'title',
                            'description',
                            'color',
                            'textColor',
                            'start_date',
                            'end_date',
                            'created_at',
                            'updated_at'];
}
