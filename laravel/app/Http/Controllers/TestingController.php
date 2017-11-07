<?php

namespace App\Http\Controllers;

use DB;
use Mail;
use Swift_Transport;
use Swift_Message;
use Swift_Mailer;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Election;
use Illuminate\Support\Facades\Auth;

use Crypt;
class TestingController extends Controller
{
    public function testingUrl()
    {
        $data_toview = array();
            $data_toview['bodymessage'] = "Hello send test email";
 
            $email_sender   = 'agamalamen@gmail.com';
            $email_pass     = 'Youyugi195';
            $email_to       = 'afarag16@alastudents.org';
 
            // Backup your default mailer
            $backup = \Mail::getSwiftMailer();
 
            try{
 
                        //https://accounts.google.com/DisplayUnlockCaptcha
                        // Setup your gmail mailer
                        $transport = \Swift_SmtpTransport::newInstance('smtp.gmail.com', 587, 'tls');
                        $transport->setUsername($email_sender);
                        $transport->setPassword($email_pass);
 
                        // Any other mailer configuration stuff needed...
                        $gmail = new Swift_Mailer($transport);
 
                        // Set the mailer as gmail
                        \Mail::setSwiftMailer($gmail);
 
                        $data['emailto'] = $email_sender;
                        $data['sender'] = $email_to;
                        //Sender dan Reply harus sama
 
                        Mail::send('mails.test', $data_toview, function($message) use ($data)
                        {
 
                            $message->from($data['sender'], 'Laravel Mailer');
                            $message->to($data['emailto'])
                            ->replyTo($data['sender'], 'Laravel Mailer')
                            ->subject('Test Email');
 
                            echo 'The mail has been sent successfully';
 
                        });
 
            }catch(\Swift_TransportException $e){
                $response = $e->getMessage() ;
                echo $response;
            }
 
 
            // Restore your original mailer
            Mail::setSwiftMailer($backup);
 
 
    }

    }



      /*for ($letter in $alphabet) {
        echo $letter;
        echo "<br>";
      }*/

      /*$school = Auth::User()->school;
      foreach($school->users as $user) {
        if(strpos($user->email, '15')) {
          $user->role = 'alumni';
          $user->update();
        }
      }*/
      //return 'hello world!';
      /*$x = 1;
      foreach(Auth::User()->school->users as $user) {
        if($user->avatar == 'default.jpg') {
          $user->avatar = 'default_' . strval($x) . '.png';
          $user->update();
          $x += 1;
        }
        if($x == 13) {
          $x = 1;
        }
      }*/