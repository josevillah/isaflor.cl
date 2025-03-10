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
            $sheet->setCellValue('E' . $row, $producto['categoria']);
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
    
    public function generateExcelCategory(){
        ob_start(); // Iniciar el buffer de salida
        if (isset($_FILES['fileExcel']) && $_FILES['fileExcel']['error'] == 0) {
            
            $this->load->model('Productos_model');
            $hayOferta = $this->input->post('ofert');

            if ($hayOferta == 0) {
                $productos = $this->Productos_model->getAllProductsExcelNoOferts();
                $ofert = '0';
            } else {
                $productos = $this->Productos_model->getAllProductsExcelYesOferts();
                $ofert = '1';
            }

            $filePath = $_FILES['fileExcel']['tmp_name'];
            $fileName = $_FILES['fileExcel']['name'];

            // Verificar la extensión del archivo
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
            if ($fileExtension === 'xlsx') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
            } elseif ($fileExtension === 'xls') {
                $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xls();
            } else {
                die(json_encode(["status" => "error", "message" => "Formato no válido."]));
            }

            try {
                $spreadsheet = $reader->load($filePath);
            } catch (\PhpOffice\PhpSpreadsheet\Reader\Exception $e) {
                die(json_encode(["status" => "error", "message" => "Error al leer el archivo: " . $e->getMessage()]));
            }

            $sheet = $spreadsheet->getActiveSheet();
            $highestRow = $sheet->getHighestRow();

            $codigo = [];
            $nombre = [];
            $cantidad = [];
            $precio = [];

            for ($row = 1; $row <= $highestRow; $row++) {
                $codigo[] = trim($sheet->getCell('G' . $row)->getValue() ?? '');
                $nombre[] = trim($sheet->getCell('H' . $row)->getValue() ?? '');
                $cantidad[] = (int) trim($sheet->getCell('N' . $row)->getValue() ?? '0');
                $precio[] = (float) trim($sheet->getCell('S' . $row)->getValue() ?? '0');
            }            

            // Crear un nuevo archivo Excel
            $reportSpreadsheet = new Spreadsheet();
            $reportSheet = $reportSpreadsheet->getActiveSheet();

            // Encabezados
            $reportSheet->fromArray(
                ['Código', 'Nombre', 'Precio Web', 'Precio Sistema', 'Diferencia', 'Tiene Oferta', 'Stock'],
                null,
                'A1'
            );

            $reportSheet->getStyle('A1:G1')->getFont()->setBold(true);
            foreach (range('A', 'G') as $columnID) {
                $reportSheet->getColumnDimension($columnID)->setAutoSize(true);
            }

            $row = 2;

            $n = 0;

            foreach ($productos as $producto) {

                $codigoWeb = $producto['codpro'];
                $precioWeb = $hayOferta == 0 ? $producto['prepro'] : $producto['preoferpro'];
                $stock = $producto['cantidad'];
                $categoria = (int) $producto['idsubcat'];

                if ($codigoWeb !== '' && in_array($codigoWeb, $codigo)) {

                    $indiceExcel = array_search($codigoWeb, $codigo);
                    $precioExcel = $precio[$indiceExcel];
                    
                    // Calcular diferencia de precio
                    $diferencia = ($precioWeb != $precioExcel) ? ($precioWeb - $precioExcel) : 0;
                    //if ($diferencia == 0) continue;
                    
                    // Ajustar stock
                    if (in_array($categoria, [41, 42, 43, 44])) { // Construcción
                        $stock = ($cantidad[$indiceExcel] >= 50) ? '1' : '0';
                    } elseif (in_array($categoria, [55, 59, 70, 72])) { // Terminaciones
                        $stock = ($cantidad[$indiceExcel] >= 10) ? '1' : '0';
                    } elseif (in_array($categoria, [19, 20, 21, 24, 25, 61])) { // Calefaccion
                        $stock = ($cantidad[$indiceExcel] >= 1) ? '1' : '0';
                    } else { // Otras categorías
                        $stock = ($cantidad[$indiceExcel] >= 2) ? '1' : '0';
                    }

                    // Agregar datos a la fila
                    $reportSheet->fromArray(
                        [$codigoWeb, $nombre[$indiceExcel], $precioWeb, $precioExcel, $diferencia, $ofert, $stock],
                        null,
                        'A' . $row
                    );

                    $row++;
                }
            }

            // Preparar descarga del archivo
            $writer = new Xlsx($reportSpreadsheet);
            $date = date('Y-m-d');

            ob_end_clean(); // Eliminar cualquier salida previa para evitar errores de headers

            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="Reporte_Precios_' . $date . '.xlsx"');
            header('Cache-Control: max-age=0');
            
            $writer->save('php://output');
            exit;
        } else {
            echo json_encode(["status" => "error", "message" => "No se pudo cargar el archivo."]);
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
    
    function reportNewProducts(){
        // Verifica que se haya cargado un archivo
        if (isset($_FILES['fileExcel']) && $_FILES['fileExcel']['error'] == 0) {
            $filePath = $_FILES['fileExcel']['tmp_name'];
            $fileName = $_FILES['fileExcel']['name'];

            // Detectar el tipo de archivo según la extensión
            $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);

            // Seleccionar el lector adecuado según la extensión
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
            $highestRow = $sheet->getHighestRow();

            // Leer los datos del archivo Excel
            $data = [];
            for ($row = 9; $row <= $highestRow; $row++) {
                $codigo = $sheet->getCell('G' . $row)->getValue();
                $nombre = $sheet->getCell('H' . $row)->getValue();
                $categoria = $sheet->getCell('D' . $row)->getValue();
                $subcategoria = $sheet->getCell('F' . $row)->getValue();
                $precio = $sheet->getCell('S' . $row)->getValue();
                $cantidad = $sheet->getCell('N' . $row)->getValue();

                if ($codigo != '') {
                    $data[] = [
                        'codigo' => $codigo,
                        'nombre' => $nombre,
                        'categoria' => $categoria,
                        'subcategoria' => $subcategoria,
                        'precio' => $precio,
                        'stock' => $cantidad,
                    ];
                }
            }

            // Obtener los productos del sistema
            $this->load->model('Productos_model');
            $productos = $this->Productos_model->getAllProductsExcel();

            // Crear un array con los códigos de los productos del sistema
            $codigosWeb = array_column($productos, 'codpro');

            // Filtrar los productos no presentes en la página web
            $productosNoEnWeb = [];
            foreach ($data as $productoSistema) {
                if (!in_array($productoSistema['codigo'], $codigosWeb)) {
                    $productosNoEnWeb[] = $productoSistema;
                }
            }

            // Crear un nuevo archivo Excel
            $newSpreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
            $newSheet = $newSpreadsheet->getActiveSheet();

            // Escribir encabezados
            $newSheet->setCellValue('A1', 'Código');
            $newSheet->setCellValue('B1', 'Nombre de producto');
            $newSheet->setCellValue('C1', 'Categoría');
            $newSheet->setCellValue('D1', 'Subcategoría');
            $newSheet->setCellValue('E1', 'Precio');
            $newSheet->setCellValue('F1', 'Stock');

            // Estilos
            $newSheet->getStyle('A1:F1')->getFont()->setBold(true);
            foreach (range('A', 'F') as $columnID) {
                $newSheet->getColumnDimension($columnID)->setAutoSize(true);
            }

            // Escribir datos de los productos no presentes en la página web
            $rowNum = 2;
            foreach ($productosNoEnWeb as $productoDos) {
                $newSheet->setCellValue('A' . $rowNum, $productoDos['codigo']);
                $newSheet->setCellValue('B' . $rowNum, $productoDos['nombre']);
                $newSheet->setCellValue('C' . $rowNum, $productoDos['categoria']);
                $newSheet->setCellValue('D' . $rowNum, $productoDos['subcategoria']);
                $newSheet->setCellValue('E' . $rowNum, $productoDos['precio']);
                $newSheet->setCellValue('F' . $rowNum, $productoDos['stock']);
                $rowNum++;
            }

            // Descargar el archivo Excel
            $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($newSpreadsheet);
            $date = date('Y-m-d');
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment; filename="Reporte_Productos_Nuevos_' . $date . '.xlsx"');
            header('Cache-Control: max-age=0');
            $writer->save('php://output');
        } else {
            $response['status'] = 'error';
            $response['message'] = "No se pudo cargar el archivo.";
            echo json_encode($response);
        }
    }
}
