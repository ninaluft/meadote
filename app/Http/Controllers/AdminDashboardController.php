<?php

namespace App\Http\Controllers;

use App\Models\SupportRequest;
use App\Models\Pet;
use App\Models\AdoptionForm;
use App\Models\User;
use App\Models\OngEvent;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function adminDashboard(Request $request)
    {
        // Métricas de solicitações de suporte
        $openRequestsCount = SupportRequest::where('status', 'open')->count();
        $closedRequestsCount = SupportRequest::where('status', 'closed')->count();
        $totalRequestsCount = SupportRequest::count();

        // Métricas de pets
        $petsCount = Pet::count();

        // Métricas de formulários de adoção
        $formsCount = AdoptionForm::count();

        // Métricas de usuários
        $usersCount = User::count();

        // Métricas de eventos (Adicione isso)
        $eventsCount = OngEvent::count();

        // Retorna os dados para a view
        return view('admin.dashboard', compact(
            'openRequestsCount',
            'closedRequestsCount',
            'totalRequestsCount',
            'petsCount',
            'formsCount',
            'usersCount',
            'eventsCount'  // Adicione isso aqui
        ));
    }

    public function getUserDetails($id)
    {
        // Carregar o usuário com as relações de tutor, ONG, pets, e formulários de adoção
        $user = User::with(['tutor', 'ong', 'pets', 'adoptionForms'])->findOrFail($id);

        // Inicialize $userData com valores padrão
        $userData = [
            'name' => $user->name,
            'email' => $user->email,
            'user_type' => ucfirst($user->user_type),
            'city' => $user->city,
            'state' => $user->state,
            'cep' => $user->cep,
            'animals_count' => $user->pets ? $user->pets->count() : 0,
            'forms_count' => $user->adoptionForms ? $user->adoptionForms->count() : 0,
        ];

        // Verifique o tipo de usuário e adicione detalhes específicos
        if ($user->user_type == 'tutor' && $user->tutor) {
            $userData = array_merge($userData, [
                'full_name' => $user->tutor->full_name,
                'date_of_birth' => $user->tutor->date_of_birth,
                'cpf' => $user->tutor->cpf,
                'temporary_housing' => $user->tutor->temporary_housing ? 'Sim' : 'Não',
                'about_me' => $user->tutor->about_me,
            ]);
        } elseif ($user->user_type == 'ong' && $user->ong) {
            $userData = array_merge($userData, [
                'ong_name' => $user->ong->ong_name,
                'phone' => $user->ong->phone,
                'responsible_name' => $user->ong->responsible_name,
                'responsible_cpf' => $user->ong->responsible_cpf,
                'cnpj' => $user->ong->cnpj,
                'about_ong' => $user->ong->about_ong,
                'events_count' => $user->ong->events ? $user->ong->events->count() : 0,
            ]);
        }

        return response()->json($userData);
    }





    // Manage Users
    public function manageUsers(Request $request)
    {
        // Filtros de ordenação
        $sortBy = $request->get('sort_by', 'id');  // Campo de ordenação padrão
        $sortDirection = $request->get('sort_direction', 'asc');  // Direção de ordenação padrão

        // Filtro de busca por nome ou email
        $searchQuery = $request->get('search');

        // Query para listar usuários com filtro de busca e ordenação
        $users = User::when($searchQuery, function ($query, $searchQuery) {
            return $query->where('name', 'like', "%{$searchQuery}%")
                ->orWhere('email', 'like', "%{$searchQuery}%");
        })
            ->orderBy($sortBy, $sortDirection)
            ->paginate(20); // Paginação, altere o número de itens por página conforme necessário

        return view('admin.manage-users', compact('users', 'sortBy', 'sortDirection', 'searchQuery'));
    }


    // Delete User
    public function deleteUser(User $user)
    {
        $user->delete();
        return redirect()->route('admin.manage-users')->with('success', 'User deleted successfully.');
    }

    public function editUser(User $user)
    {
        // Exibir o formulário de edição do usuário com o tipo de usuário atual
        return view('admin.edit-user', compact('user'));
    }

    public function updateUser(Request $request, User $user)
    {
        // Validação do tipo de usuário
        $request->validate([
            'usertype' => 'required|in:tutor,ong,admin',  // Certifica-se de que os valores são válidos
        ]);

        // Atualiza o tipo de usuário
        $user->update([
            'user_type' => $request->input('usertype'),
        ]);

        return redirect()->route('admin.manage-users')->with('success', 'Tipo de usuário atualizado com sucesso.');
    }


    // Manage Pets

    public function managePets(Request $request)
    {
        $sortBy = $request->get('sort_by', 'id'); // Campo de ordenação padrão
        $sortDirection = $request->get('sort_direction', 'asc'); // Direção de ordenação padrão
        $search = $request->get('search'); // Valor da busca

        // Aplicar a busca e a ordenação na consulta dos pets
        $pets = Pet::with('user') // Carrega o relacionamento com o responsável pelo pet
            ->when($search, function ($query, $search) {
                return $query->where('name', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($query) use ($search) {
                        $query->where('name', 'like', "%{$search}%"); // Busca pelo nome do responsável
                    });
            })
            ->orderBy($sortBy, $sortDirection)
            ->paginate(20);

        return view('admin.manage-pets', compact('pets', 'sortBy', 'sortDirection', 'search'));
    }



    // Delete Pet
    public function deletePet(Pet $pet)
    {
        $pet->delete();
        return redirect()->route('admin.manage-pets')->with('success', 'Pet deleted successfully.');
    }



    // Manage Events
    public function manageEvents(Request $request)
    {
        $sortBy = $request->get('sort_by', 'title'); // Campo de ordenação padrão é 'title'
        $sortDirection = $request->get('sort_direction', 'asc'); // Direção de ordenação padrão
        $search = $request->get('search'); // Obtém o valor de busca

        // Obtém eventos com busca, ordenação e paginação
        $events = OngEvent::with('ong')
            ->when($search, function ($query, $search) {
                return $query->where('title', 'like', "%{$search}%")
                    ->orWhereHas('ong', function ($query) use ($search) {
                        $query->where('ong_name', 'like', "%{$search}%");
                    });
            })
            ->when($sortBy === 'ong_name', function ($query) use ($sortDirection) {
                return $query->join('ongs', 'ong_events.ong_id', '=', 'ongs.id')
                    ->orderBy('ongs.ong_name', $sortDirection);
            }, function ($query) use ($sortBy, $sortDirection) {
                return $query->orderBy($sortBy, $sortDirection);
            })
            ->paginate(20);

        return view('admin.manage-events', compact('events', 'sortBy', 'sortDirection', 'search'));
    }





    // Delete Event
    public function deleteEvent(OngEvent $event)
    {
        $event->delete();
        return redirect()->route('admin.manage-events')->with('success', 'Evento deletadp com sucesso.');
    }


    public function showUserPets($id)
    {
        $user = User::findOrFail($id);
        $pets = $user->pets; // Obtenha todos os pets registrados por este usuário
        return view('admin.user-pets', compact('user', 'pets'));
    }

    public function showUserForms($id)
    {
        $user = User::findOrFail($id);

        // Obtenha os formulários de adoção enviados e recebidos
        $sentForms = $user->adoptionForms; // Formulários enviados
        $receivedForms = $user->receivedAdoptionForms; // Formulários recebidos (responsável pelo pet)

        return view('admin.user-forms', compact('user', 'sentForms', 'receivedForms'));
    }

    public function showUserEvents($id)
    {
        $user = User::findOrFail($id);

        // Para ONGs, obtenha eventos, caso contrário, exiba 0 eventos
        $events = $user->user_type === 'ong' ? $user->ong->events : collect();

        return view('admin.user-events', compact('user', 'events'));
    }

    public function manageForms(Request $request)
    {
        $sortBy = $request->get('sort_by', 'id'); // Campo de ordenação padrão é 'id'
        $sortDirection = $request->get('sort_direction', 'asc'); // Direção de ordenação padrão

        $query = AdoptionForm::query();

        // Aplicar o filtro de status, se houver
        if ($request->has('form_status') && !empty($request->form_status)) {
            $query->where('status', $request->form_status);
        }

        // Aplicar ordenação e paginar os formulários
        $forms = $query->with(['pet', 'submitter'])->orderBy($sortBy, $sortDirection)->paginate(10);

        return view('admin.manage-forms', compact('forms', 'sortBy', 'sortDirection'));
    }

    // AdminDashboardController.php
    public function showUserDetails($id)
    {
        $user = User::with(['pets', 'ongEvents', 'adoptionFormsSent', 'adoptionFormsReceived'])->findOrFail($id);

        // Quantidades de pets, eventos, formulários
        $totalPets = $user->pets->count();
        $totalAdoptedPets = $user->pets->where('status', 'adopted')->count();
        $totalEvents = $user->user_type === 'ong' ? $user->ongEvents->count() : 0;
        $totalFormsSent = $user->adoptionFormsSent->count();
        $totalFormsReceived = $user->adoptionFormsReceived->count();

        return view('admin.user-details', compact('user', 'totalPets', 'totalAdoptedPets', 'totalEvents', 'totalFormsSent', 'totalFormsReceived'));
    }
}
