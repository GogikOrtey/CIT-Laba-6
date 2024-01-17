<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Connection;

class PriorityController extends AbstractController
{

    /**
     * @Route("/priority", methods={"POST"})
     */
    public function createPriority(Connection $connection, Request $request): Response
    {
        $data = $request->request->all();

        $sql = 'INSERT INTO Приоритеты (НазваниеПриоритета) VALUES (?)';
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $data['НазваниеПриоритета']);
        $stmt->executeQuery();

        return new Response('', Response::HTTP_CREATED);
    }

    /**
     * @Route("/priority/{id}", methods={"PUT"})
     */
    public function updatePriority(Connection $connection, Request $request, $id): Response
    {
        $data = $request->request->all();

        $sql = 'UPDATE Приоритеты SET НазваниеПриоритета = ? WHERE IDприоритета = ?';
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $data['НазваниеПриоритета']);
        $stmt->bindValue(2, $id);
        $stmt->executeQuery();

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/priority/{id}", methods={"GET"})
     */
    public function fetchPriority(Connection $connection, $id): Response
    {
        $sql = 'SELECT * FROM Приоритеты WHERE IDприоритета = ?';
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $id);
        $result = $stmt->executeQuery();

        $priority = $result->fetchAssociative();

        return $this->json($priority);
    }

    /**
     * @Route("/priority", methods={"GET"})
     */
    public function getPriorities(Connection $connection): Response
    {
        $sql = 'SELECT * FROM Приоритеты';
        $stmt = $connection->prepare($sql);
        $result = $stmt->executeQuery();

        $priorities = $result->fetchAllAssociative();

        return $this->json($priorities);
    }

    /**
     * @Route("/priority/{id}", methods={"DELETE"})
     */
    public function deletePriority(Connection $connection, $id): Response
    {
        $sql = 'DELETE FROM Приоритеты WHERE IDприоритета = ?';
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->executeQuery();

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
