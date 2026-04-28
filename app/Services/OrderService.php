<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Lesson;
use App\Models\Exercise;
use App\Models\LessonOnRequest;
use App\Models\Chat;

class OrderService
{
    public function process($studente, $carrello): array
    {

        $order = Order::create([
            'student_id' => $studente->id,
        ]);

        $items = $carrello->contenuto();

        $rows = [];
        $total = 0;

        foreach ($items as $item) {
            $result = $this->handleItem($item, $order->id, $studente->id);

            if ($result === null) {
                continue;
            }

            $rows[] = $result['row'];
            $total += $result['price'];
        }

        return [
            'order' => $order,
            'rows' => $rows,
            'total' => $total,
        ];
    }

    private function handleItem($item, $orderId, $studentId): ?array
    {
        $type = $item->getTipoElemento();
        $id = $item->getId();

        return match ($type) {

            0 => $this->handleLesson($id, $orderId, $studentId),
            2 => $this->handleExercise($id, $orderId, $studentId),
            5 => $this->handleRequest($id, $orderId, $studentId),

            default => null,
        };
    }

    private function handleLesson($id, $orderId, $studentId): array
    {
        $lesson = Lesson::find($id);

        if (!$lesson) {
            return ['price' => 0, 'row' => null];
        }

        $this->createOrderProduct($orderId, $id, 0, $lesson->price);
        $this->createChat($id, 0, $studentId);

        return [
            'price' => $lesson->price,
            'row' => [
                'desc' => 'Lezione: ' . $lesson->title,
                'price' => $lesson->price,
                'qty' => 1,
                'total' => $lesson->price,
            ]
        ];
    }

    private function handleExercise($id, $orderId, $studentId): array
    {
        $ex = Exercise::find($id);

        if (!$ex) {
            return ['price' => 0, 'row' => null];
        }

        $this->createOrderProduct($orderId, $id, 2, $ex->price);
        $this->createChat($id, 2, $studentId);

        return [
            'price' => $ex->price,
            'row' => [
                'desc' => 'Esercizio: ' . $ex->title,
                'price' => $ex->price,
                'qty' => 1,
                'total' => $ex->price,
            ]
        ];
    }

    private function handleRequest($id, $orderId, $studentId): array
    {
        $req = LessonOnRequest::find($id);

        if (!$req) {
            return ['price' => 0, 'row' => null];
        }

        $req->update(['paid' => 1]);

        $this->createOrderProduct($orderId, $id, 5, $req->price);
        $this->createChat($id, 5, $studentId);

        return [
            'price' => $req->price,
            'row' => [
                'desc' => 'Richiesta: ' . $req->title,
                'price' => $req->price,
                'qty' => 1,
                'total' => $req->price,
            ]
        ];
    }

    private function createOrderProduct($orderId, $productId, $type, $price)
    {
        OrderProduct::create([
            'id_ordine' => $orderId,
            'id_prodotto' => $productId,
            'tipo_prodotto' => $type,
            'price' => $price
        ]);
    }

    private function createChat($productId, $type, $studentId)
    {
        Chat::create([
            'id_prodotto' => $productId,
            'tipo_prodotto' => $type,
            'id_studente' => $studentId
        ]);
    }
}
