<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

require_once '../../libs/vendor/autoload.php';

// Crear una nueva hoja de cálculo
$spreadsheet = new Spreadsheet();

// Agregar las propiedades al archivo
$spreadsheet->getProperties()->setCreator("Josué Vásquez")->setTitle("Mi Excel");

$spreadsheet->setActiveSheetIndex(0);
$hojaActiva = $spreadsheet->getActiveSheet();

// Cambiar la fuente
$spreadsheet->getDefaultStyle()->getFont()->setName('Century Gothic');

// Cambiar el tamaño de la letra
$spreadsheet->getDefaultStyle()->getFont()->setSize(13);

// Asignar un ancho a las columnas
$hojaActiva->getColumnDimension('A')->setWidth(10);
$hojaActiva->getColumnDimension('B')->setWidth(40);

// Agregar encabezados
$hojaActiva->setCellValue('A1', 'Id');
$hojaActiva->setCellValue('B1', 'Nombre');
$hojaActiva->setCellValue('C1', 'Edad');
$hojaActiva->setCellValue('D1', 'Teléfono');
$hojaActiva->setCellValue('E1', 'Sexo');
$hojaActiva->setCellValue('F1', 'Ocupación');
$hojaActiva->setCellValue('G1', 'Fecha de nacimiento');

// Rellenar los datos
$row = 2; // Comenzar en la segunda fila
foreach ($listaPersonas as $lista) {
    $hojaActiva->setCellValue("A{$row}", $lista->getIdPersona());
    $hojaActiva->setCellValue("B{$row}", $lista->getNombre());
    $hojaActiva->setCellValue("C{$row}", $lista->getEdad());
    $hojaActiva->setCellValue("D{$row}", $lista->getTelefono());
    $hojaActiva->setCellValue("E{$row}", $lista->getSexo());
    $hojaActiva->setCellValue("F{$row}", $lista->getOcupacion()->getOcupacion());
    $hojaActiva->setCellValue("G{$row}", $lista->getFecha());
    $row++;
}

// Configurar encabezados para la descarga
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="excelPersona.xlsx"');
header('Cache-Control: max-age=0');

$writer = new Xlsx($spreadsheet);
$writer->save('php://output');
/*$writer = new Xlsx($spreadsheet);
$writer->save('Excel.xlsx');*/
exit;
?>