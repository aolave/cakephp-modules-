<?php

define('CELL_NOT_ALLOWED_TOFILL', '********');

/**
 * EmailComponent
 * 
 *
 */
class TemplateComponent extends Component{
    public $components = array( 'Excel' );
  
    public $header;
    public $defaultValues;
    public $allowNew = array();
    public $defaultData = array();
    public $fileFormats;
    public $controller;
    public $templateFileName;
    public $dbFields;
    public $filesData;
    public $colId;
    public $arrChanges = array();
    public $temporaryFile;
    public $DbFieldsToSave;
    public $formatValues = array();
    public $requiredFields = array();
    public $valuesInData = array();
    public $valuesDistinct = array();
    public $delegate;
    public $callBackFunctionName_New = array();
    public $callBackFunctionName_UpdateReg = array();
    public $callBackFunctionName_DeleteReg = array();
    public $callBackFunctionName_Close = array();
    public $callBackFunctionName_BeforeChanges = array();
    public $afterChangesTo = false;
    public $allowNewReg = true;
    public $deleteAllowReg = true;
    public $updateEnabledRegColumn = array();
    public $publishable = array();
    public $equalNoValida = false;  

    function initialize(&$controller, $settings = array()) {

      $this->fileFormats = array(
                                      'formatos' => array('csvcoma' => 'Csv separated by commas (,)', 'csvpuntocoma' => 'Csv separated by semicolons (;)', 'xls' => 'Excel 97/2004', 'xlsx' => 'Excel 2007'),
                                      'extensiones'  => array('csv', 'csv', 'xls', 'xlsx'),
                                      'default'  => 'xls'
                                      );
      
      $this->controller =& $controller;
    }
    
    function setDelegate( $obj ) {
      $this->delegate = $obj;
    }
    
    function setAccionNuevo( $callBackFunctionName, $params = array() ) {
      $this->callBackFunctionName_New['function'] = $callBackFunctionName;
      $this->callBackFunctionName_New['params'] = $params;
    }
    
    function setAccionUpdateReg( $callBackFunctionName, $params = array() ) {
      $this->callBackFunctionName_UpdateReg['function'] = $callBackFunctionName;
      $this->callBackFunctionName_UpdateReg['params'] = $params;
    }
    
    function setAccionDeleteReg( $callBackFunctionName, $params = array() ) {
      $this->callBackFunctionName_DeleteReg['function'] = $callBackFunctionName;
      $this->callBackFunctionName_DeleteReg['params'] = $params;
    }
    
    function setAccionAntesCambios( $callBackFunctionName, $arrParams = array() ) {
      $this->callBackFunctionName_BeforeChanges['function'] = $callBackFunctionName;
      $this->callBackFunctionName_BeforeChanges['params'] = $arrParams;
    }
    
    function setAccionFinalizar( $callBackFunctionName, $arrParams = array() ) {
      $this->callBackFunctionName_Close['function'] = $callBackFunctionName;
      $this->callBackFunctionName_Close['params'] = $arrParams;
    }
    
    function setDespuesCambios( $funcion, $controllerTo ) {
      $this->afterChangesTo      = $controllerTo;
      $this->despuesCambiosFuncion = $funcion;
    }
    
    function noValidarIguales() {
      $this->equalNoValida = true;
    }
    
    function noPermitirNewReg() {
      $this->allowNewReg = false;
    }
    
    function noPermitirDeleteReg() {
      $this->deleteAllowReg = false;
    }
    
    function columnaHabilitadaParaUpdateReg( $idCol ) {
      
    }
    
