<?php

namespace App\Models;

use Core\Model;
use Exception;
use PDO;
use PDOException;

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
            $sql = "SELECT * FROM " . $this->table;

            $whereConditions = [];
            $fromDate = $_GET['from_date'] ?? null;
            $toDate = $_GET['to_date'] ?? null;
            $entryBy = $_GET['entry_by'] ?? null;

            if (!empty($fromDate)) {
                $whereConditions[] = "entry_at >= :from_date";
            }

            if (!empty($toDate)) {
                $whereConditions[] = "entry_at <= :to_date";
            }

            if (!empty($entryBy)) {
                $whereConditions[] = "entry_by = :entry_by";
            }

            if (!empty($whereConditions)) {
                $sql .= " WHERE " . implode(' AND ', $whereConditions);
            }

            $sql .= " ORDER BY id DESC";
            $stmt = $conn->prepare($sql);

            if (!empty($fromDate)) {
                $stmt->bindParam(':from_date', $fromDate);
            }
            if (!empty($toDate)) {
                $stmt->bindParam(':to_date', $toDate);
            }
            if (!empty($entryBy)) {
                $stmt->bindParam(':entry_by', $entryBy);
            }

            if ($stmt->execute()) {
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    public function insert(array $data): bool
    {
        $conn = $this->connectDB();
        try {
            if (!$conn) {
                throw new Exception("Database connection failed.");
            }
            $conn->beginTransaction();
            $sql = "INSERT INTO {$this->table} (
                amount, buyer, receipt_id, items, buyer_email, buyer_ip, note, 
                city, phone, hash_key, entry_at, entry_by
            ) VALUES (
                :amount, :buyer, :receipt_id, :items, :buyer_email, :buyer_ip, :note, 
                :city, :phone, :hash_key, :entry_at, :entry_by
            )";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':amount', $data['amount'], PDO::PARAM_INT);
            $stmt->bindParam(':buyer', $data['buyer']);
            $stmt->bindParam(':receipt_id', $data['receipt_id']);
            $stmt->bindParam(':items', $data['items']);
            $stmt->bindParam(':buyer_email', $data['buyer_email']);
            $stmt->bindParam(':buyer_ip', $data['buyer_ip']);
            $stmt->bindParam(':note', $data['note']);
            $stmt->bindParam(':city', $data['city']);
            $stmt->bindParam(':phone', $data['phone']);
            $stmt->bindParam(':hash_key', $data['hash_key']);
            $stmt->bindParam(':entry_at', $data['entry_at']);
            $stmt->bindParam(':entry_by', $data['entry_by'], PDO::PARAM_INT);

            $stmt->execute();
            $conn->commit();

            return true;
        } catch (PDOException $e) {
            $conn->rollBack();
            error_log("Insert Error: " . $e->getMessage());
            return false;
        } catch (Exception $e) {
            $conn->rollBack();
            error_log("General Error: " . $e->getMessage());
            return false;
        }
    }

}
