<?php 

namespace Model;


class Usuario extends ActiveRecord {

    // Base de datos
    protected static $tabla = 'usuarios';
    protected static $columnasDB = ['id', 'nombre', 'email', 'password', 'token', 'confirmado'];

    // Contructor 
    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null;
        $this->nombre = $args['nombre'] ?? '';
        $this->email = $args['email'] ?? '';
        $this->password = $args['password'] ?? '';
        $this->password2 = $args['password2'] ?? '';
        $this->password_actual = $args['password_actual'] ?? '';
        $this->password_nuevo = $args['password_nuevo'] ?? '';
        $this->token = $args['token'] ?? '';
        $this->confirmado = $args['confirmado'] ?? 0;

        
    }
    
    //m | Validar el login de Usuarios
    public function validarLogin() {

        if(!$this->email) {
            self::$alertas['error'][] = 'El Email del Usuario es Obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no valido';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'El Password no puede ir vacio';
        }

        return self::$alertas;
    }
    

    //m | Validacion para cuentas nuevas
    public function validarNuevaCuenta() {

        if(!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre del Usuario es Obligatorio';
        }
        if(!$this->email) {
            self::$alertas['error'][] = 'El Email del Usuario es Obligatorio';
        }
        if(!$this->password) {
            self::$alertas['error'][] = 'El Password no puede ir vacio';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El Password debe contener al menos 6 caracteres';
        }
        if($this->password !== $this->password2) {
            self::$alertas['error'][] = 'Los Password son diferentes';
        }

        return self::$alertas;
    }

    //m |  Valida un Email
    public function validarEmail() {

        if(!$this->email) {
            self::$alertas['error'][] = 'El Email del Usuario es Obligatorio';
        }
        if(!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
            self::$alertas['error'][] = 'Email no valido';
        }
        return self::$alertas;
    }

    //m | Valida el Perfil
    public function validar_perfil() {

        if(!$this->nombre) {
            self::$alertas['error'][] = 'El Nombre del Usuario es Obligatorio';
        }
        if(!$this->email) {
            self::$alertas['error'][] = 'El Email del Usuario es Obligatorio';
        }
        return self::$alertas;

    }

    //m| Validar Password
    public function validarPassword() {

        if(!$this->password) {
            self::$alertas['error'][] = 'El Password no puede ir vacio';
        }
        if(strlen($this->password) < 6) {
            self::$alertas['error'][] = 'El Password debe contener al menos 6 caracteres';
        }
        
        return self::$alertas;
    }

    //m | Verificar Cambiar Password
    public function nuevo_password() : array {

        if(!$this->password_actual) {
            self::$alertas['error'][] = 'El Password actual no puede ir vacio';
        }
         if(!$this->password_nuevo) {
            self::$alertas['error'][] = 'El Password Nuevo no puede ir vacio';
        }

        if(strlen($this->password_nuevo) < 6) {
            self::$alertas['error'][] = 'El Password Debe contener al menos 6 caracteres';
        }

        return self::$alertas;

    }

    //m | Comprobar los passwords
    public function comprobar_password() : bool {
        return password_verify($this->password_actual, $this->password);

      
    }

    //m | Hashea el Password
    public function hashPassword() : void {

        $this->password = password_hash($this->password, PASSWORD_BCRYPT);
    }

    // m | Generar un Token
    public function crearToken() : void {
        $this->token = uniqid();
    }


}