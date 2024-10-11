<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\AdoptionForm;
use App\Models\Message;
use App\Models\Pet;
use App\Models\User;
use App\Notifications\AdoptionFormCancelled;
use App\Notifications\AdoptionFormSubmitted;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use App\Notifications\AdoptionFormAccepted;
use App\Notifications\AdoptionFormRejected;
use HTMLPurifier;
use HTMLPurifier_Config;

class AdoptionFormController extends Controller
{
    public function create(Pet $pet)
    {
        // Check if the user has already submitted a form for this pet
        $existingForm = AdoptionForm::where('submitter_user_id', Auth::id())
            ->where('pet_id', $pet->id)
            ->first();

        if ($existingForm) {
            return redirect()->route('pets.show', $pet->id)
                ->with('error', 'You have already submitted an adoption request for this pet.');
        }

        // Ensure the pet is still available for adoption
        if ($pet->status !== 'available') {
            return redirect()->back()->with('error', 'This pet is no longer available for adoption.');
        }

        // Recupera o usuário que cadastrou o pet
        $responsibleUser = $pet->user;

        // Verifica se o usuário é uma ONG ou um Tutor e recupera o nome completo
        if ($responsibleUser->user_type === 'ong') {
            $responsibleName = $responsibleUser->ong->ong_name ?? 'Nome não disponível';
        } elseif ($responsibleUser->user_type === 'tutor') {
            $responsibleName = $responsibleUser->tutor->full_name ?? 'Nome não disponível';
        } else {
            $responsibleName = 'Usuário desconhecido';
        }

        return view('adoption-form.create', compact('pet', 'responsibleName'));
    }

    public function store(Request $request, Pet $pet)
    {
        // Check if the user has already submitted a form for this pet
        $existingForm = AdoptionForm::where('submitter_user_id', Auth::id())
            ->where('pet_id', $pet->id)
            ->first();

        if ($existingForm) {
            return redirect()->back()->with('error', 'You have already submitted a request for this pet.');
        }

        $request->validate([
            'full_name' => 'required|string|max:255',
            'cpf' => 'required|string|max:14',
            'birth_date' => 'required|date',
            'cep' => 'required|string|max:9',
            'city' => 'required|string|max:255',
            'state' => 'required|string|max:255',
            'street' => 'required|string|max:255',
            'number' => 'required|string|max:10',
            'complement' => 'nullable|string|max:255',
            'neighborhood' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'marital_status' => 'required|string|max:50',
            'profession' => 'required|string|max:255',
            'residence_type' => 'required|string|in:house,apartment',
            'residence_ownership' => 'required|string|in:owned,rented',
            'outdoor_space' => 'required|boolean',
            'safety_measures' => 'required|boolean',
            'number_of_residents' => 'required|integer|min:1',
            'has_children' => 'required|boolean',
            'has_other_pets' => 'required|boolean',
            'other_pets_details' => 'nullable|string',
            'adoption_reason' => 'required|string|max:1000',

            'long_term_commitment' => ['required', 'accepted'], // Checkbox must be accepted
            'willing_to_castrate' => ['required', 'accepted'],
            'accept_future_visits' => ['required', 'accepted'],
            'declaration_of_truth' => ['required', 'accepted'],
        ]);

        // Obter o nome completo do responsável pelo pet, considerando se é tutor ou ONG
        $responsibleUser = $pet->user;

        if ($responsibleUser->user_type === 'ong') {
            $responsibleName = $responsibleUser->ong->ong_name ?? 'Nome não disponível';
        } elseif ($responsibleUser->user_type === 'tutor') {
            $responsibleName = $responsibleUser->tutor->full_name ?? 'Nome não disponível';
        } else {
            $responsibleName = 'Usuário desconhecido';
        }

        // Criação do formulário de adoção
        $adoptionForm = AdoptionForm::create([
            'submitter_user_id' => Auth::id(),
            'submitter_name' => $request->input('full_name'),
            'pet_id' => $pet->id,
            'pet_name' => $pet->name,
            'species' => $pet->species == 'outro' ? $pet->species_description : $pet->species, // Adiciona a espécie do pet ou a descrição de "outro"
            'responsible_user_id' => $pet->user->id,
            'responsible_user_name' => $responsibleName, // Atualiza para salvar o nome completo certo
            'cpf' => $request->cpf,
            'birth_date' => $request->birth_date,
            'cep' => $request->cep,
            'city' => $request->city,
            'state' => $request->state,
            'street' => $request->street,
            'number' => $request->number,
            'complement' => $request->complement,
            'neighborhood' => $request->neighborhood,
            'phone' => $request->phone,
            'email' => $request->email,
            'marital_status' => $request->marital_status,
            'profession' => $request->profession,
            'residence_type' => $request->residence_type,
            'residence_ownership' => $request->residence_ownership,
            'outdoor_space' => (bool) $request->outdoor_space, // Garantir que seja booleano
            'safety_measures' => (bool) $request->safety_measures, // Garantir que seja booleano
            'number_of_residents' => $request->number_of_residents,
            'has_children' => (bool) $request->has_children, // Garantir que seja booleano
            'children_details' => $request->children_details,
            'has_other_pets' => (bool) $request->has_other_pets, // Garantir que seja booleano
            'other_pets_details' => $request->other_pets_details,
            'adoption_reason' => $request->adoption_reason,

            'long_term_commitment' => (bool) $request->long_term_commitment, // Garantir que seja booleano
            'willing_to_castrate' => (bool) $request->willing_to_castrate, // Garantir que seja booleano
            'accept_future_visits' => (bool) $request->accept_future_visits, // Garantir que seja booleano
            'declaration_of_truth' => (bool) $request->declaration_of_truth, // Garantir que seja booleano
            'status' => 'pending',
            'is_read' => false,
        ]);



        // Send notification to the pet's owner
        $this->notifyAdoptionRequest($pet->user->id, $adoptionForm);

        return redirect()->route('pets.show', $pet->id)->with('success', 'Seu formulário de adoção foi enviado.');
    }