    function addPubliciable($publicName, $params) {
      $this->publishable[$publicName] = $params;
    }
    
    
    function doAction( $controller, $templateFileName, $urlParams, $dataParams) {
      
      $this->controller = $controller;
      $this->templateFileName = $templateFileName;
      
      if( isset($urlParams['descargar']) && $urlParams['descargar'] = 1 ) {
        $this->fileFormats['default'] = $urlParams['formato'];
        self::descargarTemplate();
      }
      
      if( isset($dataParams['Archivo'])) {
        if( $this->fileUploadToArray($dataParams['Archivo']['file']) ) {
          
          self::validateChanges();
        }
      }

      if( isset($dataParams[ $controller ]['TemporaryFile']) && $dataParams[ $controller ]['TemporaryFile']) {

        /* ejecute fucntion next */
        if( $this->callBackFunctionName_BeforeChanges) {
          
          call_user_func( array($this->delegate, $this->callBackFunctionName_BeforeChanges['function']), $this->callBackFunctionName_BeforeChanges['params'] );
        }

        self::doChanges( $dataParams[ $controller ] );
  
        /* change fin */
        if( $this->callBackFunctionName_Close) {
          call_user_func( array($this->delegate, $this->callBackFunctionName_Close['function']) );
        }

        /* Redirec to */      
        call_user_func( array($this->delegate, 'redirect'), array('action' => $this->afterChangesTo) ); 
        
      }
      
    }
    
    function setRequiredFields( $arrRequiredFields ) {
      $this->requiredFields = $arrRequiredFields;
    }
    
    function valuesInData( $column, $infoIn ) {
      $this->valuesInData[ $column ] = $infoIn;
    }
    
    function valuesDistinct( $column, $arrValuesDistincts ) {
      $this->valuesDistinct[ $column ] = $arrValuesDistincts;
    }
        
    function fileUploadToArray( $fileData, $fileTmp = false ) {
      
      if( $fileTmp ) {
        $archivoCargar = $fileTmp;
        $fileExtension = strrchr($fileTmp, '.');
      } else {
        $fileExtension = strrchr($fileData['name'], '.');
        $this->temporaryFile = TMP ."indicators".$fileExtension;
        
        if(!$fileData['tmp_name'])
        {
            return false;   
        }
        
        copy($fileData['tmp_name'], $this->temporaryFile);
        $archivoCargar = $this->temporaryFile;
      }
        /*
      switch( $fileExtension ) {
        case '.csv':
                      $llaves = array_flip($this->header);
                      $this->filesData = $this->CsvReader->parse($archivoCargar, true, 'auto', $llaves);
                      return true;
                      break;
                      
        case '.xls':
                      $llaves = array_flip($this->header);
                      $this->filesData = $this->Excel->parse($archivoCargar, $llaves);
                      //prx($this->filesData);
                      return true;
                      break;
      }
      */
      $llaves = array_flip($this->header);
      $this->filesData = $this->Excel->import($archivoCargar, $llaves, true);
      //prx($this->filesData);
      if($this->filesData)
      {
        /*foreach($this->filesData AS $pos => $data)
        {
            $this->filesData[ $pos ][ $label ] = $data;
        }
        */
        return true;
      }
      
      return false;
    }
    
    function compareFacts($originalValue, $fileValue) {
      foreach($originalValue as $idCol => $value) {
        if(!in_array($idCol, $this->updateEnabledRegColumn)) {
          unset($originalValue[$idCol]);
          unset($fileValue[$idCol]);
        }
      }
      return is_array( array_diff_assoc($originalValue, $fileValue) );
    }
    
