<?php
/*
 * Validator
 *
 * Validierung von Formulareingaben
 *
 * Autor: Florian Amrhein
 */

class formvalidate {
  var $fields=array();
  /*
   * Überprüft ein komplettes Formular auf korrekte Eingaben, und liefert
   * false, falls irgendwo ein Fehler vorhanden ist.
   * Setzt intern die entsprechenden Daten, die show_error und
   * is_error zum Abfragen der Daten benötigen.
   */
  function validate() {
    $errors=false;
    foreach($this->fields as $field) {
      switch($field->typ) {
        case "text":
        case "textarea":
        case "checkbox":
        case "radiobutton":
          // Basteln wegen scheiss PHP
          $valtmp=$field->validator;
          // feld_leer*feld_darf_leer + 
          // nicht_feld_leer*(testfkt.ex.*testfkt +
          //   nicht_testfkt.ex)
          if(
             (
              (
               (!isset($_REQUEST[$field->name])) ||
               (trim($_REQUEST[$field->name])=="")
              ) &&
              (isset($field->empty)) &&
              ($field->empty==true)
             ) || (
              (isset($_REQUEST[$field->name])) &&
              (trim($_REQUEST[$field->name])!="") &&
              (
               ($field->validator==false) ||
               ($field->validator!=false) &&
               (($errmsg=$valtmp($_REQUEST[$field->name]))===true)
              )
             )
            ) {
            // Feld leer und darf leer sein, oder
            // feld voll und (testfunktion existiert und testfkt.=true
            //                oder testfunktion existiert nicht)
            $this->fields[$field->name]->error=false;
          } else {
            // Feld leer und darf nicht leer sein, oder
            // Feld voll und testfkt.ex und testfunktion=false
            $errors=true;
            $this->fields[$field->name]->error=true;
            if(isset($errmsg)) {
              $this->fields[$field->name]->errormessage=$errmsg;
              unset($errmsg);
            }
          }
          break;
        case "pulldown":
        case "check-text":
        case "radio-text":
          if((isset($field->empty)) && (!$field->empty) &&
             ((!isset($_REQUEST[$field->name])) ||
              (trim($_REQUEST[$field->name])=="") ||
              (($_REQUEST[$field->name]=="_frei") &&
               ((!isset($_REQUEST[$field->name."_frei"])) ||
                (trim($_REQUEST[$field->name."_frei"])=="")
               )
              )
             )
            ) {
            $errors=true;
            $this->fields[$field->name]->error=true;
          } else {
            $this->fields[$field->name]->error=false;
          }
          break;
      }
//      echo '<p>eval: '.$field->name.': '.$_REQUEST[$field->name].'</p>';
    }
    return !$errors;
  }


  /*
   * liefert true, falls $name fehlerhaft ausgefüllt wurde
   */
  function is_error($name) {
    return $this->fields[$name]->error;   
  }

  /*
   * Liefert die individuelle Fehlermeldung, falls $name fehlerhaft
   * ausgefüllt wurde. Falls keine Meldung vorliegt, wird false
   * geliefert.
   */
  function geterrormessage($name) {
    if(isset($this->fields[$name]->errormessage))
      return $this->fields[$name]->errormessage;
    else
      return false;
  }

  /*
   * Zeigt gegebenenfalls eine Fehlermeldung an, falls $name nicht
   * korrekt ausgefüllt wurde
   */
  function show_error($name) {
    if($this->is_error($name)) {
      echo "<p>fehler</p>";
    }
  }

  /*
   * Zeigt den Titel zu einem Feld an. Ist das zugehörige Feld fehlerhaft 
   * ausgefüllt worden, wird es (z.B. farblich) markiert.
   *
   * $name: Name des Feldes
   * $text: auszugebener Text
   */
  function show_title($name,$text) {
    if($this->is_error($name))
      echo '<font color="red"><b>'.$text.'</b></font>';
    else
      echo $text;
  }

