<?php

class RegistrarPsicologo extends Controller{
    function __construct(){
        parent::__construct();
        $this->view->mensaje = "";
        #echo '<p>Nuevo controlador main</p>';
    }

    function render(){
        $this->view->render('psicologos/index');
    }

    function registrarPsicologo(){
        #echo 'alumno cerado';
        $documentoid = $_POST['documentoid'];
        $fechaexp = $_POST['fechaexp'];
        $fechaven = $_POST['fechaven'];
        $usuario = $_POST['usuario'];
        $password = $_POST['password'];
        $correo = $_POST['correo'];
        $nombres = $_POST['nombre'];
        $apellidos = $_POST['apellidos'];
        $telefono = $_POST['telefono'];
        $hojavida = $_FILES['hojavida'];

        $mensaje = "";
        if($this->model->isPdf($hojavida)){
            if($this->model->insertDocumento(['documentoid' => $documentoid, 'fechaexp' => $fechaexp, 'fechaven' => $fechaven])){
                #echo "nuevo alumno";
                if($this->model->insertUsuario(['documentoid' => $documentoid, 'usuario' => $usuario, 'password' => $password, 'correo' => $correo, 'tipo' => 'psicologo'])){
                    #echo "nuevo alumno";
                }
                if($this->model->insertPsicologo(['documentoid' => $documentoid, 'nombres' => $nombres, 'apellidos' => $apellidos, 'telefono' => $telefono, 'hojavida' => $this->model->savePdf($hojavida, $documentoid)])){
                    #echo "nuevo alumno";
                }
                $mensaje = "Nuevo cliente registrado";
            }else{
                $mensaje = "El documento ya existe";
            }
        }else{
            $mensaje = "El archivo debe ser pdf";
        }

        $this->view->mensaje = $mensaje;
        $this->render();
    }
}

?>