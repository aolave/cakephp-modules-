<?php

/**
 * 
 * Draw a tree html with data sent from * the ontrolador with threaded cake method
 * 
 *
 */
class TemplateHelper extends AppHelper {
	
	var $helpers = array('Form', 'Utilities');

	public function imprimirTemplate($arrFormatoTemplate, $arrFormatosArchivo, $actionModule) {
		$html = '** Required data';
		$html .= '<div id="templateMigrar"><table border="0" class="table_page" style="width: 100%">';
			$html .= "<tr>";
			foreach($arrFormatoTemplate['header'] as $colId => $rowHeader) {
				$rowHeader = in_array($colId, $arrFormatoTemplate['required']) ? '**'.$rowHeader : $rowHeader;
				$format = isset($arrFormatoTemplate['format'][$colId]) ? '<br />('.$arrFormatoTemplate['format'][$colId]['formato'].')' : '';
				$th_class = in_array($colId, $arrFormatoTemplate['columns_update']) ? 'class="th_column_updatereg"' : '';
				$html .= "<th ".$th_class." style='vertical-align:top'>".$rowHeader.$format."</th>";
			}
			$html .= "</tr>";

			$html .= "<tr>";
			foreach($arrFormatoTemplate['header'] as $colId => $rowHeader) {
				if( isset($arrFormatoTemplate['defaults'][$colId]) ) {
					if( is_array($arrFormatoTemplate['defaults'][$colId]) ) {
						$html .= "<td style='vertical-align:top'>".implode("<br />", $arrFormatoTemplate['defaults'][$colId])."</td>";
					} else {
						$html .= "<td style='vertical-align:top'>".$arrFormatoTemplate['defaults'][$colId]."</td>";
					}
				} else {
					$html .= "<td style='vertical-align:top;text-align:center'>...</td>";	
				}
				
			}
			$html .= "</tr>";

		$html .= '</table></div>';

		$html .= '<select onchange="cambiarValorUrl(\'linkA\', \'formato\', this.value);" >';
                
			foreach($arrFormatosArchivo['formatos'] as $idFormatoArchivo => $rowFormatoArchivo) {
				$html .= '<option value="'.$idFormatoArchivo.'" '. ($idFormatoArchivo == $arrFormatosArchivo['default'] ? 'selected="selected"' : '') .'>'.$rowFormatoArchivo.'</option>';
			}
		$html .= '</select>';
        
		$html .= $this->Utilities->link(__('Download Template', true), array('action' => $actionModule,'?' => array('descargar' => 1, 'formato' => $arrFormatosArchivo['default']) ), array('id' => 'linkA')) ."</li>";
		
		
		return $html;
	}
	
