<?php


namespace ClientesBundle\Constantes;


class VariablesConstantes
{

    static function getGroups(){
        return array('' => 'Seleccionar un grupo',
            1 => 'Grupo A',
            2 => 'Grupo B',
            3 => 'Grupo C'
        );
    }

}