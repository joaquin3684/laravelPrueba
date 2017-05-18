<?php
use PHPUnit\Framework\TestCase;

use App\Repositories\Eloquent\Mapper\CuotasMapper;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CuotasMapperTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testPuto()
    {
        $cuota = new CuotasMapper(1);
        $h = $cuota->movimientos();
        $h = "hola";
    }
}
