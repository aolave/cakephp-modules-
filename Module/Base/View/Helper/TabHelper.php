<?php

class TabHelper extends AppHelper {
	
	var $helpers = array('Form');
	
	public function imprimirTabs($urlDestination, $optionsArray, $defaultValue, $typeTab = 'select', $varName = 'id', $idContent= 'tab_content') 	  {

      $html = '';
      
      $html .= '
                <script>
                $(function() {
                    var aVArTags = [';
                        foreach($optionsArray as $index => $value) {
                          $html .= '{label: "'.$value.'", value: "'.$index.'"},';
                        }
      $html .= '
                    ];
                    $( "#tags" ).autocomplete({
                        source: aVArTags,
                        minLength: 2,
                        select: function(event, ui) {
                          $("#tab_select").val( ui.item.value );
                          $("#tags").val("");
                          doTabCancelSearch();
                          loadTabContent("'.$urlDestination.'", "'.$varName.'", "'.$idContent.'");
                        }
                    });   
                });
                </script>';
      
      if($tipoTab == 'tab') {
        $html .= '
                  <div id="tab_header">
                    <ul>';
        foreach($optionsArray as $index => $value) {
          $html .= '<li id="tab_option_'.$index.'" '.($index == $defaultValue ? 'class="tab_selected"' : '').'><a href="#" onclick="loadTabContent(\''.$urlDestination.'\', \''.$varName.'\', \''.$idContent.'\', \''.$index.'\')">'.$value.'</a></li>';
        }        
        $html .= '
                    </ul>
                  </div>';      
      } else {
        $html .= '
                  <div id="tab_header_list">
                    <div class="tab_select">
                      <select onchange="loadTabContent(\''.$urlDestination.'\', \''.$varName.'\', \''.$idContent.'\')" id="tab_select">';
        foreach($optionsArray as $index => $value) {
              $html .= '<option value="'.$index.'">'.$value.'</option>';
        }
        $html .= '
                      </select>
                  <a href="" onclick="doTabSearch();return false;" id="tab_search_link">'.__('Search by text', true).'</a>
                  <div style="display:none" id="tab_search_box">
                    <label for="tags">'.__('Search', true).': </label>
                    <input id="tags">
                  </div>
                  <a href="" onclick="doTabCancelSearch();return false;" id="tab_cancel_link" style="display:none">'.__('Cancel', true).'</a>
                </div>
              </div>';
      }
      return $html;
    }

}
?>