    public function notifyAdoptionRequest($userId, AdoptionForm $adoptionForm)
    {
        $user = User::find($userId);

        $link = route('adoption-form.show', ['adoptionForm' => $adoptionForm->id]);
        $message = "Você recebeu um novo formulário de adoção para o pet {$adoptionForm->pet->name}. ";
        $message .= "<a href='{$link}' class='inline-flex items-center px-4 py-2 bg-blue-500 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150'>Ver</a>";

        // Envia a notificação como mensagem do sistema (inbox)
        $this->sendSystemNotification($user->id, $message);

        // Envia notificação por email
        $user->notify(new AdoptionFormSubmitted($adoptionForm));

        return response()->json(['status' => 'Notification sent successfully']);
    }



    public function sendSystemNotification($userId, $messageContent)
    {
        // Obtém o usuário "Sistema"
        $systemUser = User::where('email', 'sistema@meadote.com')->first();

        // Cria a mensagem no inbox como se fosse enviada pelo sistema
        $message = Message::create([
            'sender_id' => $systemUser->id,  // Usuário "Sistema"
            'recipient_id' => $userId,
            'content' => $messageContent,
            'is_read' => false,
        ]);

        return $message;
    }

    public function inbox()
    {
        $userId = Auth::id();

        // Carregar notificações e mensagens
        $notifications = Auth::user()->notifications()->whereNull('read_at')->get();

        $conversations = Message::where('recipient_id', $userId)
            ->orWhere('sender_id', $userId)
            ->with(['sender', 'recipient'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->unique(function ($message) use ($userId) {
                return $message->sender_id === $userId ? $message->recipient_id : $message->sender_id;
            });

        return view('messages.inbox', compact('conversations', 'notifications'));
    }


    public function index()
    {
        // Retrieve adoption forms for pets owned by the logged-in user
        $adoptionForms = AdoptionForm::whereHas('pet', function ($query) {
            $query->where('responsible_user_id', Auth::id());
        })->where('status', 'pending')->get();

        return view('adoption-form.index', compact('adoptionForms'));
    }

    public function evaluated()
    {
        return view('adoption-form.evaluated');
    }

    public static function unreadCount()
    {
        return AdoptionForm::whereHas('pet', function ($query) {
            $query->where('responsible_user_id', Auth::id());
        })->where('is_read', false)->count();
    }

    public function updateStatus(Request $request, AdoptionForm $adoptionForm, $status)
    {
        // Verifica se o usuário autenticado é o responsável pelo pet
        if (Auth::id() !== $adoptionForm->pet->user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Verifica se o status é válido
        if (!in_array($status, ['approved', 'rejected'])) {
            abort(400, 'Invalid status.');
        }

        $data = ['status' => $status];

        // Se for rejeitado, valida e adiciona a razão de rejeição
        if ($status === 'rejected') {
            $request->validate([
                'rejection_reason' => 'required|string|max:1000',
            ]);
            $data['rejection_reason'] = $request->rejection_reason;
        }

        // Atualiza o status do formulário de adoção
        $adoptionForm->update($data);

        // Atualiza o status do pet para "adotado" se for aprovado
        if ($status === 'approved') {
            $adoptionForm->pet->update(['status' => 'adopted']);
            // Notifica o solicitante de que a adoção foi aprovada
            $this->notifyAdoptionApproval($adoptionForm->submitter->id, $adoptionForm);
        }

        // Se rejeitado, notifica o solicitante de que foi rejeitado
        if ($status === 'rejected') {
            $this->notifyAdoptionRejection($adoptionForm->submitter->id, $adoptionForm);
        }

        // Traduz o status para exibição na mensagem
        $statusTranslation = __('adoption-form.' . $status);

        return redirect()->back()->with('success', 'O formulário de adoção foi ' . $statusTranslation . '.');
    }



    public function notifyAdoptionApproval($userId, AdoptionForm $adoptionForm)
    {
        $user = User::find($userId);
        $message = "Parabéns! Seu formulário de adoção para o pet {$adoptionForm->pet->name} foi aceito.";

        // Envia a notificação como mensagem do sistema (inbox)
        $this->sendSystemNotification($user->id, $message);

        // Envia notificação por email
        $user->notify(new AdoptionFormAccepted($adoptionForm));
    }


    public function notifyAdoptionRejection($userId, AdoptionForm $adoptionForm)
    {
        $user = User::find($userId);
        $message = "Seu formulário de adoção para o pet {$adoptionForm->pet->name} foi rejeitado.";

        // Envia a notificação como mensagem do sistema (inbox)
        $this->sendSystemNotification($user->id, $message);

        // Envia notificação por email
        $user->notify(new AdoptionFormRejected($adoptionForm));
    }


    public function received()
    {
        // Retrieve all pending and evaluated adoption forms
        $pendingForms = AdoptionForm::whereHas('pet', function ($query) {
            $query->where('responsible_user_id', Auth::id());
        })->where('status', 'pending')->get();

        $evaluatedForms = AdoptionForm::whereHas('pet', function ($query) {
            $query->where('responsible_user_id', Auth::id());
        })->whereIn('status', ['approved', 'rejected'])->get();

        return view('adoption-form.received', compact('pendingForms', 'evaluatedForms'));
    }

    public function submitted()
    {
        // Buscar todos os formulários de adoção enviados pelo usuário logado
        $adoptionForms = AdoptionForm::where('submitter_user_id', Auth::id())->get();

        // Traduzir os campos dos formulários submetidos
        foreach ($adoptionForms as $form) {
            $form->status = __('adoption-form.' . $form->status);
            $form->residence_type = __('adoption-form.residence_type_options.' . $form->residence_type);
            $form->residence_ownership = __('adoption-form.residence_ownership_options.' . $form->residence_ownership);
            $form->marital_status = __('adoption-form.marital_status_options.' . $form->marital_status);
        }

        // Traduzir os textos do formulário
        $translations = [
            'submitted_forms' => __('adoption-form.submitted_forms'),
            'pet_name' => __('adoption-form.pet_name'),
            'status' => __('adoption-form.status'),
            'residence_type' => __('adoption-form.residence_type'),
            'residence_ownership' => __('adoption-form.residence_ownership'),
            'marital_status' => __('adoption-form.marital_status'),
            'view_full_form' => __('adoption-form.view_full_form'),
        ];

        return view('adoption-form.submitted', compact('adoptionForms', 'translations'));
    }


    public function show(AdoptionForm $adoptionForm)
    {
        // Carrega o formulário de adoção com o pet e o usuário que o submeteu
        $adoptionForm = AdoptionForm::findOrFail($adoptionForm->id);

        $user = Auth::user();

        // Verificar se o usuário autenticado é o administrador, o aplicante ou o tutor do pet
        if ($user->user_type !== 'admin' && $user->id !== $adoptionForm->submitter_user_id && $user->id !== $adoptionForm->responsible_user_id) {
            abort(403, 'Ação não autorizada.');
        }

        // Traduções dos campos do formulário
        $translations = [
            'adoption_form_for' => __('adoption-form.adoption_form_for', ['petName' => $adoptionForm->pet_name]),
            'pet_information' => __('adoption-form.pet_information'),
            'applicant_information' => __('adoption-form.applicant_information'),
            'address_information' => __('adoption-form.address_information'),
            'house_information' => __('adoption-form.house_information'),
            'motivation_and_expectations' => __('adoption-form.motivation_and_expectations'),
            'form_status' => __('adoption-form.form_status'),

            'pet_name' => __('adoption-form.pet_name'),
            'species' => __('adoption-form.species'),
            'registered_by' => __('adoption-form.registered_by'),

            'full_name' => __('adoption-form.full_name'),
            'cpf' => __('adoption-form.cpf'),
            'birth_date' => __('adoption-form.birth_date'),
            'phone' => __('adoption-form.phone'),
            'email' => __('adoption-form.email'),
            'marital_status' => __('adoption-form.marital_status'),
            'profession' => __('adoption-form.profession'),

            'cep' => __('adoption-form.cep'),
            'city' => __('adoption-form.city'),
            'state' => __('adoption-form.state'),
            'street' => __('adoption-form.street'),
            'number' => __('adoption-form.number'),
            'complement' => __('adoption-form.complement'),
            'neighborhood' => __('adoption-form.neighborhood'),

            'residence_type' => __('adoption-form.residence_type'),
            'residence_ownership' => __('adoption-form.residence_ownership'),
            'outdoor_space' => __('adoption-form.outdoor_space'),
            'safety_measures' => __('adoption-form.safety_measures'),
            'number_of_residents' => __('adoption-form.number_of_residents'),
            'has_children' => __('adoption-form.has_children'),
            'children_details' => __('adoption-form.children_details'),
            'has_other_pets' => __('adoption-form.has_other_pets'),
            'other_pets_details' => __('adoption-form.other_pets_details'),
            'other_animals_pets' => __('adoption-form.other_animals_pets'),

            'adoption_reason' => __('adoption-form.adoption_reason'),
            'adoption_expectations' => __('adoption-form.adoption_expectations'),
            'long_term_commitment' => __('adoption-form.long_term_commitment'),
            'willing_to_sign_commitment' => __('adoption-form.willing_to_sign_commitment'),
            'willing_to_castrate' => __('adoption-form.willing_to_castrate'),
            'accept_future_visits' => __('adoption-form.accept_future_visits'),
            'declaration_of_truth' => __('adoption-form.declaration_of_truth'),

            'status' => __('adoption-form.status'),
            'rejection_reason' => __('adoption-form.rejection_reason'),
            'approve_adoption' => __('adoption-form.approve_adoption'),
            'reject_adoption' => __('adoption-form.reject_adoption'),
            'confirm_approval' => __('adoption-form.confirm_approval'),
            'confirm_rejection' => __('adoption-form.confirm_rejection'),
        ];

        // Traduzir status e outros campos enumerados para exibição
        $adoptionForm->translated_status = __('adoption-form.' . $adoptionForm->status);
        $adoptionForm->translated_status = __('adoption-form.' . $adoptionForm->status);
        $adoptionForm->translated_residence_type = __('adoption-form.residence_type_options.' . $adoptionForm->residence_type);
        $adoptionForm->translated_residence_ownership = __('adoption-form.residence_ownership_options.' . $adoptionForm->residence_ownership);
        $adoptionForm->translated_marital_status = __('adoption-form.marital_status_options.' . $adoptionForm->marital_status);

        // Retorna a view com o formulário de adoção e as traduções
        return view('adoption-form.show', compact('adoptionForm', 'translations'));
    }


    public function cancel(AdoptionForm $adoptionForm)
    {
        // Verifica se o usuário que está cancelando é o que enviou o formulário
        if (Auth::id() !== $adoptionForm->submitter_user_id) {
            abort(403, 'Unauthorized action.');
        }

        // Verifica se o formulário ainda está pendente
        if ($adoptionForm->status !== 'pending') {
            return redirect()->back()->with('error', 'You can only cancel pending requests.');
        }

        // Verifica se o responsável pelo pet ainda existe e notifica sobre o cancelamento
        if ($adoptionForm->pet && $adoptionForm->pet->user) {
            $this->notifyAdoptionCancellation($adoptionForm->pet->user->id, $adoptionForm);
        }

        // Exclui o formulário de adoção
        $adoptionForm->delete();

        return redirect()->route('adoption-form.submitted')->with('success', 'O formulário de adoção foi cancelado.');
    }


    public function notifyAdoptionCancellation($userId, AdoptionForm $adoptionForm)
    {
        $user = User::find($userId);
        if ($user) {
            $message = "O formulário de adoção para o pet {$adoptionForm->pet_name} foi cancelado.";

            // Envia a notificação como mensagem do sistema (inbox)
            $this->sendSystemNotification($user->id, $message);

            // Envia notificação por email
            $user->notify(new AdoptionFormCancelled($adoptionForm));
        }
    }
}
