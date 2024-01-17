<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\DBAL\Connection;

class RoleController extends AbstractController
{

    /**
     * @Route("/role", methods={"POST"})
     */
    public function createRole(Connection $connection, Request $request): Response
    {
        $data = $request->request->all();

        $sql = 'INSERT INTO Роли (НазваниеРоли, Описание) VALUES (?, ?)';
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $data['НазваниеРоли']);
        $stmt->bindValue(2, $data['Описание']);
        $stmt->executeQuery();

        return new Response('', Response::HTTP_CREATED);
    }

    /**
     * @Route("/role/{id}", methods={"PUT"})
     */
    public function updateRole(Connection $connection, Request $request, $id): Response
    {
        $data = $request->request->all();

        $sql = 'UPDATE Роли SET НазваниеРоли = ?, Описание = ? WHERE IDроли = ?';
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $data['НазваниеРоли']);
        $stmt->bindValue(2, $data['Описание']);
        $stmt->bindValue(3, $id);
        $stmt->executeQuery();

        return new Response('', Response::HTTP_NO_CONTENT);
    }

    /**
     * @Route("/role/{id}", methods={"GET"})
     */
    public function fetchRole(Connection $connection, $id): Response
    {
        $sql = 'SELECT * FROM Роли WHERE IDроли = ?';
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $id);
        $result = $stmt->executeQuery();

        $role = $result->fetchAssociative();

        return $this->json($role);
    }

    /**
     * @Route("/role", methods={"GET"})
     */
    public function getRoles(Connection $connection): Response
    {
        $sql = 'SELECT * FROM Роли';
        $stmt = $connection->prepare($sql);
        $result = $stmt->executeQuery();

        $roles = $result->fetchAllAssociative();

        return $this->json($roles);
    }

    /**
     * @Route("/role/{id}", methods={"DELETE"})
     */
    public function deleteRole(Connection $connection, $id): Response
    {
        $sql = 'DELETE FROM Роли WHERE IDроли = ?';
        $stmt = $connection->prepare($sql);
        $stmt->bindValue(1, $id);
        $stmt->executeQuery();

        return new Response('', Response::HTTP_NO_CONTENT);
    }
}
