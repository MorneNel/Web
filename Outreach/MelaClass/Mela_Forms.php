<?php

class Mela_Forms {
    
    protected $formName;
    protected $action;
    protected $method;
    protected $id;
    
    protected $classFormField = 'FormField';
    protected $classPhysiologyField = 'PhysiologyField';
    protected $classDropDown = 'FormDropDown';
    protected $classDate = 'FormDate';
    protected $classBlock = 'FormBlock';
    protected $classRadio = 'RadioTic';
    protected $classDateTime = 'FormDateTime';
    protected $classTime = 'FormTime';
    
    function __construct($formName, $action, $method, $id) {
        $this->formName = $formName;
        $this->action = $action;
        $this->method = $method;
        $this->id = $id;
        
        $this->instantiateForm();
    }
    
    function __destruct() {
        echo "</form>";
    }
    
    function instantiateForm() {
        echo "<form action='$this->action' name='$this->formName' method='$this->method' id='$this->id'>";    
    }    
    
    /*
    * Generates a dropdown box filled with data from 1 or 2 arrays
    * @param string $formName Name attribute for <select> tag
    * @param array $formFields Used to populate each dropdown box option
    * @param array $formValues Optional array for keys, if not specified will use sequential numbers
    * @param string $selected Optional, used to specify if a specific key should be marked as 'selected' by default
    * @param array $classes Optional, define additional CSS classes to be added
    * @param int $disabled Optional, disable dropdown list with value 1
    */
    function dropDown ($name, $fields, $values = 0, $selected = '', $classes='', $disabled = 0) {
    if (!is_array($fields)) return;
    $name = trim($name);
    $class = "".$this->classDropDown." ";
    $disable = ($disabled == 1) ? "disabled" : "";
    
    if ($classes != '') {
        $classBits = explode(',',$classes);
        foreach ($classBits AS $classBit) {
            $class .= " $classBit";
        }
    }
    
    $output = "<select class='$class' id='$name' name='$name' $disable>";
    $output .= "<option value=''></option>";
    
    foreach ($fields as $key => $val) {
        $opValue = ($values == 0) ? $key : $values[$key];
        
        $select = ($selected != '' && ($selected == $opValue OR $selected == $val)) ? 'selected' : '';
        $opValue = trim($opValue);
        
        $output .= "<option value='$opValue' $select>".trim($val)."</option>";    
    }
    
    $output .= "</select>";
    
    return $output;
    }

    /*
    * Generates an [input type=text] box
    * @param string $name The name attribute
    * @param string $value Optional, a preset value for the textbox
    * @param string $size Optional, the size attribute
    * @param boolean $disabled Optional, mark the textbox as disabled to prevent editting
    * @param array $classes Optional, define additional CSS classes to be added
    */ 
   
   function textBox ($name, $value='', $size='', $disabled=0, $classes='') {
       if ($disabled != 0) $disabled = 1;
       if (!is_numeric($size)) $size = '';
       $class = "".$this->classFormField." ";
    
       if ($classes != '') {
            if (is_array($classes)) {   
                for ($i = 0; $i < count($classes); $i++) {
                    $class .= " $classes[$i] ";
                }
            }
            else {
                $class .= " $classes";
            }
       }        
       
       $output = "<input class='$class' type='text' id='$name' name='$name' ";
       
       if ($value !='') {
           $output .= "value='$value' ";
       }
       
       if ($size !='') {
           $output .= "size='$size' ";
       }
       
       if ($disabled == 1) {
           $output .= "disabled ";
       }
       
       $output .= ">";
       
       return $output;
       
   }

    /*
    * Generates an [input type=text] box
    * @param string $name The name attribute
    * @param string $value Optional, a preset value for the textbox
    * @param string $size Optional, the size attribute
    * @param boolean $disabled Optional, mark the textbox as disabled to prevent editting
    * @param array $classes Optional, define additional CSS classes to be added
    * @param array $datatags Optional, associative array to add extra data-xxx attributes to form elements. Used for identifying physiology fields for physiology validation. key => val = tagname => tagvalue
    */ 
   
