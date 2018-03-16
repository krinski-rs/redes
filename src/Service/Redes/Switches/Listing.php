<?php
namespace App\Service\Redes\Switches;

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
            $objSwitchesRepository = $this->objEntityManager->getRepository('App\Entity\Redes\Switches');
            return $objSwitchesRepository->find($id);
        } catch (\RuntimeException $e){
            throw $e;
        } catch (\Exception $e){
            throw $e;
        }
    }
    
    public function list(Request $objRequest)
    {
        try {
            $objSwitchesRepository = $this->objEntityManager->getRepository('App\Entity\Redes\Switches');
            $objQueryBuilder = $objSwitchesRepository->createQueryBuilder('switches');
            
            $objQueryBuilder->select('switches')
                            ->innerJoin('switches.modeloSwitch', 'modelo');
            $offset = $objRequest->get('offset', 0);
            $limit = $objRequest->get('limit', self::DEFAULT_LIMIT);
            
            if($objRequest->get('nome', NULL)){
                $objLike = $objQueryBuilder->expr()->like('LOWER(switches.nome)', ':nome');
                $objQueryBuilder->andWhere($objLike);
                $objQueryBuilder->setParameter('nome', '%'.mb_strtolower($objRequest->get('nome', NULL)).'%');
            }
            
            if($objRequest->get('ip', NULL)){
                $objEq = $objQueryBuilder->expr()->eq('switches.ip', ':ip');
                $objQueryBuilder->andWhere($objEq);
                $objQueryBuilder->setParameter('ip', $objRequest->get('ip', NULL));
            }
            
            if($objRequest->get('vlanBase', NULL)){
                $objEq = $objQueryBuilder->expr()->eq('switches.vlanBase', ':vlanBase');
                $objQueryBuilder->andWhere($objEq);
                $objQueryBuilder->setParameter('vlanBase', $objRequest->get('vlanBase', NULL));
            }
            
            if($objRequest->get('ativo', NULL)){
                $objEq = $objQueryBuilder->expr()->eq('switches.ativo', ':ativo');
                $objQueryBuilder->andWhere($objEq);
                $objQueryBuilder->setParameter('ativo', $objRequest->get('ativo', NULL));
            }
            
            if($objRequest->get('modeloSwitchId', NULL)){
                $objEq = $objQueryBuilder->expr()->eq('modelo.id', ':modeloSwitchId');
                $objQueryBuilder->andWhere($objEq);
                $objQueryBuilder->setParameter('modeloSwitchId', $objRequest->get('modeloSwitchId', NULL));
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

