<?php
namespace App;

class FormCreator {
    protected $fields = [];
  
    public function addField($name, $type, $label) {
      $this->fields[] = [
        'name' => $name,
        'type' => $type,
        'label' => $label
      ];
    }
  
    public function generateForm() {
      $form = '<form method="POST" action="" class ="w-50">';
    
      foreach ($this->fields as $field) {
        $name = $field['name'];
        $type = $field['type'];
        $label = $field['label'];
    
        $form .= '<div class="mb-3">';
        $form .= '<label for="' . $name . '" class="form-label">' . $label . '</label>';
    
        if ($type === 'text') {
          $form .= '<input type="text" name="' . $name . '" id="' . $name . '" class="form-control" required>';
        } elseif ($type === 'email') {
          $form .= '<input type="email" name="' . $name . '" id="' . $name . '" class="form-control" required>';
        } elseif ($type === 'textarea') {
          $form .= '<textarea name="' . $name . '" id="' . $name . '" class="form-control" rows="4" required></textarea>';
        }elseif ($type === 'password') {
          $form .= '<input type="password" name="' . $name . '" id= "' . $name . '" class = "form-control" required';
        }
        
        $form .= '</div>';
      }
    
      $form .= '<button type="submit" class="btn btn-primary">Envoyer</button>';
      $form .= '</form>';
    
      return $form;
    }
    
  }
