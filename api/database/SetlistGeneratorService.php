<?php
class SetlistGeneratorService {
    
    public static function getFullSetlist() {
        $db = ConnectionFactory::getDB();
        $setlist = array();
        
        foreach($db->setlist() as $music) {
           $setlist[] = array (
               'id' => $music['id'],
               'name' => $music['name'],
               'author' => $music['author'],
               'origin' => $music['origin']
           ); 
        }
        
        return $setlist;
    }

    public static function add($newMusic) {
        $db = ConnectionFactory::getDB();
        $newMusic = $db->setlist->insert($newMusic);
        return $newMusic;
    }
}
?>