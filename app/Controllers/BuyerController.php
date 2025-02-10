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
        $data = $this->model->getAll();
        echo successResponse(['data' => $data], HTTP_OK);
    }

    public function store(): void
    {
        try {
            $validator = new Validator();
            $errors = $validator->validate([
                'amount' => ['required', 'number'],
                'buyer' => ['required', 'text', 'max:20'],
                'receipt_id' => ['required', 'text'],
                'items' => ['required', 'array'],
                'buyer_email' => ['required', 'email'],
                'note' => ['required', 'unicode', 'max_words:30'],
                'phone' => ['required', 'phone'],
                'city' => ['required', 'text'],
                'entry_by' => ['required', 'number'],
            ]);

            if (!empty($errors)) {
                echo successResponse([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $errors
                ], UNPROCESSABLE_ENTITY);
                return;
            }

            if ($this->isSubmittedBefore()) {
                echo successResponse([
                    'success' => false,
                    'message' => 'You have already submitted within 24 hours.',
                    'errors' => []
                ], UNPROCESSABLE_ENTITY);
                return;
            }

            $data = $this->formatFormData();

            $response['success'] = $this->model->insert($data);

            echo successResponse($response, HTTP_CREATED);
        } catch (\Exception $exception) {
            echo errorResponse([
                'message' => $exception->getMessage()
            ], HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    private function formatFormData(): array
    {
        return [
            'amount'       => validateInt($_POST['amount']),
            'buyer'        => sanitizeText($_POST['buyer'] ?? ''),
            'receipt_id'   => sanitizeText($_POST['receipt_id'] ?? ''),
            'items'        => implode(', ', array_map('sanitizeText', $_POST['items'])),
            'buyer_email'  => validateEmail( $_POST['buyer_email']),
            'note'         => sanitizeText($_POST['note']),
            'phone'        => validateInt($_POST['phone']),
            'city'         => sanitizeText($_POST['city']),
            'buyer_ip'     => $_SERVER['REMOTE_ADDR'] ?? '',
            'hash_key'     => !empty($post['receipt_id']) ? hash('sha512', $post['receipt_id'] . 'test-salt') : '',
            'entry_at'     => date('Y-m-d'),
            'entry_by'     => validateInt($_POST['entry_by'] ?? ''),
        ];
    }

    private function isSubmittedBefore(): bool
    {
        if ($_COOKIE['formSubmitted']) {
            return true;
        }

        setcookie("formSubmitted", true, time() + (24 * 60 * 60), "/");

        return false;
    }
}
