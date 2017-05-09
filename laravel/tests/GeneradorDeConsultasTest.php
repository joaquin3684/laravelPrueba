<?php

use PHPUnit\Framework\TestCase;

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Repositories\Eloquent\VentasRepositorio as Generador;

use App\Ventas;
class GeneradorDeConsultasTest extends TestCase
{
    use DatabaseMigrations;

    private $generador;
    private $ventas;
    public function setUp()
    {
        parent::setUp();
        $this->generador = new Generador();
        $this->ventas = new Ventas();

    }

    public function testGenerarConsulta()
    {
        $array = collect(['organismos.nombre', 'proovedores.nombre', 'cuotas.nombre']);
        $actual = $this->generador->generarConsulta($array, 'ventas');
        $expected = collect(['socios', 'organismos', 'productos', 'proovedores', 'cuotas']);
        $this->assertEquals($expected, $actual);
    }

    public function testBuscarPadres()
    {
        $array = collect();
        $col = collect(['organismos', 'socios']);
        $array->push('organismos');
        $this->generador->buscarPadres('organismos', $array);
        $this->assertEquals($col, $array);
    }

    public function testConsultaDePrueba()
    {
        $a = $this->generador->getVentas();
        $this->assertEquals('fd', 'f');
    }


}
