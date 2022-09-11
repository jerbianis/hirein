<?php

namespace App\Listeners;

use App\Enum\CandidatureStatusEnum;
use App\Events\CandidatureStatusUpdated;
use App\Models\Interview;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Mail;

class SendEmailWhenCandidatureStatusUpdated implements ShouldQueue
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\CandidatureStatusUpdated  $event
     * @return void
     */
    public function handle(CandidatureStatusUpdated $event)
    {
        //
        $candidature = $event->candidature;

        $to_name = $candidature->candidate->name;
        $user=User::where('profile_type','App\Models\Candidate')
            ->where('profile_id',$candidature->candidate_id)->first();
        $to_email = $user->email;

        switch ($candidature->status) {
            case CandidatureStatusEnum::QuizTest :
                $data = array("name" => "Anis", "body" => "QuizTest");
                Mail::send('emails.mail',$data,function ($msg) use ($to_name,$to_email) {
                    $msg->to($to_email, $to_name)->subject("Laravel Test Mail");
                });
                break;

            case CandidatureStatusEnum::InProcess :
                $data = array("name" => "Anis", "body" => "InProcess" );
                Mail::send('emails.mail',$data,function ($msg) use ($to_name,$to_email) {
                    $msg->to($to_email, $to_name)->subject("Laravel Test Mail");
                });
                break;

            case CandidatureStatusEnum::Interview :
                $interview=Interview::find($candidature->interview->id);
                $secret = ENV('secretkey');
                $generatedToken = substr(sha1($secret .  $interview->id), 0, 8) ;
                $data = array("name" => "Anis", "body" => "http://127.0.0.1:8000/interview/" . $interview->id . "?token=" . $generatedToken);
                Mail::send('emails.mail',$data,function ($msg) use ($interview, $to_name,$to_email) {
                    $interview->invited_email_list ?
                        $msg->to($to_email, $to_name)
                        ->cc($interview->invited_email_list)
                        ->subject("Laravel Test Mail")
                        :
                        $msg->to($to_email, $to_name)
                        ->subject("Laravel Test Mail");

                });
                break;

            case CandidatureStatusEnum::Accepted :
                $data = array("name" => "Anis", "body" => "InProcess");
                Mail::send('emails.mail',$data,function ($msg) use ($to_name,$to_email) {
                    $msg->to($to_email, $to_name)->subject("Laravel Test Mail");
                });

            case CandidatureStatusEnum::Rejected :
                $data = array("name" => "Anis", "body" => "rejected");
                Mail::send('emails.mail',$data,function ($msg) use ($to_name,$to_email) {
                    $msg->to($to_email, $to_name)->subject("Laravel Test Mail");
                });

        }
    }
}
