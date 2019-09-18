<?php

if(!defined('ROOT')) die("Kein direkter Zugriff erlaubt.");

class Mail {

    public function sendDOIMail($userName, $firstName, $lastName, $email, $salutation, $doi_token) {

        $to = $email;
        $toBCC = 'sixl@sixl.org';
        $from = 'no-reply@project-sixl.de';
        $fromName = 'Übung Daten­banken ITV34 | Daniel Sixl';

        $subject = "Aktivierung Ihres Accounts bei \"https://project-sixl.de\"";
        $plural = ($salutation=="Frau") ? "" : "r";

        $htmlContent = <<<EOT
            <!doctype html>
            <html> 
            <style>
                body {
                    font-family: sans-serif;
                    -webkit-font-smoothing: antialiased;
                    font-size: 14px;
                    line-height: 1.4;
                    margin: 40px;
                    padding: 0;
                }
                a {
                    font-weight: 900;
                }
                a.button-link {
                  -webkit-tap-highlight-color: transparent;
                  background-color: #26a69a;
                  border-radius: 2px;
                  border-style: none;
                  box-shadow: rgba(0,0,0,.14) 0 2px 2px 0,rgba(0,0,0,.12) 0 3px 1px -2px,rgba(0,0,0,.2) 0 1px 5px 0;
                  color: #fff;
                  cursor: pointer;
                  font-size: 14px;
                  letter-spacing: .5px;
                  outline: 0;
                  overflow: hidden;
                  margin: 16px 0 16pxpx;
                  padding: 8px 16px;
                  position: relative;
                  text-align: center;
                  text-decoration: none;
                  transition-delay: 0s;
                  transition-duration: .3s;
                  transition-property: all;
                  transition-timing-function: ease-out;
                  vertical-align: middle;
                }
                a.button-link:hover {
                  background-color: #2bbbad;
                  box-shadow: rgba(0,0,0,.14) 0 3px 3px 0,rgba(0,0,0,.12) 0 1px 7px 0,rgba(0,0,0,.2) 0 3px 1px -1px;
                }
            </style>
            <head>
                <meta name="viewport" content="width=device-width" />
                <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                <title>Aktivierung Ihres Accounts</title>
            </head>
            <body> 
                <h1>Aktivierung Ihres Accounts</h1>
                <p>Sehr geehrte$plural $salutation $lastName,<br>bitte klicken Sie nachfolgenden Link um die Aktivierung Ihres Accounts abzuschließen:</p>
                <p><a class="button-link" href="https://project-sixl.de/registration/register_new_user/$userName?doi_token=$doi_token">E-Mail-Adresse bestätigen und Account aktivieren</a></p>
                <h2>Ihre Anmeldedaten</h2>
                <p>Vorname: <strong>$firstName</strong><br>
                Nachname: <strong>$lastName</strong><br>
                Benutzername: <strong>$userName</strong></p>            
            </body>
            </html>
EOT;

        $headers = "MIME-Version: 1.0" . "\r\n";
        $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";

        $headers .= 'From: '.$fromName.'<'.$from.'>' . "\r\n";
        $headers .= 'Bcc: '.$toBCC."\r\n";

        if(mail($to, $subject, $htmlContent, $headers)) return true;

        return false;

    }

}