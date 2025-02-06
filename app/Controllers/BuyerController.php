<?php

namespace App\Controllers;

use App\Models\BuyerTransaction;
use Core\Controller;
use Core\Validator;

class BuyerController extends Controller
{
    private BuyerTransaction $model;

    function __construct()
    {
        $this->model = new BuyerTransaction();
    }

    public function index(): void
    {
        $users = $this->model->getAll();
        $this->loadView('users.php', ['users' => $users]);
    }

    public function create(): void
    {
        $this->loadView('buyer-form.php');
    }

    public function report(): void
    {
        $this->loadView('buyer-report.php');
    }

    public function load(): void
    {
        $users = $this->model->getAll();
        $this->loadView('user_grid.php', ['users' => $users]);
    }

    public function store(): void
    {
        try {
            $response = ['success' => false];
            $validator = new Validator();

            $errors = $validator->validate([
                'amount' => ['required', 'number'],
                'buyer' => ['required', 'text', 'max:20'],
                'receipt_id' => ['required', 'text'],
                'items' => ['required', 'text'],
                'buyer_email' => ['required', 'email'],
                'note' => ['required', 'unicode', 'max_words:30'],
                'phone' => ['required', 'text'],
                'city' => ['required', 'text'],
            ]);
            if (!empty($errors)) {
                echo json_encode(['success' => false, 'errors' => $errors]);
                return;
            }

            $data = [
                'amount' => filter_var(trim($_POST['amount']), FILTER_SANITIZE_NUMBER_INT),
                'buyer' => filter_var(trim($_POST['buyer']), FILTER_SANITIZE_STRING),
                'receipt_id' => filter_var(trim($_POST['receipt_id']), FILTER_SANITIZE_STRING),
                'items' => filter_var(trim($_POST['items']), FILTER_SANITIZE_STRING),
                'buyer_email' => filter_var(trim($_POST['buyer_email']), FILTER_SANITIZE_EMAIL),
                'note' => filter_var(trim($_POST['note']), FILTER_SANITIZE_STRING),
                'phone' => filter_var(trim($_POST['phone']), FILTER_SANITIZE_STRING),
                'city' => filter_var(trim($_POST['city']), FILTER_SANITIZE_STRING),
                'buyer_ip' => $_SERVER['REMOTE_ADDR'],
                'hash_key' => hash('sha512', $_POST['receipt_id'] . 'salt'),
                'entry_at' => date('Y-m-d'),
                'entry_by' => null,
            ];

            $response['success'] = $this->model->insert($data);


            echo successResponse($response, HTTP_CREATED);
        } catch (\Exception $exception) {
            echo errorResponse([
                'message' => $exception->getMessage()
            ], HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}
