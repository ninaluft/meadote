<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\AdoptionForm;

class AdoptionFormSubmitted extends Notification implements ShouldQueue
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
            ->subject('Novo Formulário de Adoção Recebido')
            ->greeting("Olá, {$notifiable->name}!")
            ->line('Um novo formulário de adoção foi recebido para o seu pet: ' . $this->adoptionForm->pet_name)
            ->action('Ver Formulário de Adoção', url('/adoption-form/' . $this->adoptionForm->id))
            ->line('Obrigado por usar nossa plataforma para ajudar os animais a encontrarem lares amorosos!');
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
            'message' => 'Um novo formulário de adoção foi submetido para o seu pet ' . $this->adoptionForm->pet_name,
            'action_url' => url('/adoption-forms/' . $this->adoptionForm->id),
        ];
    }
}
