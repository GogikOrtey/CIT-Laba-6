<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Connection;

class TaskController extends AbstractController
{

    /**
     * @Route("/task", methods={"POST"})
     */
    public function createTask(Connection $connection, Request $request): Response
    {
        $data = $request->request->all();

        $sql = 'INSERT INTO Задачи (IDпроекта, НазваниеЗадачи, ОписаниеЗадачи, ДатаНачала, ДатаОкончания, IDстатуса, IDприоритета) VALUES (?, ?, ?, ?, ?, ?, ?)';
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $data['IDпроекта']);
        $stmt->bindValue(2, $data['НазваниеЗадачи']);
        $stmt->bindValue(3, $data['ОписаниеЗадачи']);
        $stmt->bindValue(4, $data['ДатаНачала']);
        $stmt->bindValue(5, $data['ДатаОкончания']);
        $stmt->bindValue(6, $data['IDстатуса']);
        $stmt->bindValue(7, $data['IDприоритета']);
        $stmt->executeQuery();

        return new Response('', Response::HTTP_CREATED);
    }

    /**
     * @Route("/task/{id}", methods={"PUT"})
     */
    public function updateTask(Connection $connection, Request $request, $id): Response
    {
        $data = $request->request->all();

        $sql = 'UPDATE Задачи SET IDпроекта = ?, НазваниеЗадачи = ?, ОписаниеЗадачи = ?, ДатаНачала = ?, ДатаОкончания = ?, IDстатуса = ?, IDприоритета = ? WHERE IDзадачи = ?';
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $data['IDпроекта']);
        $stmt->bindValue(2, $data['НазваниеЗадачи']);
        $stmt->bindValue(3, $data['ОписаниеЗадачи']);
        $stmt->bindValue(4, $data['ДатаНачала']);
        $stmt->bindValue(5, $data['ДатаОкончания']);
        $stmt->bindValue(6, $data['IDстатуса']);
        $stmt->bindValue(7, $data['IDприоритета']);
        $stmt->bindValue(8, $id);
        $stmt->executeQuery();

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/task/{id}", methods={"GET"})
     */
    public function fetchTask(Connection $connection, $id): Response
    {
        $sql = 'SELECT * FROM Задачи WHERE IDзадачи = ?';
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $id);
        $result = $stmt->executeQuery();

        $task = $result->fetchAssociative();

        return $this->json($task);
    }

    /**
     * @Route("/task", methods={"GET"})
     */
    public function getTasks(Connection $connection): Response
    {
        $sql = 'SELECT * FROM Задачи';
        $stmt = $connection->prepare($sql);
        $result = $stmt->executeQuery();

        $tasks = $result->fetchAllAssociative();

        return $this->json($tasks);
    }

    /**
     * @Route("/task/{id}", methods={"DELETE"})
     */
    public function deleteTask(Connection $connection, $id): Response
    {
        $sql = 'DELETE FROM Задачи WHERE IDзадачи = ?';
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->executeQuery();

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
