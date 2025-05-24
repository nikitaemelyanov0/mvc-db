<?php 

class TestController{

    public function ndflGet() {
        return new View("calculator");
    }
    
    public function ndflPost() {
        $money = $_POST['money'];
        $trauma_procent = $_POST['trauma_procent'];
            
        if ($money/12<5000000) {
            $ndfl = $money*0.13;
        }
        else {
            $ndfl = $money*0.15;
        }
        $wage = $money-$ndfl;
        $pensia = $money*0.22;
        $med = $money*0.51;
        $soc = $money*0.29;
        $trauma = $money*($trauma_procent/100);
        $fot = $wage+$pensia+$med+$soc+$trauma;

        echo 'Ваша зарплата: '.$wage."<br>", 'НДФЛ: '.$ndfl."<br>", 'Пенсионный фонд: '.$pensia."<br>", 'Медицинское страхование: '.$med."<br>", 'Социальное страхование: '.$soc."<br>", 'Травматизм: '.$trauma."<br>", 'ФОТ: '.$fot."<br>";        
    }
}