    function validateChanges() {
    //prx($this->filesData);
      $arrIdDefaultData = $this->getArrayOfIds($this->defaultData, $this->colId );
      $idArrayArchiveData = $this->getArrayOfIds($this->filesData, $this->colId );
    //prx($idArrayArchiveData);
      foreach($arrIdDefaultData as $rowIdDefaultData => $dataRow) {
        
        if( !isset($idArrayArchiveData[ $rowIdDefaultData ])) {
          /* Data deleted */
          if($this->deleteAllowReg) {
            $this->arrChanges['removed'][] = $dataRow;  
          }
        } else {
          
          if( $this->equalNoValida || $this->compareFacts($idArrayArchiveData[ $rowIdDefaultData ], $dataRow) ) {
            /* Dato actualizado */      
            //prx('a');      
            $tmp = array();
            $tmp['data']       = $idArrayArchiveData[ $rowIdDefaultData ];
            $res_validacion    = self::validate_data( $idArrayArchiveData[ $rowIdDefaultData ] );
            $tmp['validacion'] = $res_validacion['validaciones'];
            $tmp['alerta']     = $res_validacion['alertas'];
            $this->arrChanges['actualizado'][] = $tmp;
          }          
        }
      }

      foreach($idArrayArchiveData as $rowIdArchivoData => $dataRow) {
        if( !isset($arrIdDefaultData[ $rowIdArchivoData ]) && $this->allowNewReg) {
          /* data new */
            $tmp = array();
            $tmp['data']       = $dataRow;
            $res_validacion    = self::validate_data( $dataRow );
            $tmp['validacion'] = $res_validacion['validaciones'];
            $tmp['alerta']     = $res_validacion['alertas'];            
            $this->arrChanges['nuevo'][] = $tmp;
        }
      }
      
      //prx($this->arrChanges);
    }
    
    function validate_data($arrayData) {
      //prx($arrayData);
      $arrayValidationData = array();
      $arrayAlertsData    = array();
      $ArrayInData        = array();
      
      if( $this->valuesInData )
      {
        $columns = array_unique( array_values($this->valuesInData) );
        
        foreach($columns AS $column)
        {
            $ArrayInData[ $column ] = Set::classicExtract($this->filesData, '{n}.'. $column);
        }
        
        foreach( $this->valuesInData AS $colId => $col )
        {
            if( $arrayData[ $colId ] != '' && !in_array( $arrayData[ $colId ], $ArrayInData[ $col ] ) )
            {
                $arrayValidationData[ $colId ] = 1;  
            }
        }                
      }
      
      if($this->valuesDistinct)
      {
        
        foreach( $this->valuesDistinct AS $colId => $cols )
        {
            foreach($cols AS $col)
            {
                if( $arrayData[ $colId ] != '' && $arrayData[ $colId ] == $arrayData[ $col ] )
                {
                    $arrayValidationData[ $colId ] = 1;  
                }
            }
        }        
      }
      
      //prx($this->defaultValues);
      /* Validate allowed values */
      if( $this->defaultValues ) {
        foreach($this->defaultValues as $colId => $rowDefaultValue) {
          
          $arrToUper = implode("__X__", $rowDefaultValue);
          $arrToUper = strtoupper($arrToUper);
          $arrToUper = explode("__X__", $arrToUper);
          
          if((!isset($arrayData[ $colId ]) || !in_array(strtoupper($arrayData[ $colId ]), $arrToUper)) && $arrayData[ $colId ]) {
            if(isset($this->allowNew[$colId]) && $this->allowNew[$colId]) {
              /* Create new values */
              $arrayAlertsData[ $colId ] = 20;
            } else {
              $arrayValidationData[ $colId ] = 1;  
            }
            
          }
        }
      }
      
      /* Validated field required */
      if( $this->requiredFields ) {
          foreach($this->requiredFields as $colId) {
            if( !isset($arrayData[ $colId ]) || !$arrayData[ $colId ]) {
              $arrayValidationData[ $colId ] = 2;
            }
          }
      }
      /* Validated form */        
      if($this->formatValues) {
        
        foreach($this->formatValues as $colId => $rowFormatValue) {
          
            switch( $rowFormatValue['tipo'] ) {
              case 'date_text':
                if( isset($arrayData[ $colId ]) && $arrayData[ $colId ]  && $arrayData[ $colId ] <> CELL_NOT_ALLOWED_TOFILL) {
                  if(!preg_match('/^(\d\d\d\d)-(\d\d?)-(\d\d?)$/', $arrayData[  $colId ], $matches)) {
                      $arrayValidationData[ $colId ] = 3;
                  } else {
                    if(!checkdate($matches[2], $matches[3], $matches[1])) {
                      $arrayValidationData[ $colId ] = 3;
                    }
                  }                  
                }
                break;

              case 'numeric':
                if( isset($arrayData[ $colId ]) && $arrayData[ $colId ] ) {
                  if (!is_numeric($arrayData[ $colId ]) && $arrayData[ $colId ] <> CELL_NOT_ALLOWED_TOFILL) {
                    $arrayValidationData[ $colId ] = 3;
                  }
                }
                break;
            }
        }
      }
      return array('validaciones' => $arrayValidationData, 'alertas' => $arrayAlertsData);
    }
    
