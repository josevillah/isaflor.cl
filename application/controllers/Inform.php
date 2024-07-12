<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Inform extends CI_Controller {

    public function __construct() {
        parent::__construct();
        // Carga el helper url
        $this->load->helper('url');
        $this->load->library('session');
        require_once FCPATH . 'vendor/autoload.php';
    }

    function generateExcel(){
        // Obtener los datos de los productos
        $this->load->model('Productos_model');
        $productos = $this->Productos_model->getAllProductsExcel();
        $date = $this->Productos_model->getDateReducida();

        // Instancia de PhpSpreadsheet
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Añadir encabezados
        $sheet->setCellValue('A1', 'Código');
        $sheet->setCellValue('B1', 'Nombre');
        $sheet->setCellValue('C1', 'Precio');
        $sheet->setCellValue('D1', 'Precio oferta');
        $sheet->setCellValue('E1', 'Categoría');
        $sheet->setCellValue('F1', 'Stock');

         // Añadir datos de los productos
         $row = 2;
         foreach ($productos as $producto) {
             $sheet->setCellValue('A' . $row, $producto['codpro']);
             $sheet->setCellValue('B' . $row, $producto['nompro']);
             $sheet->setCellValue('C' . $row, $producto['prepro']);
             $sheet->setCellValue('D' . $row, $producto['preoferpro']);
             $sheet->setCellValue('E' . $row, $producto['categoria']);
             $sheet->setCellValue('F' . $row, $producto['cantidad']);
             $row++;
         }
 
         // Aplicar formato a los encabezados
         $sheet->getStyle('A1:E1')->getFont()->setBold(true);
         foreach (range('A', 'E') as $columnID) {
             $sheet->getColumnDimension($columnID)->setAutoSize(true);
         }
 
         // Crear escritor de Excel
         $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);
 
         // Definir el nombre del archivo
         $filename = 'Lista_productos '.$date.'.xlsx';
         // Enviar encabezados al navegador para forzar la descarga
         header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
         header('Content-Disposition: attachment;filename="' . $filename . '"');
         header('Cache-Control: max-age=0');
 
         // Guardar el archivo en php output stream
         $writer->save('php://output');
    }
}