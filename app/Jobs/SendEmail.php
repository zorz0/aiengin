<?php

namespace App\Jobs;

use App\Mail\NotifyMail;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\Email;
use Illuminate\Support\Facades\Mail;
use PHPMailer\PHPMailer\PHPMailer;
use Symfony\Component\Mime\Part\TextPart;
use Illuminate\Mail\Mailables\Content;

class SendEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $type;
    protected $mail;
    protected $data;
    protected $from;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($type, $mail, $data = [], $from = null)
    {
        $this->type = $type;
        $this->mail = $mail;
        $this->data = $data;
        $this->from = $from;
    }

    private function parse($data, $content)
    {
        $parsed = preg_replace_callback('/{{(.*?)}}/', function ($matches) use ($data) {
            list($shortCode, $index) = $matches;
            if (isset($data[$index])) {
                return $data[$index];
            } else {
                /**
                 * for testing only
                 */
                //throw new Exception("Shortcode {$shortCode} not found in template id {$this->id}", 1);
            }

        }, $content);

        return $parsed;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $mail = new PHPMailer(true);

        try {
            $template = Email::where('type', '=', $this->type)->first();
            $mail->SMTPDebug = env('MAIL_DEBUG', false);
            $mail->isSMTP();
            $mail->Host = env('MAIL_HOST');
            $mail->SMTPAuth = true;
            $mail->Username = env('MAIL_USERNAME');
            $mail->Password = env('MAIL_PASSWORD');
            $mail->SMTPSecure = env('MAIL_ENCRYPTION');
            $mail->Port = env('MAIL_PORT');
            $mail->setFrom(env('MAIL_FROM_ADDRESS'));
            $mail->addAddress($this->mail);
            $mail->isHTML(true);
            $mail->Subject = (config('settings.mail_title') ? config('settings.mail_title') . ' ' : '') . $this->parse($this->data, $template->subject);
            $mail->Body = $this->parse($this->data, $template->content);

            try {
                if( !$mail->send() ) {
                    return $mail->ErrorInfo;
                } else {
                    return "Email has been sent.";
                }
            } catch (\Exception $e) {

            }

        } catch (\Exception $e) {
            throw $e;
        }
    }
}
