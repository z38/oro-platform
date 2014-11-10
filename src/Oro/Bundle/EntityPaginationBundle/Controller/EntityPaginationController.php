<?php

namespace Oro\Bundle\EntityPaginationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

use Oro\Bundle\EntityPaginationBundle\Navigation\EntityPaginationNavigation;
use Oro\Bundle\EntityPaginationBundle\Navigation\NavigationResult;

class EntityPaginationController extends Controller
{
    /**
     * @Route("/first/{entityName}/{scope}/{routeName}", name="oro_entity_pagination_first")
     *
     * @param $entityName
     * @param $scope
     * @param $routeName
     * @return RedirectResponse
     */
    public function firstAction($entityName, $scope, $routeName)
    {
        return $this->getLink($entityName, $scope, $routeName, EntityPaginationNavigation::FIRST);
    }

    /**
     * @Route("/previous/{entityName}/{scope}/{routeName}", name="oro_entity_pagination_previous")
     *
     * @param $entityName
     * @param $scope
     * @param $routeName
     * @return RedirectResponse
     */
    public function previousAction($entityName, $scope, $routeName)
    {
        return $this->getLink($entityName, $scope, $routeName, EntityPaginationNavigation::PREVIOUS);
    }

    /**
     * @Route("/next/{entityName}/{scope}/{routeName}", name="oro_entity_pagination_next")
     *
     * @param $entityName
     * @param $scope
     * @param $routeName
     * @return RedirectResponse
     */
    public function nextAction($entityName, $scope, $routeName)
    {
        return $this->getLink($entityName, $scope, $routeName, EntityPaginationNavigation::NEXT);
    }

    /**
     * @Route("/last/{entityName}/{scope}/{routeName}", name="oro_entity_pagination_last")
     *
     * @param $entityName
     * @param $scope
     * @param $routeName
     * @return RedirectResponse
     */
    public function lastAction($entityName, $scope, $routeName)
    {
        return $this->getLink($entityName, $scope, $routeName, EntityPaginationNavigation::LAST);
    }

    /**
     * @param string $entityName
     * @param string $scope
     * @param string $routeName
     * @param string $navigation
     * @return RedirectResponse
     */
    protected function getLink($entityName, $scope, $routeName, $navigation)
    {
        $doctrineHelper = $this->get('oro_entity.doctrine_helper');
        $navigationService = $this->get('oro_entity_pagination.navigation');

        $params = $this->getRequest()->query->all();
        $identifier = $doctrineHelper->getSingleEntityIdentifierFieldName($entityName);

        if (!empty($params[$identifier])) {
            $identifierValue = $params[$identifier];
            $entity = $doctrineHelper->getEntityReference($entityName, $identifierValue);

            switch ($navigation) {
                case EntityPaginationNavigation::FIRST:
                    $result = $navigationService->getFirstIdentifier($entity, $scope);
                    break;
                case EntityPaginationNavigation::PREVIOUS:
                    $result = $navigationService->getPreviousIdentifier($entity, $scope);
                    break;
                case EntityPaginationNavigation::NEXT:
                    $result = $navigationService->getNextIdentifier($entity, $scope);
                    break;
                case EntityPaginationNavigation::LAST:
                    $result = $navigationService->getLastIdentifier($entity, $scope);
                    break;
            }

            /** @var NavigationResult $result */
            if ($result instanceof NavigationResult) {
                $entityId = $result->getId();
                if ($entityId) {
                    $params[$identifier] = $entityId;
                }

                $messageManager = $this->get('oro_entity_pagination.message_manager');

                if (!$result->isAvailable()) {
                    $messageManager->addFlashMessage(
                        'warning',
                        $messageManager->getNotAvailableMessage($entity, $scope)
                    );
                } elseif (!$result->isAccessible()) {
                    $messageManager->addFlashMessage(
                        'warning',
                        $messageManager->getNotAccessibleMessage($entity, $scope)
                    );
                }
            }
        }

        return $this->redirect($this->generateUrl($routeName, $params));
    }
}