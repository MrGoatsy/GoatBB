<?php
    function getsections(){
        global $handler;

        $getSectionsQuery = $handler->query('SELECT * FROM section WHERE archived = 0');

        $sectionArray = [];

        while($fetchSections = $getSectionsQuery->fetch(PDO::FETCH_ASSOC)){
            $getThreadSection = $handler->query("SELECT COUNT(*) as sectionCount FROM thread WHERE sc_id = {$fetchSections['sc_id']} AND archived = 0");
            $fetchGetThreadSection = $getThreadSection->fetch(PDO::FETCH_ASSOC);

            $sectionArray[] .= $fetchGetThreadSection['sectionCount'] ?? 0;
        }

        return json_encode($sectionArray);
    }
?>
