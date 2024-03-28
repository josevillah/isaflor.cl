<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Contact extends CI_Controller {
	
	public function __construct() {
        parent::__construct();
        // Carga el helper url
        $this->load->helper('url');
        $this->load->library('email');
    }

    function index(){
        $this->load->model('Categorias_model');
        $categorias = $this->Categorias_model->getCategorias();

        $fecha_actual = date("dmY:H:i:s");
        $title = "Contacto";

        $this->load->view('headers/header_basic', array('title' => $title, 'fecha_actual' => $fecha_actual));
        $this->load->view('components/menu', array('categorias' => $categorias));
        $this->load->view('bodys/contact');
        $this->load->view('components/buttonUp');
        $this->load->view('components/alerts');
        $this->load->view('footers/foot');
        $this->load->view('footers/footer_product', array('fecha_actual' => $fecha_actual));
    }

    function sendEmail(){
        $config = array(
            'protocol' => 'smtp',
            'smtp_host' => 'mail.isaflor.cl',
            'smtp_port' => 465,
            'smtp_user' => 'info@isaflor.cl',
            'smtp_pass' => 'WqvXdSa@(h7W',
            'smtp_crypto' => 'ssl',
            'charset' => 'UTF-8', // Configura la codificación de caracteres UTF-8
            'mailtype' => 'html',
            'newline' => "\r\n"
        );
    
        $this->email->initialize($config);
    
        $data = $this->input->get();
        $this->email->from('info@isaflor.cl', 'Isaflor');
        $this->email->to('isaflor@isaflor.cl');
    
        $this->email->subject($data['asunto']);
        $this->email->message('
            <!DOCTYPE html>
            <html lang="es">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Email</title>
                <style>
                    body{
                        display: flex;
                        flex-direction: column;
                        justify-content: center;
                        align-items: center;
                        padding: 20px;
                    }

                    .container{
                        width: 50%;
                        padding: 20px;
                        border: 1px solid #ccc;
                        border-radius: 5px;
                        display: flex;
                        flex-direction: column;
                    }

                    .container h1{
                        text-align: center;
                        font-size: 40px;
                    }

                    .container p{
                        margin: 10px 0;
                        font-weight: bold;
                        font-size: 20px;
                    }

                    .container p span{
                        font-weight: normal;
                        font-size: 18px;
                    }

                    p.mensaje{
                        font-size: 18px;
                        font-weight: normal;
                        display: flex;
                        flex-direction: column;
                        gap: 10px;
                    }
                </style>
            </head>
            <body>
                <div class="container">
                    <h1>Contacto.</h1>
                    <p>Nombre: <span>' . $data['nombre'] . '</span></p>
                    <p>Correo: <span>' . $data['email'] . '</span></p>
                    <p>Mensaje:</p>
                    <p class="mensaje">' . $data['mensaje'] . '</p>
                </div>
            </body>
            </html>
        ');

    
        if($this->email->send()){
            echo json_encode(true);
        }else{
            echo json_encode(false);
        }
    }    

}