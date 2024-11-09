<?php
    class View{
        public $listaOcupaciones;
        public $persona;
        public $listaOcupaciones2;
        public $Valimensaje;
        public $mensaje;
        public $listaPersonas;
        function __construct(){

        }
        function renderView($vista){//Notara que nunca hacemos un redirect puntual a una vista
            require 'views/' . $vista; // Entonces llamamos ese codigo y añadimos el recurso vista
        }
    }
?>
