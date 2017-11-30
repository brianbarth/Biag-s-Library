<?php

    class Flash {
        private static function set_flash ($msg, $type) {
            $_SESSION['flash'] = array("message"=>$msg, "type"=>$type);
        }
        public static function set_alert( $msg ) {
            self::set_flash( $msg, "alert");
        }
        public static function set_notice( $msg ) {
            self::set_flash( $msg, "notice");
        }
    }
?>