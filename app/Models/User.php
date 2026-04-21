<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use App\Models\Student;
use App\Models\Admin;
use Laravel\Cashier\Billable;
use Illuminate\Notifications\Messages\MailMessage;

use Illuminate\Database\Eloquent\Relations\HasOne;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Billable;

    protected $table = 'users';


    public function sendPasswordResetNotification($token)
    {
        $this->notify(new class($token) extends \Illuminate\Auth\Notifications\ResetPassword {

            public function __construct($token)
            {
                parent::__construct($token);
            }

            public function toMail($notifiable)
            {
                return (new \Illuminate\Notifications\Messages\MailMessage)
                    ->subject('Reimpostazione Password')
                    ->view('emails.reset-password', [
                        'url' => $this->resetUrl($notifiable),
                        'user' => $notifiable
                    ]);
            }
        });
    }


    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'activation_code',
        'registration_date',
        'last_access',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function student(): HasOne
    {
        return $this->hasOne(Student::class, 'user_id', 'id');
    }

    public function admin(): HasOne
    {
        return $this->hasOne(Admin::class, 'user_id', 'id');
    }
}
