<?php
/**
* General Functions
*/
class GeneralFunctions {

    /**
     * permite Validar si existe la propiedad de un Objeto y Obtener su Valor.
     * @param  Object  $objValidate Objeto a analizar
     * @param  String  $prpProperty Nombre de la propiedad a buscar en el objeto
     * @param  String  $othProperty Nombre de la propiedad a buscar en el objeto->{$prProperty}
     * @param  Integer $type        Permite definir se se desea obtener el valor de la propiedad o simplemente saber si esta Existe en el objeto
     * @param  String  $defValue    Valor por defecto a Retornar, en caso de no encontrar las propiedades solicitadas
     * @return String  $valProperty Valor de la Propiedad solicitada
     * @author Snayder Acero <helacer3@yahoo.es>
    */
    public static function validatePropertyExist($objValidate, $prpProperty, $othProperty = "", $type = 1, $defValue = "")
    {
        // create Default Vars
        $valProperty = "";
        $vldProperty = false;
        // validate Exist Property
        if (is_object($objValidate) && property_exists($objValidate, $prpProperty)) {
            // set Property Value
            $valProperty = $objValidate->{$prpProperty};
            // validate Other Property
            if ($othProperty != "") {
                // validate Property
                if (is_object($valProperty) && property_exists($valProperty, $othProperty)) {
                    // set Property Value
                    $valProperty = $valProperty->{$othProperty};
                    // set Validate Property
                    $vldProperty = true;
                } else {
                    // reset Value
                    $valProperty = "";
                }
            } else {
                // set Validated Property
                $vldProperty = true;
            }
        }
        // default Return - validate
        return ($type == 2)?$vldProperty:(($valProperty != "")?$valProperty:$defValue);
    }

    /** 
    * permite Validar si existe el Índice de un Array y Obtener su Valor.
     * @param  Array   $arrValidate Arreglo a Analizar
     * @param  String  $prpIndex Índice a buscar en el Arreglo
     * @param  String  $othIndex Índice a buscar en el Arreglo
     * @param  Integer $type     Permite definir se se desea obtener el valor del índice o simplemente saber si este Existe en el array
     * @param  String  $defValue Valor por defecto a Retornar, en caso de no encontrar los indices solicitados
     * @return String  $valIndex Valor del Arreglo en los Índices Solicitados
     * @author Snayder Acero <helacer3@yahoo.es>
    */
    public static function validateIndexExist($arrValidate, $prpIndex, $othIndex = "", $type = 1, $defValue = "")
    {
        // create Default Vars
        $valIndex = "";
        $vldIndex = false;
        // validate Exist Array Index
        if (is_array($arrValidate) && array_key_exists($prpIndex, $arrValidate)) {
            // set Array Index Value
            $valIndex = $arrValidate[$prpIndex];
            // validate Other Index
            if ($othIndex != "") {
                // validate Array
                if (is_array($valIndex) && array_key_exists($othIndex, $valIndex)) {
                    // set Array Index Value
                    $valIndex = $valIndex[$othIndex];
                    // set Validated Array Index
                    $vldIndex = true;
                } else {
                    $valIndex = "";
                }
            } else {
                // set Validate Array Index
                $vldIndex = true;
            }
        }
        // default Return - Validate
        return ($type == 2)?$vldIndex:(($valIndex != "")?$valIndex:$defValue);
    }

    /**
    * permite Validar si el Arreglo contiene el Objeto y obtener su Valor.
    * @param  Array  $arrValidate  Arreglo a Analizar
    * @param  String $indArray     Índice a buscar en el Arreglo
    * @param  String $objProperty  Nombre de la propiedad a buscar en el objeto
    * @param  String $othProperty  Nombre de la propiedad a buscar en el objeto
    * @return String $valObject    Valor de la Propiedad Solicitada
    * @author Snayder Acero <helacer3@yahoo.es>
    */
    public static function validateObjectInArrayExist($arrValidate, $indArray, $objProperty, $othProperty = "")
    {
        // create Default Vars
        $valObject = "";
        // validate Exist Array Index
        if (is_array($arrValidate) && array_key_exists($indArray, $arrValidate)) {
            // set Array Index Value
            $valIndex = $arrValidate[$indArray];
            // validate Property Exist
            if ($objProperty != "" && property_exists($valIndex, $objProperty)) {
                // set Value Object
                $valObject = $valIndex->{$objProperty};
                // validate Property Exist
                if ($othProperty != "" && is_object($valObject) && property_exists($valObject, $othProperty)) {
                    // set Value Object
                    $valObject = $valObject->{$othProperty};
                }
            }
        }
        // default Return
        return $valObject;
    }

    /**
    * validate Methods In Object
    * @param  Object $objValidate Objeto a analizar
    * @param  String $frsMethod   Nombre del primer método a buscar en el objeto de la Clase
    * @param  String $secMethod   Nombre del segundo método a buscar en el objeto de la Clase
    * @return String $defValue    Valor por Defecto a Retornar
    * @author Snayder Acero <helacer3@yahoo.es>
    */
    public static function validateMethodsInObject($objValidate, $frsMethod, $secMethod = "", $defValue = "")
    {
        // set Default Value
        $valObject = $defValue;
        try {
            // validate Object And First Method
            if (is_object($objValidate) && method_exists($objValidate, $frsMethod)) {
                // set Object Value
                $valObject = $objValidate->{$frsMethod}();
                // validate Second Param
                if ($secMethod != "") {
                    // validate New Object And Second Method
                    if (is_object($valObject) && method_exists($valObject, $secMethod)) {
                        // set Object Value
                        $valObject = $objValidate->{$secMethod}();
                    } else {
                        // reset Object Value
                        $valObject = $defValue;
                    }
                }
            }
        } catch (\Exception $ex) {
            error_log("\n\n Error (".date('Y-m-d H:i:s').") validateMethodsInObject: ".$ex->getMessage()."-".$ex->getFile()."-".$ex->getLine());
        }
        // default Return
        return $valObject;
    }

}