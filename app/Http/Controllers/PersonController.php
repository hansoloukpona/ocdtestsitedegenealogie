<?php

namespace App\Http\Controllers;

use App\Models\Person;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PersonController extends Controller
{

    public function index()
    {
        $people = Person::with('creator')->paginate(10);  // Chargement avec l'utilisateur créateur
        return view('people.index', compact('people'));
    }

    public function show($id)
    {
        $people = Person::with(['children', 'parents'])->findOrFail($id);
        return view('people.show', compact('people'));
    }

    public function create()
    {
        return view('people.create');
    }

    public function store(Request $request)
    {
        // Validation des données
        $validatedData = $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_names' => 'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'birth_name' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date|date_format:Y-m-d',
            /*'email' => 'nullable|email|unique:people,email',
            'password' => 'nullable|string|min:8|confirmed',*/
        ]);

        // Formatage des données
        $validatedData['created_by'] = Auth::id();
        $validatedData['first_name'] = ucfirst(strtolower($validatedData['first_name']));
        $validatedData['middle_names'] = $validatedData['middle_names']
            ? collect(explode(',', $validatedData['middle_names']))
            ->map(fn($name) => ucfirst(strtolower(trim($name))))
            ->implode(', ')
            : null;
        $validatedData['last_name'] = strtoupper($validatedData['last_name']);
        $validatedData['birth_name'] = $validatedData['birth_name']
            ? strtoupper($validatedData['birth_name'])
            : $validatedData['last_name'];
        $validatedData['date_of_birth'] = $validatedData['date_of_birth'] ?? null;
        //$validatedData['password'] = Hash::make($validatedData['password']);

        // Enregistrement dans la base de données
        try {
            $person = Person::create($validatedData);
            //$person = $people->save();

            $cleanFirstName = preg_replace('/[^a-zA-Z]/', '', $person->first_name);
            $cleanLastName = preg_replace('/[^a-zA-Z]/', '', $person->last_name);

            $firstName = strtolower($cleanFirstName);
            $lastNameLower = strtolower($cleanLastName);
            $lastNameUpper = strtoupper($cleanLastName);

            $email = "{$firstName}{$lastNameLower}{$person->id}@ocd.com";
            $password = Hash::make("{$firstName}{$lastNameUpper}@2025");

            $person->update([
                'email' => $email,
                'password' => $password,
            ]);

            return redirect()->route('people.index')->with('success', 'Nouvelle personne ajoutée avec succès.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Une erreur est survenue lors de l\'ajout.' . $e])->withInput();
        }
    }

    public function getDegreeBetween($id1, $id2)
    {
        $person1 = Person::findOrFail($id1);
        $degree = $person1->getDegreeWith($id2);

        if ($degree === false) {
            return response()->json([
                'message' => 'Le degré de parenté est supérieur à 25 ou les personnes ne sont pas liées.',
                'degree' => null
            ], 404);
        }

        return response()->json([
            'message' => 'Degré de parenté trouvé.',
            'degree' => $degree
        ]);
    }

    public function showDegreeForm(Request $request)
    {
        $validatedData = $request->validate([
            'id2' => 'required|numeric',
        ]);

        $idOfTargetUser = $validatedData['id2'];

        $idOfCurrentUser = Auth::id();

        $person1 = Person::findOrFail($idOfCurrentUser);

        // Vérifier si l'ID cible est fourni
        if ($idOfTargetUser) {
            $person2 = Person::find($idOfTargetUser);
    
            if (!$person2) {
                return view('people.show', [
                    'people' => $person1,
                    'error' => 'Personne cible introuvable.'
                ]);
            }
            
            //DB::enableQueryLog();
            //$timestart = microtime(true);

            $degree = $person1->getDegreeWith($person2->id);

            // dd(["degree"=>$degree, "time"=>microtime(true)-$timestart, "nb_queries"=>count(DB::getQueryLog())]);

            if ($degree === false) {
                return view('people.show', [
                    'people' => $person1,
                    'error' => 'Le degré de parenté est supérieur à 25 ou les personnes ne sont pas liées.'
                ]);
            }

            return view('people.show', [
                'people' => $person1,
                'degree' => $degree
            ]);
        }

        return view('people.show', ['people' => $person1]);
    }
}
