<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\AdoptionForm;

class AdoptionFormAccepted extends Notification implements ShouldQueue
{
    use Queueable;

    protected $adoptionForm;

    /**
     * Create a new notification instance.
     */
    public function __construct(AdoptionForm $adoptionForm)
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
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Formulário de Adoção Aprovado para ' . $this->adoptionForm->pet_name)
            ->greeting("Olá, {$notifiable->name}!")
            ->line('Estamos felizes em informar que o seu formulário de adoção para o pet ' . $this->adoptionForm->pet_name . ' foi aprovado.')
            ->action('Ver Formulário de Adoção', url('/adoption-form/' . $this->adoptionForm->id))
            ->line('Parabéns! Agora você pode prosseguir com o processo de adoção.');
    }

    /**
     * Get the array representation of the notification for database storage.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'adoptionForm_id' => $this->adoptionForm->id,
            'pet_name' => $this->adoptionForm->pet_name,
            'message' => 'Seu formulário de adoção para ' . $this->adoptionForm->pet_name . ' foi aprovado.',
            'action_url' => url('/adoption-form/' . $this->adoptionForm->id),
        ];
    }
}
