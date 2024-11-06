<?php
namespace Model;

class Sucursal extends ActiveRecord {
    protected static $tabla = 'sucursal';
    protected static $columnasDB = ['id', 'nombre', 'direccion'];

    public $id;
    public $nombre;
    public $direccion;

    public static function obtenerSucursales() {
        return self::consultarSQL("SELECT id, nombre FROM " . self::$tabla);
    }

    public static function obtenerDireccionPorId($id) {
        $resultado = self::consultarSQL("SELECT direccion FROM " . self::$tabla . " WHERE id = ${id} LIMIT 1");
        return !empty($resultado) ? $resultado[0]->direccion : null;
    }
}
