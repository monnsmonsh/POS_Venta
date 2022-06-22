<?php
class Usuarios extends Controller
{
	public function index()
	{
		//accedemos a la accion getUsuario
		print_r($this->model->getUsuario());

		
	}
}

?>