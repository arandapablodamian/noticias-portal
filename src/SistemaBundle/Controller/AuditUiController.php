<?php

namespace SistemaBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
// use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use VouchedFor\AuditUiBundle\Controller\DefaultController as BaseController;
use Symfony\Component\HttpFoundation\Request;
// use Doctrine\ORM\QueryBuilder;
use DataDog\PagerBundle\Pagination;
use DataDog\AuditBundle\Entity\AuditLog;

class AuditUiController extends BaseController
{
    // public function filters(QueryBuilder $qb, $key, $val)
    // {
    //     switch ($key) {
    //         case 'history':
    //             if ($val) {
    //                 $orx = $qb->expr()->orX();
    //                 $orx->add('s.fk = :fk');
    //                 $orx->add('t.fk = :fk');

    //                 $qb->andWhere($orx);
    //                 $qb->setParameter('fk', intval($val));
    //             }
    //             break;
    //         case 'class':
    //             $orx = $qb->expr()->orX();
    //             $orx->add('s.class = :class');
    //             $orx->add('t.class = :class');

    //             $qb->andWhere($orx);
    //             $qb->setParameter('class', $val);
    //             break;
    //         case 'blamed':
    //             if ($val === 'null') {
    //                 $qb->andWhere($qb->expr()->isNull('a.blame'));
    //             } else {
    //                 // this allows us to safely ignore empty values
    //                 // otherwise if $qb is not changed, it would add where the string is empty statement.
    //                 $qb->andWhere($qb->expr()->eq('b.fk', ':blame'));
    //                 $qb->setParameter('blame', $val);
    //             }
    //             break;
    //         default:
    //             // if user attempts to filter by other fields, we restrict it
    //             throw new \Exception("filter not allowed");
    //     }
    // }

    /**
     * @Method("GET")
     * @Route("/audit", name="vouchedfor_audit_ui")
     */
    public function indexAction(Request $request)
    {
        Pagination::$defaults = array_merge(Pagination::$defaults,
            ['limit' => 25]);

        $em = $this->getDoctrine()->getManager();

        $qb = $em->getRepository("DataDogAuditBundle:AuditLog")
            ->createQueryBuilder('a')
            ->addSelect('s', 't', 'b')
            ->innerJoin('a.source', 's')
            ->leftJoin('a.target', 't')
            ->leftJoin('a.blame', 'b');

        $options = [
            'sorters' => ['a.loggedAt' => 'DESC'],
            'applyFilter' => [$this, 'filters'],
        ];

        $sourceClasses = [
            Pagination::$filterAny => 'Todas las secciones',
        ];

        foreach ($this->getDoctrine()
                     ->getManager()
                     ->getMetadataFactory()
                     ->getAllMetadata() as $meta) {
            if ($meta->isMappedSuperclass || strpos($meta->name,
                    'DataDog\AuditBundle') === 0
            ) {
                continue;
            }
            $parts = explode('\\', $meta->name);
            $sourceClasses[$meta->name] = end($parts);
        }

        $users = [
            Pagination::$filterAny => 'Todos los usuarios',
            'null' => 'Anónimo',
        ];
        foreach ($em->getRepository($this->getParameter('vouchedfor_audit_ui.user_class'))->findAll() as $user) {
            $users[$user->getId()] = (string)$user;
        }

        $logs = new Pagination($qb, $request, $options);

        return $this->render('VouchedForAuditUiBundle:Default:index.html.twig', array(
            'logs' => $logs,
            'sourceClasses' => $sourceClasses,
            'users' => $users,
        ));
        // return compact('logs', 'sourceClasses', 'users');
    }


    /**
     * @Route("/audit/diff/{id}", name="vouchedfor_audit_ui_diff")
     * @Method("GET")
     */
    public function diffAction(AuditLog $log)
    {
          return $this->render('VouchedForAuditUiBundle:Default:diff.html.twig', array(
            'log' => $log
        ));
    }
}