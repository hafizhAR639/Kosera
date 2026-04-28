<?php

namespace App\Controllers\Mitra;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Helpers;
use App\Models\Mitra\OrderModel;

class IncomingOrdersController extends Controller
{
    public function index(): void
    {
        Auth::requireLogin();

        $userId = (int)Auth::getCurrentUserId();
        $model = new OrderModel();

        $this->render('mitra/orders_incoming', [
            'title' => 'Orderan Masuk',
            'orders' => $model->getIncomingOrders($userId),
            'statusLabel' => [
                'pending' => 'Pending',
                'confirmed' => 'Dikonfirmasi',
                'in_progress' => 'Dikerjakan',
            ],
            'message' => Helpers::getMessage(),
        ], 'mitra');
    }

    public function updateStatus(): void
    {
        Auth::requireLogin();

        $userId = (int)Auth::getCurrentUserId();
        $model = new OrderModel();

        $action = $_POST['action'] ?? '';
        $orderId = (int)($_POST['order_id'] ?? 0);

        if ($orderId > 0 && in_array($action, ['accept', 'reject'], true)) {
            $nextStatus = $action === 'accept' ? 'confirmed' : 'cancelled';
            $updated = $model->updateIncomingOrderStatus($userId, $orderId, $nextStatus);

            if ($updated) {
                Helpers::setMessage('success', $action === 'accept' ? 'Order berhasil diterima.' : 'Order berhasil ditolak.');
            } else {
                Helpers::setMessage('error', 'Order tidak ditemukan atau gagal diperbarui.');
            }
        } else {
            Helpers::setMessage('error', 'Permintaan tidak valid.');
        }

        $this->redirect(Helpers::routePath('/mitra/orders/incoming'));
    }
}
