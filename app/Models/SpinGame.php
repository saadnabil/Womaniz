<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpinGame extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function country(){
        return $this->belongsTo(Country::class);
    }

    public function setDigitOneAttribute($value){
        $this->attributes['digit_one'] = ($value == 0) ? 'spin_again' : $value;
    }

    public function setDigitTwoAttribute($value){
        $this->attributes['digit_two'] = ($value == 0) ? 'spin_again' : $value;
    }

    public function setDigitThreeAttribute($value){
        $this->attributes['digit_three'] = ($value == 0) ? 'spin_again' : $value;
    }

    public function setDigitFourAttribute($value){
        $this->attributes['digit_four'] = ($value == 0) ? 'spin_again' : $value;
    }

    public function setDigitFiveAttribute($value){
        $this->attributes['digit_five'] = ($value == 0) ? 'spin_again' : $value;
    }

    public function setDigitSixAttribute($value){
        $this->attributes['digit_six'] = ($value == 0) ? 'spin_again' : $value;
    }

    public function setDigitSevenAttribute($value){
        $this->attributes['digit_seven'] = ($value == 0) ? 'spin_again' : $value;
    }

    public function setDigitEightAttribute($value){
        $this->attributes['digit_eight'] = ($value == 0) ? 'spin_again' : $value;
    }

    public function setDigitNineAttribute($value){
        $this->attributes['digit_nine'] = ($value == 0) ? 'spin_again' : $value;
    }

}
