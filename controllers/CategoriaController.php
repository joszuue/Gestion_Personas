<?php
require 'libs/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
class CategoriaController extends Controller { //extenderemos de controller para poder acceder a sus funciones
    public $view;
    public $model;
    public $utils;

    function __construct()
    {
        parent::__construct();
        $this->loadModel('Main');  
    }

    function excelPersona() {
        // Obtén los datos desde el modelo
        $listaPersonas = $this->model->listaPersonas();

        // Crear un nuevo objeto Spreadsheet
        $spreadsheet = new Spreadsheet();
        $hojaActiva = $spreadsheet->getActiveSheet();

        // Configurar encabezados y datos
        $spreadsheet->getDefaultStyle()->getFont()->setName('Century Gothic')->setSize(13);
        $hojaActiva->getColumnDimension('A')->setWidth(10);
        $hojaActiva->getColumnDimension('B')->setWidth(40);
        $hojaActiva->setCellValue('A1', 'Id');
        $hojaActiva->setCellValue('B1', 'Nombre');
        $hojaActiva->setCellValue('C1', 'Edad');
        $hojaActiva->setCellValue('D1', 'Teléfono');
        $hojaActiva->setCellValue('E1', 'Sexo');
        $hojaActiva->setCellValue('F1', 'Ocupación');
        $hojaActiva->setCellValue('G1', 'Fecha de nacimiento');

        $row = 2;
        foreach ($listaPersonas as $persona) {
            $hojaActiva->setCellValue("A{$row}", $persona->getIdPersona());
            $hojaActiva->setCellValue("B{$row}", $persona->getNombre());
            $hojaActiva->setCellValue("C{$row}", $persona->getEdad());
            $hojaActiva->setCellValue("D{$row}", $persona->getTelefono());
            $hojaActiva->setCellValue("E{$row}", $persona->getSexo());
            $hojaActiva->setCellValue("F{$row}", $persona->getOcupacion()->getOcupacion());
            $hojaActiva->setCellValue("G{$row}", $persona->getFecha());
            $row++;
        }

        // Configurar encabezados para la descarga
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="excelPersona2.xlsx"');
        header('Cache-Control: max-age=0');

        // Crear el archivo y enviarlo al navegador
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
?>