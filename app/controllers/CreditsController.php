<?php
/**
 * CreditsController - Redirects to CreditController
 * This controller exists to handle plural route names
 */
class CreditsController extends Controller {
    
    public function index() {
        // Redirect to the correct controller
        redirect('?r=credit/index');
    }
    
    public function create() {
        redirect('?r=credit/create');
    }
    
    public function approve() {
        redirect('?r=credit/approve&' . http_build_query($_GET));
    }
    
    public function reject() {
        redirect('?r=credit/reject');
    }
    
    public function editStatus() {
        redirect('?r=credit/editStatus');
    }
}
