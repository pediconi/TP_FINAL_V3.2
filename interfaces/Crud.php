<?php namespace interfaces;

interface Crud{

    public function create($object);  // recibe un objeto como parametro 
    public function read($v);         // leer algo con TAL id
    public function update($id, $object);
    public function delete($id);
}