   function textBoxPhysiology ($name, $value='', $size='', $disabled=0, $classes='', array $datatags = NULL) {
        if ($disabled != 0) $disabled = 1;
        if (!is_numeric($size)) $size = '';
        $class = "".$this->classPhysiologyField." ";
        $tags = "";
     
        if ($classes != '') {
            if (is_array($classes)) {   
                for ($i = 0; $i < count($classes); $i++) {
                    $class .= " $classes[$i] ";
                }
            }
            else {
                $class .= " $classes";
            }
        }
        
        if (!empty($datatags) && is_array($datatags)) {
            foreach($datatags as $tag => $tagval) {
                $tags .= "data-$tag='$tagval' ";
            }
        }
        
        $output = "<input class='$class' type='text' id='$name' name='$name' ";
        
        if ($value !='') {
            $output .= "value='$value' ";
        }
        
        if ($size !='') {
            $output .= "size='$size' ";
        }
        
        if ($disabled == 1) {
            $output .= "disabled ";
        }
        
        if ($tags != NULL) {
            $output .= $tags;
        }
        
        $output .= ">";
        
        return $output;
       
   }

   /*
    * Generates a <textarea>
    * @param string $name The name attribute
    * @param string $value Optional, the default value
    * @param int $cols Optional, the cols attribute
    * @param int $rows Optional, the rows attribute
    * @param boolean $disabled Optional, mark as disabled
    * @param array $classes Optional, define additional CSS classes to be added
    */
   
    function textArea ($name, $value='', $cols=0, $rows=0, $disabled=0, $classes='', $ids='') {
       if ($disabled != 0) $disabled = 1;
       if (!is_numeric($cols)) $cols = 0;
       if (!is_numeric($rows)) $rows = 0;
       $class = "".$this->classBlock." ";
    
       if ($classes != '') {
            if (is_array($classes)) {   
                for ($i = 0; $i < count($classes); $i++) {
                    $class .= " $classes[$i] ";
                }
            }
            else {
                $class .= " $classes";
            }
       } 
       
       $id = $name;
       $output = "<textarea id='$id' class='$class' name='$name' ";
       
       if ($cols != 0) $output .= "cols='$cols' ";
       if ($rows != 0) $output .= "rows='$rows' ";
       if ($disabled == 1) $output .= "disabled ";
       
       $output .= ">";
       
       if ($value != '') $output .= "$value";
       
       $output .= "</textarea>";
       
       return $output;
    }
    
    /*
     * Generates a list of radio boxes
     * @param string $name The name attribute
     * @param array $labels Associative array of value => label attributes
     * @param string $checked Optional, identify the unique $key to be pre-selected
     * @param string $linebreak Optional, linebreak after each radio box, default is <br />
     * @param array $classes Optional, define additional CSS classes to be added
     */
    
    function radioBox ($name,$labels,$checked='',$linebreak='<br />',$classes='') {        
        $output = "";
        $class = "".$this->classRadio."";
    
        if (is_array($classes)) {
            foreach($classes AS $key => $val) {
                $class .= " $val ";
            }
        }
        
        foreach ($labels as $key => $val) {
            if ($checked == $key) {
                $preselected = 'checked';
            } else {
                $preselected = '';
            }
            
            $output .= "<input type='radio' class='$class' id='$name-$key' name='$name' value='$key' $preselected>
                        <label for='$name-$key' class='$class'>
                            $val
                        </label>";
            if ($linebreak != '') {
                $output .= "".$linebreak."";
            }
        }
        
        return $output;
    }
    
    /*
     * Generates one checkbox
     * @param string $name The name attribute
     * @param string $id The id attribute
     * @param string $label Check box label
     * @param string $checked Optional, mark as checked
     * @param array $classes Optional, define additional CSS classes to be added
     */
    function checkBox ($name, $id, $label, $checked='',$classes='') {
        $output = "";
        $class = "".$this->classRadio." ";
    
        if ($classes != '') {
            for ($i = 0; $i < count($classes); $i++) {
                $class .= " $classes[$i] ";
            }
        }
        
        if ($checked != '' && $checked != 'No' && $checked != 'False' && $checked != 'false') {
            $checked = "checked='checked'";
        }
        
        $output .= "<input type='checkbox' class='$class' id='$id' name='$name' value='$id' $checked>
                    <label for='$id'>
                        $label
                    </label>";
        
        return $output;
    }
    
