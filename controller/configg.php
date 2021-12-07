<?php

//Etablissement de la connexion avec la base de données

class Config {
    private static $pdo = NULL;
    public static function getConnexion()
    {
        if (!isset(self::$pdo)) {
            try {
                self::$pdo = new PDO('mysql:host=localhost;dbname=login_sample_db', 'root', '',
                    [
                        //lancer une exception PDOException en cas d’erreur.

                        //Dans se cas, chaque ligne est retournées dans un tableau indexé par le nom des colonnes.

                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]);
                          
            } catch (Exception $e) {
                die('Erreur: ' . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}

?>
