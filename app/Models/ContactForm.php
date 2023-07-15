<?php
namespace App\Models;


class ContactForm extends FormCreator {
    private $name;
    private $email;
    private $message;
  
    public function __construct($name, $email, $message) {
      $this->name = $name;
      $this->email = $email;
      $this->message = $message;
    }
  
    public function validate() {
      // Vérifier si les champs requis sont vides
      if (empty($this->name) || empty($this->email) || empty($this->message)) {
        return false; 
      }
  
      // Vérifier si l'adresse e-mail est valide
      if (!filter_var($this->email, FILTER_VALIDATE_EMAIL)) {
        return false; 
      }
  
      return true; // SI les deux if sont ok
    }
  
    public function sendEmail() {
      // Construction de l'email
      $to = 'gouzi974@gmail.com';
      $subject = 'Nouveau message de contact';
      $message = "Nom : " . $this->name . "\n";
      $message .= "E-mail : " . $this->email . "\n";
      $message .= "Message : " . $this->message . "\n";
  
      // Envoi de l'e-mail
      if (mail($to, $subject, $message)) {
        return true; // L'e-mail a été envoyé avec succès
      } else {
        return false; // Une erreur s'est produite lors de l'envoi de l'e-mail
      }
    }
      
    public function processForm() {
      if ($this->validate()) {
        $this->sendEmail();
        echo "Message envoyé avec succès!";
      } else {
        echo "Erreur: Veuillez remplir tous les champs du formulaire.";
      }
    }
  
  }
?>
