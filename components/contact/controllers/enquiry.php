<?php

    require_once(__DIR__ ."/../models/enquiry.php");

    class EnquiryController
    {
        
        private $model;
        
        public function __construct($model)
        {
            Core::changeTitle("Contact Form");
            $this->model = $model;
        }
        
        public function send()
        {
            $time = time();
            
            $admin = Core::componentconfig()->admin_email;

            $subject = 'Contact Form Submitted - '. Core::config()->site_name;

            $headers = "From: ". $admin ."\r\n";
            $headers .= "Reply-To: ". $_POST["email"] ."\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
                
            $message = '<html><body>';
                $message .= '<h4>Contact Form Received</h4>';
                $message .= '<table border="1" width="100%">';
                    $message .= '<tr>';
                        $message .= '<td>';
                            $message .= '<strong>Name:</strong>';
                        $message .= '</td>';
                        $message .= '<td>';
                            $message .= $_POST["name"];
                        $message .= '</td>';
                    $message .= '</tr>';
                    $message .= '<tr>';
                        $message .= '<td>';
                            $message .= '<strong>Email:</strong>';
                        $message .= '</td>';
                        $message .= '<td>';
                            $message .= $_POST["email"];
                        $message .= '</td>';
                    $message .= '</tr>';
                    $message .= '<tr>';
                        $message .= '<td>';
                            $message .= '<strong>Content:</strong>';
                        $message .= '</td>';
                        $message .= '<td>';
                            $message .= $_POST["content"];
                        $message .= '</td>';
                    $message .= '</tr>';
                    $message .= '<tr>';
                        $message .= '<td>';
                            $message .= '<strong>Sent time:</strong>';
                        $message .= '</td>';
                        $message .= '<td>';
                            $message .= date("Y-m-d- H:i:s", time());
                        $message .= '</td>';
                    $message .= '</tr>';
                $message .= '</table>';
            $message .= '</body></html>';
            $enquiry = new EnquiryModel(0, $this->database);
            $enquiry->name = $_POST["name"];
            $enquiry->email = $_POST["email"];
            $enquiry->content = $_POST["content"];
            $enquiry->sent_time = time();
            $enquiry->store();
            mail($admin, $subject, $message, $headers);
            Core::hooks()->executeHook("onSubmitContact");
            header('Location: '. Core::route("index.php?component=contact&controller=complete"));
        }
        
    }

?>