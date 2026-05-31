<?php

namespace App\Controllers\Mitra;

use App\Core\Auth;
use App\Core\Controller;
use App\Core\Helpers;

class IncomingOrdersController extends Controller
{
	public function index(): void
	{
		Auth::requireLogin();

		$userId = (int) Auth::getCurrentUserId();

		$service = new \App\Services\MitraService(new \App\Repositories\MitraRepository());

		$orders = $service->getIncomingOrders($userId);

		$this->render('mitra/orders_incoming', [
			'title' => 'Orderan Masuk',
			'message' => Helpers::getMessage(),
			'orders' => $orders,
		], 'mitra');
	}

	public function updateStatus(): void
	{
		Auth::requireLogin();

		$userId = (int) Auth::getCurrentUserId();
		$orderId = (int) ($_POST['order_id'] ?? 0);
		$status = trim((string) ($_POST['status'] ?? ''));

		if ($orderId <= 0 || $status === '') {
			Helpers::setMessage('error', 'Invalid request.');
			$this->redirect(Helpers::routePath('/mitra/orders/incoming'));
		}

		$service = new \App\Services\MitraService(new \App\Repositories\MitraRepository());

		$ok = $service->updateIncomingOrderStatus($userId, $orderId, $status);

		if ($ok) {
			Helpers::setMessage('success', 'Status pesanan berhasil diperbarui.');
		} else {
			Helpers::setMessage('error', 'Gagal memperbarui status pesanan.');
		}

		$this->redirect(Helpers::routePath('/mitra/orders/incoming'));
	}
}