    function isValidaciones() {
      /* Returns TRUE if a file amount and validations are made */
      return $this->arrChanges ? true : false;
    }
    
    function getValidaciones() {
      return $this->arrChanges;
    }
    
    function getArrayOfIds($arrData, $idField) {
      $arr = array();
      
      foreach($arrData as $rowData) {

        if( isset($rowData[$idField]) && $rowData[$idField] ) {
          $arr[ trim( $rowData[$idField] ) ] = $rowData;  
        } else {
          $token = strtoupper(md5(uniqid(rand(),1)));
          $arr[ $token ] = $rowData;  
        }
        
      }
      return $arr;
    }
    
    function getTemporaryFile() {
      return $this->temporaryFile;
    }
    
    function getController() {
      return $this->controller;
    }
    
    function setColId( $colId ) {
      /* You will have the ID column row */
      $this->colId = $colId;
    }
    
    function descargarTemplate() {
       switch($this->fileFormats['default']) {
          case 'csvcoma':      $type = ","; break;
          case 'csvpuntocoma': $type = ";"; break;
          case 'xls':          $type = "xls"; break;
          case 'xlsx':         $type = "xlsx"; break;
        }
        $value[0]['header'] = $this->header;
        $value[0]['data'] = $this->defaultData;
        $this->Excel->exportArray($value, $this->templateFileName, $type);   
        exit;      
    }
    function addHeader($idCol, $labelCol, $habilitadaUpdateReg = true, $options = array()) {
      if(!$this->header) {
        $this->header = array();
      }
      $this->header[$idCol] = $labelCol;
      if($habilitadaUpdateReg) {
        $this->updateEnabledRegColumn[] = $idCol;
      }
      if($options) {
        if(isset($options['format'])) {
          $this->setFormatValues( $idCol, $options['format'] );
        }
      }
    }
    function addHeaderId($idCol, $labelCol) {
      
      $this->addHeader($idCol, $labelCol, false);
      $this->setColId( $idCol );
    }
    function setDbFields( $arrDbFields ) {
      
      foreach($arrDbFields as $colId => $rowDbField) {
        
        list($Model, $Field) = explode(".", $rowDbField);
        $this->dbFields[$colId]['Model'] = $Model;
        $this->dbFields[$colId]['Field'] = $Field;
        
      }
    }
    
    function setDbFieldsToSave( $arrDbFields ) {
      $arrUses = array();
      $this->DbFieldsToSave = $arrDbFields;
      foreach($this->DbFieldsToSave as $colId) {
        $this->{$this->dbFields[$colId]['Model']} = ClassRegistry::init($this->dbFields[$colId]['Model']);
      }
    }    
    function getFormatoTemplate() {

        $arrFormato = array(
                              'header'          => $this->header,
                              'format'          => $this->formatValues,
                              'required'        => $this->requiredFields,
                              'columns_update'  => $this->updateEnabledRegColumn,
                              'defaults'        => $this->defaultValues,
                              'publishable'       => $this->publishable
                          );
        return $arrFormato;
    }

    function setDefaultValues($colId, $arrDefaults, $dbFieldInfo = false, $allowNew = false) {

        if( $dbFieldInfo ) {
          list($Model, $Field) = explode(".", $dbFieldInfo);
          foreach($arrDefaults as $pos => $rowDefault) {
            $this->defaultValues[$colId][] = trim($rowDefault[$Model][$Field]);
          }          
        } else {
          $this->defaultValues[$colId] = $arrDefaults;
        }
        $this->allowNew[$colId] = $allowNew;
    }
    
