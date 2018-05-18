<?php

    class RegisterController
    {
        
        public function __construct()
        {
            Core::changeTitle("Register an account");
            if (Core::config()->enable_recaptcha == 1)
            {
                Core::addScript("https://www.google.com/recaptcha/api.js");
            }
        }
        
    }

?>