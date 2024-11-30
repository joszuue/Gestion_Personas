<?php
    use PhpOffice\PhpSpreadsheet\Spreadsheet;
    use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
    require 'libs/Spreadsheet/autoload.php';
    class SpreadsheetController extends Controller{//extenderemos de controller para poder acceder a sus funciones

        function __construct(){
            parent::__construct();
            $this->loadModel('Main');
        }

        function excelPersona(){
            $listaPersonas = $this->model->listaPersonas();//enviamos arreglos de objetos a las vistas
            
            if (!is_array($listaPersonas) || empty($listaPersonas)) {
                die('No hay datos disponibles para generar el Excel.');
            }

            ob_end_clean(); // Limpia y cierra el buffer

            // Inicia un buffer de salida para evitar salidas inesperadas
            //ob_start();

            // Crear una nueva hoja de cálculo
            $spreadsheet = new Spreadsheet();

            // Agregar las propiedades al archivo
            $spreadsheet->getProperties()->setCreator("Josué Vásquez")->setTitle("Mi Excel");
            $spreadsheet->setActiveSheetIndex(0);
            $hojaActiva = $spreadsheet->getActiveSheet();

            // Cambiar la fuente
            $spreadsheet->getDefaultStyle()->getFont()->setName('Century Gothic');
            $spreadsheet->getDefaultStyle()->getFont()->setSize(13);

            // Asignar un ancho a las columnas
            $hojaActiva->getColumnDimension('A')->setWidth(10);
            $hojaActiva->getColumnDimension('B')->setWidth(30);
            $hojaActiva->getColumnDimension('C')->setWidth(10);
            $hojaActiva->getColumnDimension('D')->setWidth(15);
            $hojaActiva->getColumnDimension('E')->setWidth(20);
            $hojaActiva->getColumnDimension('F')->setWidth(20);
            $hojaActiva->getColumnDimension('G')->setWidth(21);

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

            // Generar y enviar el archivo Excel al navegador
            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
            //$writer->save('Excel.xlsx');
            exit;

            $output = ob_get_contents();
            if (!empty($output)) {
                echo "<pre>Se ha detectado salida previa:\n$output</pre>";
                exit;
            }
        }
    }
?>