    function setFormatValues($colId, $tipo) {
      $this->formatValues[$colId]['tipo']    = $tipo;
      switch($tipo) {
        case 'numeric':   $this->formatValues[$colId]['formato']    = __('Numeric', true); break;
        case 'date_text': $this->formatValues[$colId]['formato']    = __('AAAA-MM-DD', true); break;
      }
      
    }

    function removerFormatoArchivo( $idFormatoArchivo ) {
      unset( $this->fileFormats['formatos'][$idFormatoArchivo] );
    }    

    function getFormatosArchivos() {
      return $this->fileFormats;
    }    

    function setFormatoArchivoDefatult( $idFormatoArchivo ) {
      return $this->fileFormats['default'] = $idFormatoArchivo;
    }

    function addData($dataRowId, $data) {
        $tmp[$this->colId] = $dataRowId;
        $tmp += $data;
        $this->defaultData[] = $tmp;
    }
    
    function addDbData( $lstDbData ) {
      
      foreach($lstDbData AS $pos => $rowDbData) {
        $tmpData = array();
        foreach($this->dbFields as $colId => $rowDbField) {
          $tmpData[ $colId ] = $rowDbData[ $rowDbField['Model'] ][ $rowDbField['Field'] ];
        }
        $this->defaultData[] = $tmpData;
      }
    }
    
    /* UpdateReg data base */
    function doChanges( $infoChanges ) {

      self::fileUploadToArray(false, $infoChanges['TemporaryFile']);
      self::validateChanges();
      
      $params = $infoChanges;
      
      if( isset($infoChanges['deletereg']) && $infoChanges['deletereg'] && $this->deleteAllowReg) {

          foreach($this->arrChanges['removed'] as $rowDataDeleteReg) {

            if( $this->callBackFunctionName_DeleteReg ) {
              $res['deletereg'][] = call_user_func( array($this->delegate, $this->callBackFunctionName_DeleteReg['function']), $rowDataDeleteReg[$this->colId], $rowDataDeleteReg, $this->defaultValues, $this->dbFields, $this->callBackFunctionName_DeleteReg['params'] );
            } else {
              exit('No function was found to delete');
            }

          }

      }
      if( isset($infoChanges['updatereg']) && $infoChanges['updatereg']) {

          foreach($this->arrChanges['actualizado'] as $rowDataUpdateReg) {

            if( $this->callBackFunctionName_UpdateReg ) {
              $params += $this->callBackFunctionName_UpdateReg['params'];
              $res['actualizado'][] = call_user_func( array($this->delegate, $this->callBackFunctionName_UpdateReg['function']), $rowDataUpdateReg['data'][$this->colId], $rowDataUpdateReg, $this->defaultValues, $this->dbFields, $params );
            } else {
              exit('No update function found');
            }

          }

      }
      if( isset($infoChanges['crear']) && $infoChanges['crear'] && $this->allowNewReg) {
        
          if(isset($this->arrChanges['nuevo']) && $this->arrChanges['nuevo']) {
            
            foreach($this->arrChanges['nuevo'] as $rowDataNuevo) {
              
              if( $this->callBackFunctionName_New ) {
                $res['nuevo'][] = call_user_func( array($this->delegate, $this->callBackFunctionName_New['function']), $rowDataNuevo, $this->defaultValues, $this->dbFields, $this->delegate, $this->callBackFunctionName_New['params'] );
                
              } else {

                $arrModels = array();
                foreach($this->DbFieldsToSave as $colId) {
                  $arrModels[ $this->dbFields[$colId]['Model'] ][$this->dbFields[$colId]['Field']] = $rowDataNuevo['data'][$colId];
                }
                $dataToSave = array();
                foreach($arrModels as $Model => $data) {
                  $dataToSave[$Model] = $data;
  
                  $this->{$Model}->create();
                  if(!$this->{$Model}->save( $dataToSave )) {
                    $dataFallo['nuevo'][] = $data;
                  }
                }
              }
            }
          }
      }
      
    }
    
}
?>