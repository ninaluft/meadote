<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\AdoptionForm;  // Importando o modelo AdoptionForm

class AdoptionFormAccepted extends Notification
{
    use Queueable;

    protected $adoptionForm;

    /**
     * Create a new notification instance.
     */
    public function __construct(AdoptionForm $adoptionForm) // Passando o formulário de adoção como parâmetro
    {
        $this->adoptionForm = $adoptionForm;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];  // Envia tanto por e-mail quanto para o banco de dados (inbox)
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->line('Your adoption form for the pet ' . $this->adoptionForm->pet_name . ' has been accepted.')
            ->action('View Adoption Form', url('/adoption-forms/' . $this->adoptionForm->id))
            ->line('Congratulations! You can now proceed with the adoption process.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'adoptionForm_id' => $this->adoptionForm->id,
            'pet_name' => $this->adoptionForm->pet_name,
            'message' => 'Your adoption form for ' . $this->adoptionForm->pet_name . ' has been accepted.'
        ];
    }
}