  /*
   * Zeigt die Daten an, die der Benutzer in das Formular, ob richtig oder
   * falsch ist egal, eingegeben hatte.
   */
  function show_value($name) {
    echo stripslashes($_REQUEST[$name]);
  }

  /*
   * Liefert Variablenwerte ohne vorherige Umkodierung/Zusammenfassung
   * zurück
   */
  function value($name) {
    if(is_array($_REQUEST[$name])) {
      $a=$_REQUEST[$name];
      return $a;
    }
    return stripslashes($_REQUEST[$name]);
  }

  /* Liefert Variablenwerte mit vorheriger Umkodierung/Zusammenfassung
   * zurück. Vor allem wichtig bei Typ check-text und radio-text, wo
   * der eigentliche Inhalt über mehrere Variablen verteilt ist, bzw.
   * teilweise gar nicht zum Zuge kommt (freies Textfeld ausgefüllt,
   * aber nicht angeklickt)
   */
  function get_value($name) {
    if(is_array($_REQUEST[$name])) {
      $a=$_REQUEST[$name];
      // Freies Textfeld?
      if(in_array("_frei",$a)) {
        if((isset($_REQUEST[$name.'_frei'])) &&
           ($_REQUEST[$name.'_frei']!=""))
          $a[]=$_REQUEST[$name.'_frei'];
        unset($a[$name.'_frei']);
      }

      return $a;
    } else if(($_REQUEST[$name]=='_frei') &&
              ($this->fields[$name]->typ=='radio-text')) {
      return stripslashes($_REQUEST[$name.'_frei']);
    } else
      return stripslashes($_REQUEST[$name]);
  }
  
  /*
   * gibt einfach nur " checked" aus, wenn $name den wert $value enthält.
   * Nötig für das Vorselektieren von Knöpfen
   */
  function show_checked($name,$value) {
    global $fields;
    if(($this->fields[$name]->typ!="checkbox") &&
       ($this->fields[$name]->typ!="check-text")) {
      if($this->value($name)==$value) {
        if($this->fields[$name]->typ=="pulldown")
          echo ' selected';
        else
          echo ' checked';
      }
    } else {
      if(in_array($value,$this->value($name))) 
        echo ' checked';
    }
  }

  function show_selected($name,$value) {
    global $fields;
    if(($this->fields[$name]->typ!="checkbox") &&
       ($this->fields[$name]->typ!="check-text")) {
      if($this->value($name)==$value) {
        echo ' selected';
      }
    }
  }


  /*
   * Registriert eine Variable als zum Formular gehörend
   *
   * $name:  Name der Variablen
   * $typ:   Art der Eingabe:
   *         - text:         Textfeld mit einfacher freier Eingabe
   *         - textarea:     Mehrzeiliger Text mit freier Eingabe
   *         - checkbox:     Ankreuzfelder, mehrere gleichzeitig
   *         - radiobutton:  Ankreuzfelder, nur eins gleichzeitig
   *         - pulldown:     Pulldown-Menu, nut eins gleichzeitig
   *         - check-text:   Ankreuzfelder+Textfeld, mehrere gleichzeitig
   *         - radio-text:   Ankreuzfelder+Textfeld, maximal eins
   * $empty: Darf das entsprechende Feld leer gelassen werden?
   *         bzw. mindestens kein angekreuzt bzw. ausgefüllt?
   * $validator: Information, wie der Inhalt auf Korrektheit geprüft
   *             werden soll
   * $errmsg: Fehlermeldung, die bei erkanntem Fehler ausgegeben 
   *          werden soll
   */
  function register($name,$typ,$empty=true,$validator=false,$errmsg=false) {
    $var->name=$name;
    $var->typ=$typ;
    $var->empty=$empty;
    $var->validator=$validator;
    $var->errmsg=$errmsg;
    $this->fields[$name]=$var;
  }

  /*
   * der Konstruktor
   */
  function formvalidate() {
  }
}
?>
