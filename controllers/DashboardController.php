<?php

namespace Controllers;

use Model\Proyecto;
use Model\Usuario;
use MVC\Router;


class DashboardController {

    //m | Index Dashboard Proyectos
    public static function index(Router $router) {

        session_start();
        isAuth();

        $id = $_SESSION['id'];

        $proyectos = Proyecto::belongsTo('propietarioId', $id);

        // Renderizar al view
        $router->render('dashboard/index', [
            'titulo' => 'Proyectos',
            'proyectos' => $proyectos

        ]);
        
    }

    //m | Crear Proyecto
    public static function crear_proyecto(Router $router) {

        session_start();
        isAuth();

        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $proyecto = new Proyecto($_POST);

            // Validacion
            $alertas = $proyecto->validarProyecto();

            if(empty($alertas)) {
                // Generar un URL unica
                $proyecto->url = md5(uniqid());

                // Almacenar el creador del proyecto
                $proyecto->propietarioId = $_SESSION['id'];

                // Guardar Proyecto
                $proyecto->guardar();

                // Redireccionar
                header('Location: /proyecto?id=' . $proyecto->url );
            }

        }
        
        // Renderizar al view
        $router->render('dashboard/crear-proyecto', [
            'alertas' => $alertas,
            'titulo' => 'Crear Proyecto'

        ]);
    }

    //m | Proyecto
    public static function proyecto(Router $router) {

        session_start();
        isAuth();

        $token = $_GET['id'];
        if (!$token){
            header('Location: /dashboard');
        }

        // Revisar que la persona que visita el proyecto, es quien lo creo
        $proyecto = Proyecto::where('url', $token);
        if ($proyecto->propietarioId !== $_SESSION['id']) {
            header('Location: /dashboard');
        }
            

        // Renderizar al view
        $router->render('dashboard/proyecto', [
            'titulo' => $proyecto->proyecto

        ]);
    }
     
    //m | Perfil
    public static function perfil(Router $router) {

        session_start();
        isAuth();
        $alertas = [];

        $usuario = Usuario::find($_SESSION['id']); //BUSCA EL ID

        if($_SERVER['REQUEST_METHOD'] === 'POST') {

            $usuario->sincronizar($_POST);

            $alertas = $usuario->validar_perfil();

            if(empty($alertas)) {

                // Verificar si exista un usuario
                $existeUsuario = Usuario::where('email', $usuario->email);

                if($existeUsuario && $existeUsuario->id !== $usuario->id) {
                    // Mensaje de error, Ya existe un Usuario
                    Usuario::setAlerta('error', 'Email no válido, ya pertenese a otra cuenta.');
                    $alertas = $usuario->getAlertas();
                
                } else {
                    // Guardar el registro
                    $usuario->guardar();
    
                    Usuario::setAlerta('exito', 'Guardado Correctamente');
                    $alertas = $usuario->getAlertas();
    
                    // Asignar el nombre nuevo a la barra
                    $_SESSION['nombre'] = $usuario->nombre;
                }


            }

        }

        // Renderizar al view
        $router->render('dashboard/perfil', [
            'titulo' => 'Perfil',
            'usuario' => $usuario,
            'alertas' => $alertas

        ]);
    }

    //m | Cambiar Password
    public static function cambiar_password(Router $router) {

        session_start();
        isAuth();
        $alertas = [];

        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            $usuario = Usuario::find($_SESSION['id']);

            // Sincronizar con los datos del usuario
            $usuario->sincronizar($_POST);
            $alertas = $usuario->nuevo_password();

            if(empty($alertas)) {
                $resultado = $usuario->comprobar_password();

                if($resultado) {

                    $usuario->password = $usuario->password_nuevo;

                    // Eliminar propiedades No necesarias;
                    unset($usuario->password_actual); 
                    unset($usuario->password_nuevo);

                    // Hashear el Nuevo password
                    $usuario->hashPassword();

                    //Actualizar
                    $resultado = $usuario->guardar();

                    if($resultado) {
                        Usuario::setAlerta('exito', 'Password Guardado Correctamente');
                        $alertas = $usuario->getAlertas();
                    }

                } else {
                    Usuario::setAlerta('error', 'Password Incorrecto');
                    $alertas = $usuario->getAlertas();
                }
            }


            

        }

        // Renderizar al view
        $router->render('dashboard/cambiar-password', [
            'titulo' => 'Cambiar Password',
            'alertas' => $alertas

        ]);

    }
}