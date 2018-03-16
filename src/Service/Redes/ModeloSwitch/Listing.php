<?php
namespace App\Service\Redes\ModeloSwitch;

use Doctrine\ORM\EntityManager;
use Symfony\Component\HttpFoundation\Request;

class Listing
{
    private $objEntityManager   = NULL;
    
    const DEFAULT_LIMIT = 100;
    
    public function __construct(EntityManager $objEntityManager)
    {
        $this->objEntityManager = $objEntityManager;
    }
    
    public function get(int $id)
    {
        try {
            $objModeloSwitchRepository = $this->objEntityManager->getRepository('App\Entity\Redes\ModeloSwitch');
            return $objModeloSwitchRepository->find($id);
        } catch (\RuntimeException $e){
            throw $e;
        } catch (\Exception $e){
            throw $e;
        }
    }
    
    public function list(Request $objRequest)
    {
        try {
            $objModeloSwitchRepository = $this->objEntityManager->getRepository('App\Entity\Redes\ModeloSwitch');
            $objQueryBuilder = $objModeloSwitchRepository->createQueryBuilder('modelo');
            
            $objQueryBuilder->select('modelo');
            $offset = $objRequest->get('offset', 0);
            $limit = $objRequest->get('limit', self::DEFAULT_LIMIT);
            
            if($objRequest->get('nome', NULL)){
                $objLike = $objQueryBuilder->expr()->like('LOWER(modelo.nome)', ':nome');
                $objQueryBuilder->andWhere($objLike);
                $objQueryBuilder->setParameter('nome', '%'.mb_strtolower($objRequest->get('nome', NULL)).'%');
            }
            
            if($objRequest->get('ativo', NULL)){
                $objEq = $objQueryBuilder->expr()->eq('modelo.ativo', ':ativo');
                $objQueryBuilder->andWhere($objEq);
                $objQueryBuilder->setParameter('ativo', $objRequest->get('ativo', NULL));
            }
            
            if($offset){
                $objQueryBuilder->setFirstResult( $offset );
            }
            
            if($limit){
                $objQueryBuilder->setMaxResults( $limit );
            }
            
            return $objQueryBuilder->getQuery()->execute();
        } catch (\RuntimeException $e){
            throw $e;
        } catch (\Exception $e){
            throw $e;
        }
    }
    
}