    /*
     * Generates a group of checkboxes for the same name attribute
     * @param string $name The name attribute
     * @param array $checkboxData Multidimensional array structured as: id => name, value, label, checked
     * @param array $classes Optional, define additional CSS classes to be added
     * @param string $linebreak Optional, specifies a linebreak between checkboxes. Default is <br />
     */
    function checkBoxGroup ($name, $checkboxData, $classes='',$linebreak='<br />') {
        $output = "";
        $class = "".$this->classRadio." ";
        
        if ($classes != '') {
            for ($i = 0; $i < count($classes); $i++) {
                $class .= " $classes[$i] ";
            }
        }
        
        foreach ($checkboxData as $parent => $child) {
            // Search for checked
            if ($child[3] != '') {
                $check = "checked='checked'";
            } else {
                $check = "";
            }
            $output .= "<input type='checkbox' class='$class' id='".$child[0]."' name='".$child[0]."' value='".$child[1]."' $check>
                        <label for='".$child[0]."'>
                            ".$child[2]."
                        </label>";
            if ($linebreak != '') {
                $output .= "".$linebreak."";
            }
        }
        
        //$output = var_dump($checkboxData[1]);
        
        return $output;
    }
    
    /*
     * Generates a hidden field
     * @param string $name The name attribute
     * @param string $value Value to hold
     */
    function hiddenField($name, $value) {
        $output = "<input type='hidden' id='$name' name='$name' value='$value'>";
        
        return $output;
    }
    
    /*
     * Generates a reset button
     * @param string $value Optional, provide a custom value. Default is 'reset'
     */
    
    function resetButton($value = 'Reset') {
        $output = "<input type='reset' value='$value'>";
        return $output;
    }
    
    /*
     * Generates a submit button
     * @param string $value Optional, the value attribute. Default is 'Submit'
     * @param boolean $disabled Optional, disable button
     * @param array $classes Optional, define additional CSS classes to be added
     */
    function submitButton ($value='', $disabled='',$classes='') {
        if ($disabled != '') $disabled = 'disabled';
        if ($value == '') $value='Submit';
        $class = "class='";
        
        if ($classes != '') {
            for ($i = 0; $i < count($classes); $i++) {
                $class .= " $classes[$i] ";
            }
        }
        $class .= "'";
        
        $output = "<input type='submit' value='$value'";
        
        if ($class != "class=''") {
            $output .= " $class";
        }
        
        $output .= " $disabled>";
        
        return $output;
    }
    
    /*
     * Generate a time field
     * @param string $name Name/ID field
     * @param string $time Optional, takes a time value formatted by convert4DTime()
     * @param array $classes Optional, CSS classes to be added
     */
    function timeField($name, $time='', $classes='') {
        $output = "";
        $class = "class='FormTime";
        
    
       if ($classes != '') {
            if (is_array($classes)) {   
                foreach($classes AS $key => $val) {
                    $class .= " $val ";
                }
            }
            else {
                $class .= ", $classes";
            }
       }


        $class .= "'";
        
        if ($time != '') {
            $timeValue = "value='$time'";
        } else {
            $timeValue = "";
        }
        
        $output = "<input type='time' $class name='$name' id='$name' $timeValue>";
        
        return $output;
    }
    
    /*
     * Generate a date field
     * @param string $name Name/ID field
     * @param string $date Optional, takes a date value formatted by stringToDateTime(DATE,2);
     * @param array $classes Optional, CSS classes to be added
     */
    function dateField($name, $date='', $classes='') {
        $output = "";
        $class = "class='FormDate";
        

       if ($classes != '') {
            if (is_array($classes)) {   
                foreach($classes AS $key => $val) {
                    $class .= " $val ";
                }
            }
            else {
                $class .= ", $classes";
            }
       }
       $class .= "'";

        
        if ($date != '') {
            $dateValue = "value='$date'";
        } else {
            $dateValue = "";
        }
        
        $output = "<input type='date' $class name='$name' id='$name' $dateValue>";
        
        return $output;    
    }
    
    /*
     * Generate a datetime-local field
     * @param string $name Name/ID field
     * @param string $datetime Optional, takes a date values formatted by stringToDateTime(DATETIME,1);
     * @param array $classes Optional, CSS classes to be added
     */
    function dateTimeField($name, $datetime='', $classes='') {
        $output = "";
        $class = "class='FormDate";
        
        if (is_array($classes)) {
            foreach($classes AS $key => $val) {
                $class .= " $val ";
            }
        }
        $class .= "'";
        
        if ($datetime != '') {
            $datetimeValue = "value='$datetime'";
        } else {
            $datetimeValue = "";
        }
        
        $output = "<input type='datetime-local' $class name='$name' id='$name' $datetimeValue>";
        
        return $output;    
    }
}
