<?php

/**
 * Created by PhpStorm.
 * User: joaquin
 * Date: 25/04/17
 * Time: 15:04
 */

namespace App\Repositories\Contracts;

interface abmInterface
{
    public function store(array $data);

    public function update(array $data, $id);

    public function destroy($id);

    public function show($id);

    public function all();

}