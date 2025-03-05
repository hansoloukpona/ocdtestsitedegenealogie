<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;

class Person extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    protected $table = 'people';

    protected $fillable = [
        'created_by',
        'first_name',
        'last_name',
        'birth_name',
        'middle_names',
        'date_of_birth',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function children()
    {
        return $this->belongsToMany(
            Person::class,
            'relationships',
            'parent_id',
            'child_id'
        );
    }

    public function parents()
    {
        return $this->belongsToMany(
            Person::class,
            'relationships',
            'child_id',
            'parent_id'
        );
    }

    public function creator()
    {
        return $this->belongsTo(Person::class, 'created_by');
    }

    public function getDegreeWith($target_person_id)
    {
        // Limite maximale pour éviter des boucles infinies
        $maxDegree = 25;
        $currentDegree = 0;

        // Garde trace des personnes déjà visitées pour éviter des boucles
        $visited = [$this->id];
        $queue = [[$this->id]]; // File d'attente pour le BFS (parcours en largeur)

        // Parcours en largeur (BFS)
        while (!empty($queue) && $currentDegree <= $maxDegree) {
            $currentDegree++;
            $newQueue = [];

            foreach ($queue as $path) {
                $lastPersonId = end($path);

                // Récupération des relations directes (parents et enfants)
                $relations = DB::select("
                SELECT r.parent_id AS person_id FROM relationships r WHERE r.child_id = ?
                UNION
                SELECT r.child_id AS person_id FROM relationships r WHERE r.parent_id = ?
            ", [$lastPersonId, $lastPersonId]);

                foreach ($relations as $relation) {
                    $personId = $relation->person_id;

                    // Si on trouve la personne cible, retourne le degré actuel
                    if ($personId == $target_person_id) {
                        return $currentDegree;
                    }

                    // Si la personne n'a pas encore été visitée, l'ajoute pour exploration
                    if (!in_array($personId, $visited)) {
                        $visited[] = $personId;
                        $newQueue[] = array_merge($path, [$personId]);
                    }
                }
            }

            $queue = $newQueue;
        }

        // Si aucune relation trouvée dans la limite de 25, retourne false
        return false;
    }
}
