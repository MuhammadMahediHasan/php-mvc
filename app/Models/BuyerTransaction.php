<?php

namespace App\Models;

use Core\Model;
use PDO;

class BuyerTransaction extends Model
{
    function __construct()
    {
        parent::__construct('buyer_transactions');
    }

    public function getAll(): ?array
    {
        $conn = $this->connectDB();
        $result = null;

        if ($conn) {
            $sql = "SELECT * FROM " . $this->table . " ORDER BY id DESC";
            $resource = $conn->query($sql);
            if ($resource) {
                $result = $resource->fetchAll(PDO::FETCH_ASSOC);
            }
        }

        return $result;
    }

    /**
     * @param int $id
     * @return array|mixed
     */
    public function find(int $id): mixed
    {
        $conn = $this->connectDB();
        $result = array();

        if ($conn) {
            $sql = "SELECT * FROM " . $this->table . " WHERE id = " . $id;
            $resource = $conn->query($sql);
            $result = $resource->fetchAll(PDO::FETCH_ASSOC);
        }
        return $result ? $result[0] : array();
    }

    public function insert($data = array()): bool
    {
        $conn = $this->connectDB();
        $result = false;

        if ($conn) {
            $sql = "INSERT INTO {$this->table} (
                amount, buyer, receipt_id, items, buyer_email, buyer_ip, note, 
                city, phone, hash_key, entry_at, entry_by
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            $result = $conn->prepare($sql)->execute([
                $data['amount'],
                $data['buyer'],
                $data['receipt_id'],
                $data['items'],
                $data['buyer_email'],
                $data['buyer_ip'],
                $data['note'],
                $data['city'],
                $data['phone'],
                $data['hash_key'],
                $data['entry_at'],
                $data['entry_by']
            ]);

        }
        return $result;
    }
}
