<?php
/**
 * Application level Controller Component
 *
 * This file is application-wide helper file. You can put all
 * application-wide Component-related methods here.
 *
 * PHP 5
 * 
 * Autor: Cesar Robledo (nairda_rasec123@hotmail.com)
 */

class JqgridComponent extends Component
{
    /*
     * @param array $result the array we want to paginate
     * @param string $clause a string specifying how to paginate the array similar total pagina, num page, count and result
     * @ defaul
     * @return null
     */

    public function paginationArray($data = array(), $page=0, $limit=0)
    {
        $page = $page < 1 ? 1 : $page;
        $start = ($page - 1) * ($limit);
        $offset = $limit;
        
        $outResult= array_slice($data,$start, $offset);
        
        // calculate the total pages for the query
        $count = count($data);

        if ($count > 0) {
            $total_pages = ceil ( $count / $limit );
        } else {
            $total_pages = 0;
        }
        return compact('page', 'total_pages', 'count', 'outResult', 'start');
    }

    /*
     * @param array $ary the array we want to sort
     * @param string $clause a string specifying how to sort the array similar to SQL ORDER BY clause
     * @param bool $ascending that default sorts fall back to when no direction is specified
     * @return null
     */
    
    public function orderBy($data, $field, $orderby = null) {
        if($orderby){
            if($orderby == "asc"){
                $code = "return strnatcmp(\$a['$field'], \$b['$field']);";
            }else if($orderby == "desc"){
                $code = "return strnatcmp(\$b['$field'], \$a['$field']);";
            }
            usort($data, create_function('$a,$b', $code));
        }
        return $data;
      }
      
    /* 
    * @param array total page 
    * @param enum $count a string specifying numbers 
    * @param nun $limit that pages specified 
    * @return 0 
    */
      
    public function totalPages($count, $limit){
        if ($count > 0) {
            return $total_pages = ceil ( $count / $limit );
        } else {
            return $total_pages = 0;
        }
    }
      
      
}

