
<?php
    /**
     * N a b a z t a g
     * 
     * Permet de gère les fonctions de base de l'API
     *
     * @author PELLEGRINO Laurent 
     * @author PETIT Olivier http://www.nabzfood.com
     * @version 2008.01.22
     */
     
     class Nabaztag
     {     
        var $serial; // Numéro de série du Nabaztag qui va recevoir les évènements
        var $token; // Identidiant du Nabaztag, limitant les risque de spam
        var $APImsg; //Message recu de l'API ou messages d'erreur
        var $url = 'http://api.nabaztag.com/vl/FR/api.jsp'; //Url d'envoie des commandes
        var $lang; //Langue d'envoi des messages
        
        /**
         * Initialise les champs de l'objet
         * @param String $serial Numero de serie du Nabaztag qui va recevoir les evenements
         * @param Integer $token Identidiant du Nabaztag, limitant les risque de spam
         * @param String $lang Langue du Nabaztag (fr/us)
         */
        
        function Nabaztag($serial, $token, $lang='fr')
        {
            $this->lang = $lang;
            $this->serial = $serial;
            $this->token = $token;
            $this->url .= '?sn='.$this->serial.'&token='.$this->token;
        }
        
        /**
         * Envoie une chanson a chanter au Nabaztag
         * @param int $id Identifiant de la chanson à lire
         */
         
        function chanter($id)
        {
            $this->url .='&idmessage='.$id.'&idapp=10';
        }
        
        /**
         * Envoie un texte a lire au Nabaztag
         * @param String $texte Texte a faire lire par le Nabaztag
         * @param String $voice Voix a utiliser
         */
        
        function dire($texte,$signature='', $voice='')
        {            
            if ($signature != '') {
              $this->url .='&tts='.rawurlencode('Message de '.stripslashes(trim($signature)).' : ').rawurlencode(stripslashes(trim($texte)));
            } else {
              $this->url .='&tts='.rawurlencode(stripslashes(trim($texte)));
            }
            //Pour le francais on ne prends pas la voix par defaut (preference personnelle ;)
            if ($voice == '' && $this->lang=="fr") $voice='claire22k';
            if ($voice == '' && $this->lang=="us") $voice='heather22k';
                    
            if ($voice != '') {
              $this->url .='&voice='.$voice;
            }
        }
        
        /**
         * Positionne l'oreille gauche
         * @param int $pos Position de l'oreille
         */
        
        function SetOreilleGauche($pos)
        {            
            $this->url .= "&posleft=".$pos;
        }
        
         /**
         * Positionne l'oreille droite
         * @param int $pos Position de l'oreille
         */
        
        function SetOreilleDroite($pos)
        {            
            $this->url .= "&posright=".$pos;
        }
        
        /**
         * @return int Renvoie le token du Nabaztag
         */
        
        function getToken()
        {
            return $this->token;
        }
        
        /**
         * @return string Renvoie l'url d'appel de l'API
         */
        
        function getURL()
        {
            return $this->url;
        }
        
        /**
        * @return string Renvoie le dernier message de l'API
        */
        
        function getAPImsg()
        {
            return $this->APImsg;
        }
        
        /**
         * @return boolean Renvoie le statut du serveur Nabaztag
         */
        
        function getStatut()
        {
            return (boolean) @fsockopen('www.nabaztag.com', 80);
        }

        
        /**
         * Envoie des parametres au serveur nabaztag
         * @param boolean $preview True pour ecouter, false pour envoyer
         * 
         * @return boolean Renvoie true si le message a été transmis au destinataire
         */
        
        function send($preview=false)
        {
            
            if ($preview) { $this->url .= "&action=1"; }
            
            $fp = $this->getStatut();
            
            if($fp)
            {
                $ch = curl_init();
                curl_setopt ($ch, CURLOPT_URL, $this->url);
                curl_setopt ($ch, CURLOPT_HEADER, 0);
                curl_setopt ($ch, CURLOPT_TIMEOUT, 20);
                curl_setopt ($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml; charset=UTF-8","Accept-Language: fr-fr",)); 
                ob_start();
                curl_exec ($ch);
                $infoHTTP = curl_getinfo ($ch,CURLINFO_HTTP_CODE);
                $infoERR = curl_error($ch);

                curl_close ($ch);
                $string = ob_get_contents();
                ob_end_clean();
                                
                if (substr($infoHTTP,0,1) == "2") { //page accessible
                    
                    $p = xml_parser_create();
                    xml_parse_into_struct($p, $string, $vals, $index);
                    xml_parser_free($p);
                    if ($preview) {
                        $this->APImsg = "Ecoute en cours...<embed id='".$vals[$index[EMBED][0]][attributes][ID]."' width='0' height='0' type='".$vals[$index[EMBED][0]][attributes][TYPE]."' src='".$vals[$index[EMBED][0]][attributes][SRC]."' name='".$vals[$index[EMBED][0]][attributes][NAME]."' quality='".$vals[$index[EMBED][0]][attributes][QUALITY]."' flashvars='".$vals[$index[EMBED][0]][attributes][FLASHVARS]."'/>";
                    } else {
                        $this->APImsg = $vals[$index['COMMENT'][0]]['value'];
                    }
                    $APICode = $vals[$index['MESSAGE'][0]]['value'];
                    //echo $APICode;
                      if($APICode == "TTSSEND" || $APICode == "EARPOSITIONSEND" || $APICode == "MESSAGESEND" || $APICode == "LINKPREVIEW") {
                        return true;
                      } else {
                        return false; 
                      }
                } else {
                    $this->APImsg = "Erreur HTTP ".$infoHTTP." / ".$infoERR; 
                      return false;
                }
            }
            else
            {
                $this->APImsg = 'Serveur Nabaztag indisponible. Envoie de commandes impossible';
            }
        }
        
        /**
         * Permet de modifier la valeur du token
         * @param int $token Identidiant du Nabaztag, limitant les risque de spam
         */
        
        function setToken($token)
        {
            $this->token = $token;
        }
    }
    
    ///////////////////////////
    // Exemple d'utilisation //
    ///////////////////////////
    
    //$nabaztag = new Nabaztag('XXXXXXXXXXXX', 'XXXXXXXXXX');
    
    // Envoie d'une p'tite chanson
    //$nabaztag->chanter(11904);
    //$nabaztag->send();
    //echo $nabaztag->getAPImsg();

?>