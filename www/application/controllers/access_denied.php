<?php

class Access_denied_Controller extends Controller {

        function __call($method, $args)
        {
                // Attempted access path, with "access_denied/" removed
                $path = preg_replace('|^access_denied/|', '', $this->uri->string());

                // Display an error page
                throw new Kohana_User_Exception
                (
                        'Direct Access Denied',
                        'The file or directory you are attempting to access, <tt>'.$path.'</tt>, cannot be accessed directly. '.
                        'You may return to the '.html::anchor('', 'home page').' at any time.'
                );
        }

}
?>