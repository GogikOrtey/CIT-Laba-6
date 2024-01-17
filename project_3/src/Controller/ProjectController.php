<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Connection;

class ProjectController extends AbstractController
{

    /**
     * @Route("/project", methods={"POST"})
     */
    public function createProject(Connection $connection, Request $request): Response
    {
        $data = $request->request->all();

        $sql = 'INSERT INTO Проекты (НазваниеПроекта, ДатаНачала, ОжидаемаяДатаЗавершения, IDстатуса) VALUES (?, ?, ?, ?)';
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $data['НазваниеПроекта']);
        $stmt->bindValue(2, $data['ДатаНачала']);
        $stmt->bindValue(3, $data['ОжидаемаяДатаЗавершения']);
        $stmt->bindValue(4, $data['IDстатуса']);
        $stmt->executeQuery();

        return new Response('', Response::HTTP_CREATED);
    }

    /**
     * @Route("/project/{id}", methods={"PUT"})
     */
    public function updateProject(Connection $connection, Request $request, $id): Response
    {
        $data = $request->request->all();

        $sql = 'UPDATE Проекты SET НазваниеПроекта = ?, ДатаНачала = ?, ОжидаемаяДатаЗавершения = ?, IDстатуса = ? WHERE IDпроекта = ?';
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $data['НазваниеПроекта']);
        $stmt->bindValue(2, $data['ДатаНачала']);
        $stmt->bindValue(3, $data['ОжидаемаяДатаЗавершения']);
        $stmt->bindValue(4, $data['IDстатуса']);
        $stmt->bindValue(5, $id);
        $stmt->executeQuery();

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/project/{id}", methods={"GET"})
     */
    public function fetchProject(Connection $connection, $id): Response
    {
        $sql = 'SELECT * FROM Проекты WHERE IDпроекта = ?';
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $id);
        $result = $stmt->executeQuery();

        $project = $result->fetchAssociative();

        return $this->json($project);
    }

    /**
     * @Route("/project", methods={"GET"})
     */
    public function getProjects(Connection $connection): Response
    {
        $sql = 'SELECT * FROM Проекты';
        $stmt = $connection->prepare($sql);
        $result = $stmt->executeQuery();

        $projects = $result->fetchAllAssociative();

        return $this->json($projects);
    }

    /**
     * @Route("/project/{id}", methods={"DELETE"})
     */
    public function deleteProject(Connection $connection, $id): Response
    {
        $sql = 'DELETE FROM Проекты WHERE IDпроекта = ?';
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->executeQuery();

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
