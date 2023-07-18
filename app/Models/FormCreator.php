<?php

namespace App\Models;

class FormCreator
{
  protected $fields = [];

  public function addField($name, $type, $label, $value = '', $multiple = false)
  {
    $this->fields[] = [
      'name' => $name,
      'type' => $type,
      'label' => $label,
      'value' => $value,
      'multiple' => $multiple
    ];
  }



  public function generateForm($submitName, $submitText, $includeForm = true)
  {
    $form = '';

    if ($includeForm) {
      $form .= '<form method="POST" action="" enctype="multipart/form-data" class="w-100">';
    }

    foreach ($this->fields as $field) {
      $name = $field['name'];
      $type = $field['type'];
      $label = $field['label'];
      $value = isset($field['value']) ? $field['value'] : '';
      $multiple = $field['multiple'] ? 'multiple' : '';

      $form .= '<div class="mb-3">';
      $form .= '<label for="' . $name . '" class="form-label">' . $label . '</label>';

      if ($type === 'text') {
        $form .= '<input type="text" name="' . $name . '" id="' . $name . '" class="form-control mb-3" autocomplete="off" value="' . $value . '" required>';
      } elseif ($type === 'email') {
        $form .= '<input type="email" name="' . $name . '" id="' . $name . '" class="form-control mb-3" value="' . $value . '" required>';
      } elseif ($type === 'textarea') {
        $form .= '<textarea name="' . $name . '" id="' . $name . '" class="form-control mb-3" rows="4" required>' . $value . '</textarea>';
      } elseif ($type === 'password') {
        $form .= '<input type="password" name="' . $name . '" id="' . $name . '" class="form-control mb-3" required>';
      } elseif ($type === 'image') {
        $form .= '<input type="file" name="' . ($multiple ? $name . '[]' : $name) . '" id="' . $name . '" class="form-control mb-3" accept="image/*" ' . $multiple . '>';
      }

      if ($includeForm) {
        $form .= '</form>';
      }
    }

    $form .= '<button type="submit" class="btn btn-primary" name="' . $submitName . '">' . $submitText . '</button>';
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
