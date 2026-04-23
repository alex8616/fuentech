<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class BackupDatabaseMail extends Mailable
{
    use Queueable, SerializesModels;

    public $backupPath;
    public $fecha;

    public function __construct($backupPath, $fecha)
    {
        $this->backupPath = $backupPath;
        $this->fecha = $fecha;
    }

    public function build()
    {
        return $this->subject('Backup de base de datos')
                    ->view('emails.backup')
                    ->attach($this->backupPath);
    }
}

