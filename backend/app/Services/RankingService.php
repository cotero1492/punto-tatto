<?php

namespace App\Services;

use App\Models\Artist;
use App\Models\ArtistMembership;

class RankingService
{
    public function calculateRanking(Artist $artist): int
    {
        $score = 0;

        // Base score por membresía
        $membership = $artist->membership;
        if ($membership && $membership->isActive()) {
            $membershipPlan = $membership->membership;
            $score += $membershipPlan->ranking_bonus;
            
            // Bonus adicional si tiene priority_ranking
            if ($membershipPlan->priority_ranking) {
                $score += 100;
            }
        }

        // Score por calificación (0-5 puntos = 0-250 puntos)
        $score += ($artist->rating_average * 50);

        // Score por número de reseñas (cada reseña = 10 puntos, máximo 200)
        $score += min($artist->reviews_count * 10, 200);

        // Score por vistas (cada 10 vistas = 1 punto, máximo 100)
        $score += min((int)($artist->views_count / 10), 100);

        // Score por contactos (cada contacto = 5 puntos, máximo 150)
        $score += min($artist->contacts_count * 5, 150);

        // Score por antigüedad (días desde creación = puntos, máximo 100)
        $daysSinceCreation = $artist->created_at->diffInDays(now());
        $score += min($daysSinceCreation, 100);

        // Score por completitud del perfil
        $completenessScore = $this->calculateProfileCompleteness($artist);
        $score += $completenessScore;

        // Score por galería (cada foto = 2 puntos, máximo 100)
        $galleryCount = $artist->galleries()->count();
        $score += min($galleryCount * 2, 100);

        // Penalización si está suspendido
        if ($artist->is_suspended) {
            $score = 0;
        }

        // Bonus si está verificado
        if ($artist->is_verified) {
            $score += 50;
        }

        return (int) $score;
    }

    public function recalculateAllRankings()
    {
        $artists = Artist::active()->get();

        foreach ($artists as $artist) {
            $score = $this->calculateRanking($artist);
            $artist->update(['ranking_score' => $score]);
        }

        // Actualizar posiciones de ranking
        $this->updateRankingPositions();
    }

    public function updateRankingPositions()
    {
        $artists = Artist::where('ranking_score', '>', 0)
            ->active()
            ->orderBy('ranking_score', 'desc')
            ->orderBy('rating_average', 'desc')
            ->orderBy('reviews_count', 'desc')
            ->get();

        $position = 1;
        foreach ($artists as $artist) {
            $artist->update(['ranking_position' => $position]);
            $position++;
        }

        // Actualizar posiciones de artistas sin score
        Artist::where('ranking_score', 0)
            ->orWhereNull('ranking_position')
            ->update(['ranking_position' => null]);
    }

    public function updateArtistRanking(Artist $artist)
    {
        $score = $this->calculateRanking($artist);
        $artist->update(['ranking_score' => $score]);
        $this->updateRankingPositions();
    }

    private function calculateProfileCompleteness(Artist $artist): int
    {
        $fields = [
            'bio' => 10,
            'studio_name' => 10,
            'styles' => 15,
            'location' => 10,
            'address' => 10,
            'city' => 5,
            'state' => 5,
            'working_hours' => 10,
            'price_per_hour' => 10,
            'portfolio_url' => 5,
            'social_media' => 10,
        ];

        $totalScore = 0;
        foreach ($fields as $field => $points) {
            $value = $artist->$field;
            if (!empty($value)) {
                if (is_array($value) && count($value) > 0) {
                    $totalScore += $points;
                } elseif (!is_array($value)) {
                    $totalScore += $points;
                }
            }
        }

        return min($totalScore, 100); // Máximo 100 puntos
    }
}

