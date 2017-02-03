<?php 
    $totalResults = 200;
    $resultsPerPage = 5;
    $totalPages = ceil($totalResults / $resultsPerPage);
    
    
    for($pageNumber = 1;$pageNumber <= $totalPages;$pageNumber++){
            $currentPage = $pageNumber;
            $LIMIT_1 = $resultsPerPage * ($currentPage - 1);
            if($LIMIT_1 != 0) {
                $LIMIT_1++; 
            }

            $LIMIT_2 = $resultsPerPage;

            $SQL_LIMIT			  = " LIMIT $LIMIT_1,$LIMIT_2";
            print($SQL_LIMIT."\n");
            
    }
?>