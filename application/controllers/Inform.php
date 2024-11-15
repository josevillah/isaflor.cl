<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

class Inform extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->helper('url');
        $this->load->helper('file');
        $this->load->library('session');
        require_once FCPATH . 'vendor/autoload.php';

        // Verificar si la interfaz IReadFilter existe
        if (!interface_exists('PhpOffice\PhpSpreadsheet\Reader\IReadFilter')) {
            die('La interfaz IReadFilter no se encuentra. Verifica la carga de autoload.php.');
        }

        ini_set('memory_limit', '1024M'); // Aumenta el límite de memoria a 1GB
        ini_set('upload_max_filesize', '30M');
        ini_set('post_max_size', '30M');
        ini_set('max_file_uploads', '20');
        set_time_limit(300);
    }

    function generateExcel() {
        $this->load->model('Productos_model');
        $productos = $this->Productos_model->getAllProductsExcel();
        $date = $this->Productos_model->getDateReducida();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $sheet->setCellValue('A1', 'Código');
        $sheet->setCellValue('B1', 'Nombre');
        $sheet->setCellValue('C1', 'Precio');
        $sheet->setCellValue('D1', 'Precio oferta');
        $sheet->setCellValue('E1', 'Categoría');
        $sheet->setCellValue('F1', 'Stock');

        $row = 2;
        foreach ($productos as $producto) {
            $sheet->setCellValue('A' . $row, $producto['codpro']);
            $sheet->setCellValue('B' . $row, $producto['nompro']);
            $sheet->setCellValue('C' . $row, $producto['prepro']);
            $sheet->setCellValue('D' . $row, $producto['preoferpro']);
            // $sheet->setCellValue('E' . $row, $producto['categoria']);
            $sheet->setCellValue('F' . $row, $producto['cantidad']);
            $row++;
        }

        $sheet->getStyle('A1:F1')->getFont()->setBold(true);
        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        $writer = new Xlsx($spreadsheet);

        $filename = 'Lista_productos ' . $date . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    function generateReportPrice($spreadsheet, $row, $codigo, $precioWeb, $precioSistema, $nombre, $diferencia, $stock, $ofert) {
        $sheet = $spreadsheet->getActiveSheet();
        
        // Insertar datos en la fila actual
        $sheet->setCellValue('A' . $row, $codigo);
        $sheet->setCellValue('B' . $row, $nombre);
        $sheet->setCellValue('C' . $row, $precioWeb);
        $sheet->setCellValue('D' . $row, $precioSistema);
        $sheet->setCellValue('E' . $row, $diferencia);
        $sheet->setCellValue('F' . $row, $ofert); // Ya que eliminamos el precio oferta, siempre marcamos como sin oferta
        $sheet->setCellValue('G' . $row, $stock);
    }
    
    function generateExcelCategory() {
        if (isset($_FILES['fileExcel']) && $_FILES['fileExcel']['error'] == 0) {
    
            $this->load->model('Productos_model');
            $hayOferta = $this->input->post('ofert');
            if($hayOferta == 0):
                $productos = $this->Productos_model->getAllProductsExcelNoOferts();
                $ofert = '0';
            else:
                $productos = $this->Productos_model->getAllProductsExcelYesOferts();
                $ofert = '1';
            endif;
    
            $filePath = $_FILES['fileExcel']['tmp_name'];
            $fileName = $_FILES['fileExcel']['name'];
            
            // Detectar el tipo de archivo según la extensión
            $fileExtension = pathinfo($_FILES['fileExcel']['name'], PATHINFO_EXTENSION);
    
            // Seleccionar el lector adecuado según el tipo de archivo
            if ($fileExtension === 'xlsx') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            } elseif ($fileExtension === 'xls') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                die("El archivo no es un archivo Excel válido (.xls o .xlsx).");
            }
    
            // Cargar el archivo Excel
            try {
                $spreadsheet = $reader->load($filePath);
            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                die("Error al leer el archivo Excel: " . $e->getMessage());
            }
    
            $sheet = $spreadsheet->getActiveSheet();
            $highestRow = $sheet->getHighestRow();
            
            // Leer las columnas necesarias
            $codigo = [];
            $nombre = [];
            $cantidad = [];
            $precio = [];
    
            for ($row = 1; $row <= $highestRow; $row++) {
                $codigo[] = $sheet->getCell('G' . $row)->getValue();
                $nombre[] = $sheet->getCell('H' . $row)->getValue();
                $cantidad[] = $sheet->getCell('N' . $row)->getValue();
                $precio[] = $sheet->getCell('S' . $row)->getValue();
            }
    
            // Crear un nuevo archivo Excel para el reporte
            $reportSpreadsheet = new Spreadsheet();
            $reportSheet = $reportSpreadsheet->getActiveSheet();
    
            // Encabezados
            $reportSheet->setCellValue('A1', 'Código');
            $reportSheet->setCellValue('B1', 'Nombre de producto');
            $reportSheet->setCellValue('C1', 'Precio web');
            $reportSheet->setCellValue('D1', 'Precio sistema');
            $reportSheet->setCellValue('E1', 'Diferencia monetaria');
            $reportSheet->setCellValue('F1', 'Tiene oferta');
            $reportSheet->setCellValue('G1', 'Stock');
    
            // Estilos
            $reportSheet->getStyle('A1:G1')->getFont()->setBold(true);
            foreach (range('A', 'G') as $columnID) {
                $reportSheet->getColumnDimension($columnID)->setAutoSize(true);
            }
            
            $row = 2;
    
            foreach ($productos as $producto) {
                $codigoWeb = $producto['codpro'];
                if($hayOferta == 0):
                    $precioWeb = $producto['prepro'];
                else:
                    $precioWeb = $producto['preoferpro'];
                endif;
                $stock = $producto['cantidad'];
                $categoria = $producto['idsubcat'];
    
                if ($codigoWeb !== '' && in_array($codigoWeb, $codigo)) {
                    $indiceExcel = array_search($codigoWeb, $codigo);
    
                    if ($codigoWeb === $codigo[$indiceExcel]) {
                        $precioExcel = $precio[$indiceExcel];
    
                        // Verificar diferencias solo con precio web
                        $diferencia = 0;
                        
                        if ($precioWeb != $precioExcel) {
                            $diferencia = $precioWeb - $precioExcel;
                        } else {
                            $diferencia = 0; // No hay diferencia si el precio web coincide con el del Excel
                        }
                        
                        // Si la diferencia es 0, omitimos la entrada
                        if ($diferencia == 0) {
                            continue;
                        }                        
    
                        // Ajustar stock según categoría y cantidad
                        if (in_array($categoria, ['41', '42', '43', '44'])) { // Construcción
                            $stock = ($cantidad[$indiceExcel] >= 15) ? '1' : '0';
                        } elseif (in_array($categoria, ['55', '59', '70', '72'])) { // Terminaciones
                            $stock = ($cantidad[$indiceExcel] >= 10) ? '1' : '0';
                        } else { // Otras categorías
                            $stock = ($cantidad[$indiceExcel] >= 2) ? '1' : '0';
                        }
    
                        // Generar fila en el reporte
                        $this->generateReportPrice(
                            $reportSpreadsheet,
                            $row,
                            $codigoWeb,
                            $precioWeb,
                            $precioExcel,
                            $nombre[$indiceExcel],
                            $diferencia,
                            $stock,
                            $ofert
                        );
                        $row++;
                    }
                }
            }
    
            $writer = new Xlsx($reportSpreadsheet);
            $date = date('Y-m-d');
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="Reporte_Precios_' . $date . '.xlsx"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
    
        } else {
            echo "No se pudo cargar el archivo.";
        }
    }
    
    

    function updateProductForExcel() {
        $response = [];
    
        // Verifica que se haya cargado un archivo
        if (isset($_FILES['fileExcel']) && $_FILES['fileExcel']['error'] == 0) {
            $filePath = $_FILES['fileExcel']['tmp_name'];
            $fileName = $_FILES['fileExcel']['name'];
            
            $hayStock = $this->input->post('updateProducts');

            // Detectar el tipo de archivo según la extensión
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    
            // Seleccionar el lector adecuado según el tipo de archivo
            if ($fileExtension === 'xlsx') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            } elseif ($fileExtension === 'xls') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $response['status'] = 'error';
                $response['message'] = "El archivo no es un archivo Excel válido (.xls o .xlsx).";
                echo json_encode($response);
                return;
            }
    
            // Cargar el archivo Excel
            try {
                $spreadsheet = $reader->load($filePath);
            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                $response['status'] = 'error';
                $response['message'] = "Error al leer el archivo Excel: " . $e->getMessage();
                echo json_encode($response);
                return;
            }
    
            // Obtener la hoja activa
            $sheet = $spreadsheet->getActiveSheet();
            
            // Obtener el número máximo de filas y columnas
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
    
            // Iterar sobre cada fila y columna, empezando desde la fila 1 (asumiendo encabezados en la primera fila)
            $data = []; // Para almacenar los datos si deseas manipularlos más adelante
            for ($row = 2; $row <= $highestRow; $row++) { // Comienza en la fila 2 si la fila 1 tiene encabezados
                $codigo = $sheet->getCell('A' . $row)->getValue(); // Columna G
                if($hayStock == 1 || $hayStock == 2):
                    $cantidad = $sheet->getCell('G' . $row)->getValue(); // Columna N
                endif;
                $precio = $sheet->getCell('D' . $row)->getValue(); // Columna S
                $tieneOferta = $sheet->getCell('F' . $row)->getValue(); // Columna F
                
                if($hayStock == 0):
                    // Guardar los datos en un array
                    $data[] = [
                        'codigo' => $codigo,
                        'precio' => $precio,
                        'oferta' => $tieneOferta,
                        'tipo' => 0,
                    ];
                elseif($hayStock == 1):
                        // Guardar los datos en un array
                        $data[] = [
                            'codigo' => $codigo,
                            'stock' => $cantidad,
                            'tipo' => 1,
                        ];
                elseif($hayStock == 2):
                        // Guardar los datos en un array
                        $data[] = [
                            'codigo' => $codigo,
                            'precio' => $precio,
                            'stock' => $cantidad,
                            'oferta' => $tieneOferta,
                            'tipo' => 2,
                        ];
                endif;
            }
    
            // Crear respuesta JSON con los datos
            $response['status'] = 'success';
            $response['data'] = $data;
            $this->load->model('Productos_model');
            if($this->Productos_model->updateProductForExcel($data)):
                echo json_encode(true);
            else:
                echo json_encode(false);
            endif;
            
        } else {
            $response['status'] = 'error';
            $response['message'] = "No se pudo cargar el archivo.";
            echo json_encode($response);
        }
    }

    function cargarDatos(){
        $this->load->view('bodys/ejemplo');
    }
    
    // se creo para cargar actualizaciones de productos por listados excel
    function nuevo(){
        if (isset($_FILES['excel']) && $_FILES['excel']['error'] == 0) {
            $filePath = $_FILES['excel']['tmp_name'];
            $fileName = $_FILES['excel']['name'];
            
            $hayStock = $this->input->post('updateProducts');

            // Detectar el tipo de archivo según la extensión
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
    
            // Seleccionar el lector adecuado según el tipo de archivo
            if ($fileExtension === 'xlsx') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            } elseif ($fileExtension === 'xls') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                $response['status'] = 'error';
                $response['message'] = "El archivo no es un archivo Excel válido (.xls o .xlsx).";
                echo json_encode($response);
                return;
            }
    
            // Cargar el archivo Excel
            try {
                $spreadsheet = $reader->load($filePath);
            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                $response['status'] = 'error';
                $response['message'] = "Error al leer el archivo Excel: " . $e->getMessage();
                echo json_encode($response);
                return;
            }

            // Obtener la hoja activa
            $sheet = $spreadsheet->getActiveSheet();
            
            // Obtener el número máximo de filas y columnas
            $highestRow = $sheet->getHighestRow();
            $highestColumn = $sheet->getHighestColumn();
    
            // Iterar sobre cada fila y columna, empezando desde la fila 1 (asumiendo encabezados en la primera fila)
            $data = []; // Para almacenar los datos si deseas manipularlos más adelante
            for ($row = 2; $row <= $highestRow; $row++) { // Comienza en la fila 2 si la fila 1 tiene encabezados
                $codigo = $sheet->getCell('A' . $row)->getValue(); // Columna G
                $nombre = $sheet->getCell('B' . $row)->getValue(); // Columna G


                $data[] = [
                    'codigo' => $codigo,
                    'nombre' => $nombre,
                ];
            }

            $this->load->model('Productos_model');
            $this->Productos_model->nuevo($data);
        }
    }

}
