<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Courrier;


class AdminController extends Controller
{
    public function dashboard()
    {
        // Comptages utilisateurs
        $totalUsers = User::count();
        $countSecretaire = User::where('role', 'secretaire')->count();
        $countAdmin = User::where('role', 'admin')->count();

        // Total courriers
        $totalCourriers = Courrier::count();

        // Données pour graphique évolution courrier (par mois, année)
        $now = \Carbon\Carbon::now();
        $months = [];
        $countsPerMonth = [];

        // Par exemple, 12 derniers mois
        for ($i = 11; $i >= 0; $i--) {
            $date = $now->copy()->subMonths($i);
            $monthLabel = $date->format('M Y');  // ex : Jan 2023
            $months[] = $monthLabel;

            $count = Courrier::whereYear('jour_trans', $date->year)
                ->whereMonth('jour_trans', $date->month)
                ->count();

            $countsPerMonth[] = $count;
        }

        return view('admin.dashboard', compact(
            'totalUsers',
            'countSecretaire',
            'countAdmin',
            'totalCourriers',
            'months',
            'countsPerMonth'
        ));
    }


    public function listCourriers(Request $request)
    {
        // Vérification infra, facultative si middleware est bien configuré
        if (!Auth::user() || Auth::user()->role !== 'admin') {
            abort(403, 'Accès interdit');
        }

        $query = Courrier::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('num_enregistrement', 'like', "%{$search}%")
                    ->orWhere('nom_expediteur', 'like', "%{$search}%")
                    ->orWhere('destinataire', 'like', "%{$search}%")
                    ->orWhere('concerne', 'like', "%{$search}%");
            });
        }

        // Recherche par année
        if ($request->filled('annee')) {
            $annee = $request->input('annee');
            $query->where(function ($q) use ($annee) {
                $q->where('annee_transmise', $annee)
                    ->orWhere('annee_reception', $annee);
            });
        }

        // Recherche par mois
        if ($request->filled('mois')) {
            $mois = $request->input('mois');
            $query->where(function ($q) use ($mois) {
                $q->where('mois_transmis', $mois)
                    ->orWhere('mois_reception', $mois);
            });
        }

        $courriers = $query->orderByDesc('created_at')->paginate(10);

        return view('admin.courriers.index', compact('courriers'));
    }

    public function createSecretaire()
    {
        return view('admin.create-secretaire');
    }

    public function storeSecretaire(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'photo' => 'nullable|image|max:2048',
        ]);

        $data = $request->only('name', 'email');
        $data['password'] = bcrypt($request->password);
        $data['role'] = 'secretaire';

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $data['photo'] = $path;
        }

        \App\Models\User::create($data);

        return redirect()->route('admin.users')->with('success', 'Secrétaire créé avec succès.');
    }

    public function listUsers(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%$search%")
                ->orWhere('email', 'like', "%$search%");
        }

        $users = $query->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    public function editUser($id)
    {
        $user = User::findOrFail($id);

        return view('admin.users.edit', compact('user'));
    }

    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|max:2048',
        ]);

        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('photo')) {
            $path = $request->file('photo')->store('photos', 'public');
            $user->photo = $path;
        }

        $user->save();

        return redirect()->route('admin.users')->with('success', 'Utilisateur mis à jour.');
    }

    public function deleteUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('admin.users')->with('success', 'Utilisateur supprimé.');
    }
}
