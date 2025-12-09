<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Artist;
use App\Models\Client;
use App\Models\Membership;
use App\Models\Payment;
use App\Models\Advertisement;
use App\Models\Review;
use App\Services\RankingService;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    protected $rankingService;

    public function __construct(RankingService $rankingService)
    {
        $this->rankingService = $rankingService;
    }

    public function dashboard()
    {
        $stats = [
            'artists' => [
                'total' => Artist::count(),
                'active' => Artist::active()->count(),
                'verified' => Artist::verified()->count(),
                'with_membership' => Artist::whereHas('membership', function ($q) {
                    $q->where('status', 'active');
                })->count(),
            ],
            'clients' => [
                'total' => Client::count(),
                'active' => Client::whereHas('user', function ($q) {
                    $q->where('is_active', true);
                })->count(),
            ],
            'payments' => [
                'total' => Payment::completed()->sum('amount'),
                'this_month' => Payment::completed()
                    ->whereMonth('created_at', now()->month)
                    ->sum('amount'),
                'pending' => Payment::pending()->count(),
            ],
            'memberships' => [
                'active' => \App\Models\ArtistMembership::active()->count(),
                'expired' => \App\Models\ArtistMembership::expired()->count(),
            ],
            'reviews' => [
                'total' => Review::count(),
                'pending' => Review::where('is_approved', false)->count(),
            ],
        ];

        return response()->json([
            'stats' => $stats,
        ]);
    }

    // Gestión de artistas
    public function indexArtists(Request $request)
    {
        $query = Artist::with(['user', 'membership.membership']);

        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('studio_name', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->has('status')) {
            switch ($request->status) {
                case 'verified':
                    $query->verified();
                    break;
                case 'suspended':
                    $query->where('is_suspended', true);
                    break;
                case 'unverified':
                    $query->where('is_verified', false);
                    break;
            }
        }

        $artists = $query->paginate($request->get('per_page', 15));

        return response()->json($artists);
    }

    public function showArtist($id)
    {
        $artist = Artist::with(['user', 'membership.membership', 'galleries', 'reviews'])->findOrFail($id);

        return response()->json([
            'artist' => $artist,
        ]);
    }

    public function verifyArtist($id)
    {
        $artist = Artist::findOrFail($id);
        $artist->update(['is_verified' => true]);
        $this->rankingService->updateArtistRanking($artist);

        return response()->json([
            'artist' => $artist->load(['user', 'membership.membership']),
            'message' => 'Artista verificado exitosamente',
        ]);
    }

    public function suspendArtist($id)
    {
        $artist = Artist::findOrFail($id);
        $artist->update(['is_suspended' => !$artist->is_suspended]);
        $this->rankingService->updateArtistRanking($artist);

        return response()->json([
            'artist' => $artist->load(['user', 'membership.membership']),
            'message' => $artist->is_suspended ? 'Artista suspendido' : 'Artista activado',
        ]);
    }

    // Gestión de clientes
    public function indexClients(Request $request)
    {
        $query = Client::with('user');

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereHas('user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $clients = $query->paginate($request->get('per_page', 15));

        return response()->json($clients);
    }

    public function showClient($id)
    {
        $client = Client::with(['user', 'favorites.artist.user', 'reviews.artist.user'])->findOrFail($id);

        return response()->json([
            'client' => $client,
        ]);
    }

    // Gestión de membresías
    public function getMemberships()
    {
        $memberships = Membership::ordered()->get();

        return response()->json([
            'memberships' => $memberships,
        ]);
    }

    public function updateMembership(Request $request, $id)
    {
        $membership = Membership::findOrFail($id);

        $request->validate([
            'name' => 'sometimes|string|max:255',
            'price' => 'sometimes|numeric|min:0',
            'duration_days' => 'sometimes|integer|min:1',
            'max_photos' => 'nullable|integer',
            'is_active' => 'sometimes|boolean',
        ]);

        $membership->update($request->all());

        return response()->json([
            'membership' => $membership,
            'message' => 'Membresía actualizada exitosamente',
        ]);
    }

    // Pagos
    public function getPayments(Request $request)
    {
        $query = Payment::with(['artist.user', 'membership']);

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        if ($request->has('artist_id')) {
            $query->where('artist_id', $request->artist_id);
        }

        $payments = $query->orderBy('created_at', 'desc')->paginate($request->get('per_page', 15));

        return response()->json($payments);
    }

    public function getPayment($id)
    {
        $payment = Payment::with(['artist.user', 'membership', 'artistMembership'])->findOrFail($id);

        return response()->json([
            'payment' => $payment,
        ]);
    }

    // Publicidad
    public function indexAdvertisements(Request $request)
    {
        $query = Advertisement::with('artist.user');

        if ($request->has('position')) {
            $query->byPosition($request->position);
        }

        if ($request->has('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        $advertisements = $query->ordered()->paginate($request->get('per_page', 15));

        return response()->json($advertisements);
    }

    public function storeAdvertisement(Request $request)
    {
        $request->validate([
            'artist_id' => 'nullable|exists:artists,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'required|string',
            'link_url' => 'nullable|url',
            'type' => 'required|in:banner,spotlight,sidebar',
            'position' => 'required|in:home,artists_list,artist_profile',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'is_active' => 'nullable|boolean',
        ]);

        $advertisement = Advertisement::create($request->all());

        return response()->json([
            'advertisement' => $advertisement->load('artist.user'),
            'message' => 'Publicidad creada exitosamente',
        ], 201);
    }

    public function updateAdvertisement(Request $request, $id)
    {
        $advertisement = Advertisement::findOrFail($id);

        $request->validate([
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'image_url' => 'sometimes|string',
            'link_url' => 'nullable|url',
            'is_active' => 'sometimes|boolean',
        ]);

        $advertisement->update($request->all());

        return response()->json([
            'advertisement' => $advertisement->load('artist.user'),
            'message' => 'Publicidad actualizada exitosamente',
        ]);
    }

    public function destroyAdvertisement($id)
    {
        $advertisement = Advertisement::findOrFail($id);
        $advertisement->delete();

        return response()->json([
            'message' => 'Publicidad eliminada exitosamente',
        ]);
    }

    // Ranking
    public function getRankingConfig()
    {
        // Retornar configuración del ranking
        return response()->json([
            'factors' => [
                'membership_bonus' => 'Bonificación por membresía',
                'rating' => 'Calificación promedio',
                'reviews_count' => 'Número de reseñas',
                'views' => 'Vistas del perfil',
                'contacts' => 'Contactos recibidos',
                'age' => 'Antigüedad de la cuenta',
                'profile_completeness' => 'Completitud del perfil',
                'gallery' => 'Galería de trabajos',
            ],
        ]);
    }

    public function recalculateRanking()
    {
        $this->rankingService->recalculateAllRankings();

        return response()->json([
            'message' => 'Ranking recalculado exitosamente',
        ]);
    }

    // Reportes
    public function usersReport()
    {
        $report = [
            'artists' => [
                'total' => Artist::count(),
                'with_membership' => Artist::whereHas('membership', function ($q) {
                    $q->where('status', 'active');
                })->count(),
                'verified' => Artist::verified()->count(),
            ],
            'clients' => [
                'total' => Client::count(),
                'active' => Client::whereHas('user', function ($q) {
                    $q->where('is_active', true);
                })->count(),
            ],
        ];

        return response()->json($report);
    }

    public function paymentsReport(Request $request)
    {
        $query = Payment::completed();

        if ($request->has('start_date')) {
            $query->where('created_at', '>=', $request->start_date);
        }

        if ($request->has('end_date')) {
            $query->where('created_at', '<=', $request->end_date);
        }

        $report = [
            'total_amount' => $query->sum('amount'),
            'total_transactions' => $query->count(),
            'by_membership' => Payment::completed()
                ->selectRaw('membership_id, SUM(amount) as total, COUNT(*) as count')
                ->groupBy('membership_id')
                ->with('membership')
                ->get(),
        ];

        return response()->json($report);
    }

    // Aprobar/Rechazar reseñas
    public function approveReview($id)
    {
        $review = Review::findOrFail($id);
        $review->update(['is_approved' => true]);
        $this->rankingService->updateArtistRanking($review->artist);

        return response()->json([
            'review' => $review->load(['artist.user', 'client.user']),
            'message' => 'Reseña aprobada exitosamente',
        ]);
    }

    public function rejectReview($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();
        $this->rankingService->updateArtistRanking($review->artist);

        return response()->json([
            'message' => 'Reseña rechazada y eliminada',
        ]);
    }
}

