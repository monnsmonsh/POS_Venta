<?php
class Compras extends Controller{
	//Para que la seccion funcione debe inicializarlo dentro de contructor
	public function __construct() 
	{
		//iniciamos seccion
        session_start();
		
        //cargamos el constructor de la instancia
        parent::__construct();
    }
    public function index()
	{
		if (empty($_SESSION['activo'])) {
            header("location: ".base_url);
        }
		//mostramos la VISTA
		$this->views->getView($this, "index");
	}

	public function buscarCodigo($cod)
	{
		//print_r($cod);
		$data = $this->model->getProCod($cod);
		//print_r($data);
		//die();
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
		die();
	}

	public function ingresar()
	{
		//print_r($_POST);
		$id = $_POST['id'];
		$datos = $this->model->getProductos($id);
		//print_r($datos);

		//
		$id_producto = $datos['id'];
		$id_usuario = $_SESSION['id_usuario'];
		$precio = $datos['precio_compra'];
		$cantidad = $_POST['cantidad'];
		

		//funcion para aumentar cant de un mismo pro
		$comprobar = $this->model->consultarDetalle($id_producto, $id_usuario);
		if(empty($comprobar)){
			$sub_total = $precio * $cantidad;
			//almacenamos lo datos
			$data = $this->model->registrarDetalle($id_producto, $id_usuario, $precio, $cantidad, $sub_total);
			if($data == "ok"){
				$msg = "ok";
			}else{
				$msg = "Error al ingresar el producto";
			}
		}else{
			$total_cantidad = $comprobar['cantidad'] + $cantidad;
			$sub_total = $total_cantidad * $precio;
			//almacenamos lo datos
			$data = $this->model->actualizarDetalle($precio, $total_cantidad, $sub_total, $id_producto, $id_usuario);
			if($data == "modificado"){
				$msg = "modificado";
			}else{
				$msg = "Error al modificar el producto";
			}
		}
		echo json_encode($msg, JSON_UNESCAPED_UNICODE);
		die();
	}

	public function listar()
	{
		$id_usuario = $_SESSION['id_usuario'];
		$data['detalle_compra'] = $this->model->getDetalle($id_usuario);
		$data['total_pagar'] = $this->model->calcularCompra($id_usuario);
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
		die();
	}

	public function delete($id)
	{
		//print_r($id);
		$data = $this->model->deleteDetalle($id);
		//verificamos que el registro ha sido eliminado
		if($data == 'ok'){
			//creamos la var $msg para crear un val en funciones
			$msg = 'ok';
		}else{
			$msg = 'error';
		}
		//retornamos la var $msg
		echo json_encode($msg, JSON_UNESCAPED_UNICODE);
		die();
	}

	public function registrarCompra()
	{
		$id_usuario = $_SESSION['id_usuario'];
		$total = $this->model->calcularCompra($id_usuario);
		$data =$this->model->registrarCompra($total['total']);
		if($data == "ok"){
			$detalle = $this->model->getDetalle($id_usuario);
			$id_compra = $this->model->id_compra();
			foreach ($detalle as $row) {
				$cantidad = $row['cantidad'];
				$precio = $row['precio'];
				$id_pro = $row['id_producto'];
				$sub_total = $cantidad * $precio;
				$this->model->registrarDetalleCompra($id_compra['id'], $id_pro, $cantidad, $precio, $sub_total);
			}
			$vaciar = $this->model->vaciarDetalle($id_usuario);
			if($vaciar =="ok"){
				$msg = array('msg' => 'ok', 'id_compra' => $id_compra['id']);
			}
			

		}else{
			$msg = 'Error al realizar la compra';
		}
		//retornamos la var $msg
		echo json_encode($msg);
		die();
	}

	public function generarPdf($id_compra)
	{
		$empresa = $this->model->getEmpresa();
		$productos = $this->model->getProCompra($id_compra);
		//print_r($productos);
		//exit;

		require('Libraries/fpdf/fpdf.php');

		$pdf = new FPDF('P','mm',array(80,200));
		$pdf->AddPage();
		//quitar magenes
		$pdf->SetMargins(4, 0, 0);

		$pdf->setTitle('Reporte Compra');
		$pdf->SetFont('Arial','B',14);
		$pdf->Cell(60, 10, utf8_decode($empresa['nombre']), 0, 1, 'C');
		$pdf->Image(base_url . 'Assets/img/logo-empresa.jpg',58, 20, 18, 18);

		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(16, 5, 'Ruc:', 0, 0, 'L');
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(20, 5, $empresa['ruc'], 0, 1, 'L');
		

		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(16, 5, utf8_decode('Teléfono: '), 0, 0, 'L');
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(20, 5, $empresa['telefono'], 0, 1, 'L');

		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(16, 5, utf8_decode('Dirección: '), 0, 0, 'L');
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(20, 5, utf8_decode($empresa['direccion']), 0, 1, 'L');

		$pdf->SetFont('Arial','B',9);
		$pdf->Cell(16, 5, utf8_decode('Folio: '), 0, 0, 'L');
		$pdf->SetFont('Arial','',9);
		$pdf->Cell(20, 5, $id_compra, 0, 1, 'L');

		$pdf->Ln();

		//encabezados de productos
		$pdf->SetFont('Arial','B',7);
		$pdf->SetFillColor(0,0,0);
		$pdf->SetTextColor(255,255,255);
		$pdf->Cell(6, 5, 'Cnt', 0, 0, 'L',true);
		$pdf->Cell(46, 5, utf8_decode('Descripción: '), 0, 0, 'L',true);
		$pdf->Cell(8, 5, 'P.U', 0, 0, 'L',true);
		$pdf->Cell(13, 5, 'SubTotal', 0, 1, 'L',true);


		$pdf->SetFont('Arial','',7);
		$pdf->SetTextColor(0,0,0);
		$total = 0.00;
		foreach ($productos as $row){
			$total = $total + $row['sub_total'];
			$pdf->Cell(6, 5, $row['cantidad'], 0, 0, 'L');
			$pdf->Cell(46, 5, utf8_decode($row['descripcion']), 0, 0, 'L');
			$pdf->Cell(9, 5, $row['precio'], 0, 0, 'L');
			$pdf->Cell(15, 5, number_format($row['sub_total'], 2, '.',','), 0, 1, 'L');	
		}

		$pdf->Ln();
		$pdf->SetFont('Arial','B',7);
		$pdf->Cell(59, 5,'Total a pagar',0, 0, 'R' );
		$pdf->SetFont('Arial','',7);
		$pdf->Cell(11, 5, number_format($total, 2, '.',','),0, 1, 'R' );



		$pdf->Output();
	}

	public function historial()
	{
		//mostramos la VISTA
		$this->views->getView($this, "historial");
	}
	public function listar_historial()
	{
		$data = $this->model->getHistorialcompras();

		//generamos los botones de editar y eliminar
		for($i=0; $i< count($data); $i++){
			//valdiacion de estado de usuario
			$data[$i]['acciones'] = '<div>
            	<a class="btn btn-danger" href="'.base_url."Compras/generarPdf/" . $data[$i]['id'] . '" target="_blank">
            		<i class="fas fa-file-pdf"></i>
            	</a>
            <div/>';
		}

		//retornamos la var $data
		echo json_encode($data, JSON_UNESCAPED_UNICODE);
		die();
	}
}
?>