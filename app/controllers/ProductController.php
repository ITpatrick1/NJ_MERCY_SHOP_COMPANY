<?php
class ProductController extends Controller {
    private function ensure(){ if(empty($_SESSION['user'])) redirect('?r=auth/login'); }
    public function index(){ $this->ensure(); $products = $this->model('Product')->all(); $this->view('products/index',['products'=>$products]); }
    public function create(){
        $this->ensure();
        if($_SERVER['REQUEST_METHOD']==='POST'){
            $supplier_id = $_POST['supplier_id'];
            $name = $_POST['name'];
            $quantity = (int)$_POST['quantity'];
            $unit_price = (float)$_POST['unit_price'];
            $id = $this->model('Product')->create($supplier_id, $name, $quantity, $unit_price);
            redirect('?r=product/index');
        }
        $this->view('products/create');
    }
}
