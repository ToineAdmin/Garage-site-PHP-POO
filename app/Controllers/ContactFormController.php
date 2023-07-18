<?php

namespace App\Controllers;

use App\Models\FormCreator;


class ContactFormController extends FormCreator
{
  private $name;
  private $email;
  private $message;
  private $formCreator;

  public function __construct($name, $email, $message)
  {
    $this->name = $name;
    $this->email = $email;
    $this->message = $message;
    $this->formCreator = new FormCreator();
  }

  public function validate()
  {
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

  public function sendEmail()
  {
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

  public function contacFormSubmit()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      // Vérifier si le champ 'name' existe dans $_POST
      if (isset($_POST['name'])) {
        // Récupérer les données du formulaire
        $name = $this->formCreator->clearInput($_POST['name']);
        $email = $this->formCreator->clearInput($_POST['email']);
        $message = $this->formCreator->clearInput($_POST['message']);

        if ($this->validate()) {
          $this->sendEmail();
          echo "Message envoyé avec succès!";
        } else {
          echo "Erreur: Veuillez remplir tous les champs du formulaire.";
        }
      }
    }
  }


  public function createContactForm()
  {
    $contactForm = new FormCreator();
    $contactForm->addField('email', 'text', 'Nom :');
    $contactForm->addField('email', 'email', 'E-mail :');
    $contactForm->addField('message', 'textarea', 'Message :');

    // Afficher le formulaire de contact
    return $contactForm->generateForm('messBtn', 'Envoyer');
  }
}
