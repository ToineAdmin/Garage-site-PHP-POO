<?php

namespace App;

class FormCreator
{
  protected $fields = [];

  public function addField($name, $type, $label, $multiple = false)
  {
    $this->fields[] = [
      'name' => $name,
      'type' => $type,
      'label' => $label,
      'multiple' => $multiple
    ];
  }
  
  public function generateForm($submitext)
  {
    $form = '<form method="POST" action="" enctype="multipart/form-data" class="w-100">';
  
    foreach ($this->fields as $field) {
      $name = $field['name'];
      $type = $field['type'];
      $label = $field['label'];
      $multiple = $field['multiple'] ? 'multiple' : '';
  
      $form .= '<div class="mb-3">';
      $form .= '<label for="' . $name . '" class="form-label">' . $label . '</label>';
  
      if ($type === 'text') {
        $form .= '<input type="text" name="' . $name . '" id="' . $name . '" class="form-control mb-3" autocomplete="off" required>';
      } elseif ($type === 'email') {
        $form .= '<input type="email" name="' . $name . '" id="' . $name . '" class="form-control mb-3" required>';
      } elseif ($type === 'textarea') {
        $form .= '<textarea name="' . $name . '" id="' . $name . '" class="form-control mb-3" rows="4" required></textarea>';
      } elseif ($type === 'password') {
        $form .= '<input type="password" name="' . $name . '" id="' . $name . '" class="form-control mb-3" required>';
      } elseif ($type === 'image') {
        $form .= '<input type="file" name="' . $name . '[]" id="' . $name . '" class="form-control mb-3" accept="image/*" ' . $multiple . ' required>';
      }
  
      $form .= '</div>';
    }
  
    $form .= '<button type="submit" class="btn btn-primary">' . $submitext . '</button>';
    $form .= '</form>';
  
    return $form;
  }
  
  public function clearInput($input)
  {
    $input = trim($input);
    $input = stripslashes($input);
    $input = htmlspecialchars($input);
    return $input;
  }
}
