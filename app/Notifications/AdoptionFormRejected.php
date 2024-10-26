<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\AdoptionForm;

class AdoptionFormRejected extends Notification implements ShouldQueue
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
            ->subject('Adoção Não Aprovada para ' . $this->adoptionForm->pet_name)
            ->greeting("Olá, {$notifiable->name}")
            ->line('Infelizmente, seu formulário de adoção para o pet ' . $this->adoptionForm->pet_name . ' não foi aprovado.')
            ->action('Ver Detalhes do Formulário de Adoção', url('/adoption-form/' . $this->adoptionForm->id))
            ->line('Agradecemos o seu interesse e esperamos que encontre um novo amigo em breve!');
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
            'message' => 'Lamentamos informar que seu formulário de adoção para ' . $this->adoptionForm->pet_name . ' foi rejeitado. Acesse nossa plataforma para saber mais detalhes.',
            'action_url' => url('/adoption-form/' . $this->adoptionForm->id),
        ];
    }
}