	function imprimirValidaciones( $arrValidaciones, $arrFormatoTemplate ) {
		$html = '';
		
		$errores = false;
		
		$html .= '<div class="confirmar">';
		
		if( isset($arrValidaciones['removed']) && $arrValidaciones['removed'] ) {
				$html .= '<div class="contents" id="_del">
							<div class="template_row template_row_deletereg">
								<div class="confirm_check">'.$this->Form->checkbox('deletereg', array('value' => 1)).' Delete:</div> 
								<div class="confirm_msg">'.count($arrValidaciones['removed']).' registro(s)</div> 
								<div class="confirm_link"><a onclick="$(\'#del\').toggle();" href="#"> View detail </a></div>
							</div>
							<div class="template_row_detail" id="del">
								<br clear="all" />';

				$html .= '<table border="0" style="width:100%" class="table_page">';
				$html .= "<tr>";
				foreach($arrFormatoTemplate['header'] as $colId => $rowHeader) {
					$format = isset($arrFormatoTemplate['format'][$colId]) ? '<br />('.$arrFormatoTemplate['format'][$colId]['formato'].')' : '';
					$html .= "<th>".$rowHeader.$format."</th>";
				}
				$html .= "</tr>";				
				foreach($arrValidaciones['removed'] as $dataRow) {
					$html .= '<tr>';
						foreach($arrFormatoTemplate['header'] as $colId => $rowHeader) {
							$html .= '<td>'.$dataRow[ $colId ].'</td>';
						}
					$html .= '</tr>';
				}
				$html .= '</table>';
				$html .= '</div></div>';
		}

		if( isset($arrValidaciones['actualizado']) && $arrValidaciones['actualizado'] ) {

				$html .= '<div class="contents" id="_upd">
							<div class="template_row template_row_updatereg">
								<div class="confirmar_check">'.$this->Form->checkbox('updatereg', array('value' => 1)).' Update:</div> 
								<div class="confirmar_msg">'.count($arrValidaciones['actualizado']).' registro(s)</div> 
								<div class="confirmar_link"><a onclick="$(\'#upd\').toggle();" href="#"> View detail </a></div>
							</div>
							<div class="template_row_detail" id="upd">
								<br clear="all" />';			

				$html .= '<table border="0" style="width:100%" class="table_page">';
				$html .= "<tr>";
				foreach($arrFormatoTemplate['header'] as $colId => $rowHeader) {
					$format = isset($arrFormatoTemplate['format'][$colId]) ? '<br />('.$arrFormatoTemplate['format'][$colId]['formato'].')' : '';
					$th_class = in_array($colId, $arrFormatoTemplate['columns_update']) ? 'class="th_column_updatereg"' : '';
					$html .= "<th ".$th_class.">".$rowHeader.$format."</th>";
				}
				$html .= "</tr>";
				foreach($arrValidaciones['actualizado'] as $dataRow) {
					$html .= '<tr>';
						foreach($arrFormatoTemplate['header'] as $colId => $rowHeader) {
							if( isset($dataRow['validacion'][ $colId ]) ) {
								$validacion = 'class="dato_invalido_'.$dataRow['validacion'][ $colId ].'"';
								$errores = true;
							} else {
								$validacion = '';
							}
							$html .= '<td '.$validacion.'>'.$dataRow['data'][ $colId ].'</td>';
						}
					$html .= '</tr>';
				}
				$html .= '</table>';
				$html .= '</div></div>';
		}
		
		if( isset($arrValidaciones['nuevo']) && $arrValidaciones['nuevo'] ) {

				$html .= '<div class="contents" id="_add">
							<div class="template_row template_row_new">
								<div class="confirmar_check">'.$this->Form->checkbox('crear', array('value' => 1)).' Nuevo:</div> 
								<div class="confirmar_msg">'.count($arrValidaciones['nuevo']).' record (s)  </div> 
								<div class="confirmar_link"><a onclick="$(\'#add\').toggle();" href="#"> View detail </a></div>
							</div>
							<div class="template_row_detail" id="add">
								<br clear="all" />';			
				$html .= '<table border="0" style="width:100%" class="table_page">';
				$html .= "<tr>";
				foreach($arrFormatoTemplate['header'] as $colId => $rowHeader) {
					$format = isset($arrFormatoTemplate['format'][$colId]) ? '<br />('.$arrFormatoTemplate['format'][$colId]['formato'].')' : '';
					$html .= "<th>".$rowHeader.$format."</th>";
				}
				$html .= "</tr>";
				foreach($arrValidaciones['nuevo'] as $dataRow) {
					$html .= '<tr>';
						foreach($arrFormatoTemplate['header'] as $colId => $rowHeader) {
							$validacion = '';
							$alerta		= '';
							if( isset($dataRow['validacion'][ $colId ]) ) {
								$validacion = 'class="dato_invalido_'.$dataRow['validacion'][ $colId ].'"';
								$errores = true;
							} elseif( isset($dataRow['alerta'][ $colId ]) ) {
								$alerta = 'class="dato_alerta_'.$dataRow['alerta'][ $colId ].'"';
							}
							$html .= '<td '.$validacion.$alerta.'>'.$dataRow['data'][ $colId ].'</td>';
						}
					$html .= '</tr>';
				}
				$html .= '</table>';
				$html .= '</div></div>';
		}
		$html .= '</div>';
		
		if($errores) {
			$html_error = '';
			$html_error .= '<br clear="all" /><div class="invalid_data_conventions_box">';
				$html_error .= 'Errors in the file to load is found. In detail you can identify cells illuminated with the corresponding error:: <br clear="all" /><br />';
				$html_error .= '<div class="template_conv_di"><div class="convention_invalid_data invalid_data_1"></div> Invalid value</div>';
				$html_error .= '<div class="template_conv_di"><div class="convention_invalid_data invalid_data_2"></div> required information </div>';
				$html_error .= '<div class="template_conv_di"><div class="convention_invalid_data invalid_data_3"></div> Invalid format </div>';
			$html_error .= '</div><br clear="all" /><br />';
			$html = $html_error . $html;
		}
		
		$html .= '<br clear="all" /><br />';
		if(!$errores) {
			//$html .= $this->Form->submit('Importar');
			
			$html .= '
						<script language="javascript">
						
							function templateValidateChanges() {
								
								if($(".confirmar :checked").size() < 1) {
									alert("Please select the operations to be performed");
									return false;
								}
								$("form#form_template").submit();
							}

							function doBackTemplate() {
								
								if( confirm("This insurance abandon changes?")) {
									window.location.href="";
								}
							}							
							
						
						</script>
			';
			
			if(isset($arrFormatoTemplate['variables'])) {
				foreach($arrFormatoTemplate['variables'] as $varName => $params) {
					$html .= $this->Form->input($varName, array('label' => $params['label'], 'options' => isset($params['options']) ? $params['options'] : array(), 'type' => $params['type']));
				}
			}
			
			$html .= '<br />';
			$html .= $this->Form->submit('Import', array('type' => 'button', 'onclick' => "return templateValidateChanges()", 'div' => array('style' => 'display:inline')));
			$html .= '&nbsp;&nbsp;&nbsp;&nbsp;';
			$html .= $this->Form->submit('Back', array('type' => 'button', 'onclick' => "return doBackTemplate()", 'div' => array('style' => 'display:inline')));
		} else {
			$html .= $this->Form->submit('Back', array('type' => 'button', 'onclick' => "window.location.href=''"));
		}
		
		return $html;
	}

}

?>