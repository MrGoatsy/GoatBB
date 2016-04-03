<?php
    function getallsections(){
        global $handler;

        $allSections = $handler->query('SELECT * FROM section WHERE archived = 0');

        $allSectionsArray = [];

        while($fetchAllSections = $allSections->fetch(PDO::FETCH_ASSOC)){
            $allSectionsArray[] .= $fetchAllSections['secname'];
        }

        return json_encode($allSectionsArray);
    }
?>
