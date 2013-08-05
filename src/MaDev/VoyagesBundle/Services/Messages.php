<?php
namespace MaDev\VoyagesBundle\Services;

use Symfony\Component\HttpFoundation\Session\Session;

class Messages
{
    protected $message;
    protected $session;
    
    public function __construct(Session $session) {
        $this->session = $session;
    }
    
    public function SuccessMessage($message){
        
        $this->session->getFlashBag()->add('success', $message);
    }
    
    public function FailMessage($message){
        
        $this->session->getFlashBag()->add('error', $message);
        
    }
}
?>
